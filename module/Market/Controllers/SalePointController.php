<?php

namespace Module\Market\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Module\Market\Models\SalePoint;
use Module\Market\Models\Territory;

use PhpOffice\PhpSpreadsheet\IOFactory;

class SalePointController extends Controller
{
    public function salePoints(Request $request)
    {
        $this->authorize('read', SalePoint::class);

        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Sale Points', 'url' => null]
        ];

        $query = SalePoint::query();
        $data['territories'] = Territory::all();

        if ($request->filled('code_number')) {
            $code_number = $request->code_number;
            $query->where('code_number', $code_number);
        }

        $data['salePoints'] = $query->orderBy('id', 'desc')->paginate(30);

        return view('Market::salePoints.list', $data);
    }

    public function store(Request $request)
    {
        $this->authorize('create', SalePoint::class);

        $data = $request->validate([
            'territory_id' => 'nullable|exists:territories,id',
            'name' => 'required|string',
            'address' => 'nullable|string',
            'contact_name' => 'nullable|string',
            'contact_number' => 'nullable|numeric'
        ]);

        SalePoint::create([
            'territory_id' => $data['territory_id'],
            'name' => Str::title($data['name']),
            'code_number' => $this->generate_unique_code_number(),
            'address' => $data['address'],
            'contact_name' => Str::title($data['contact_name']),
            'contact_number' => $data['contact_number']
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sale point added successfully',
        ]);
    }

    public function salePoint($id)
    {
        $this->authorize('update', SalePoint::class);

        $salePoint = SalePoint::findOrFail($id);

        return response()->json([
            'salePoint' => $salePoint
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update', SalePoint::class);

        $salePoint = SalePoint::findOrFail($id);

        $data = $request->validate([
            'territory_id' => 'nullable|exists:territories,id',
            'name' => 'sometimes|required|string',
            'address' => 'nullable|string',
            'contact_name' => 'nullable|string',
            'contact_number' => 'nullable|numeric',
            'is_active' => 'nullable|in:Active,Inactive'
        ]);

        $salePoint->update([
            'territory_id' => $data['territory_id'] ?? $salePoint->territory_id,
            'name' => isset($data['name']) ? Str::title($data['name']) : $salePoint->name,
            'address' => $data['address'] ?? $salePoint->address,
            'contact_name' => isset($data['contact_name']) ? Str::title($data['contact_name']) : $salePoint->contact_name,
            'contact_number' => $data['contact_number'] ?? $salePoint->contact_number,
            'is_active' => $data['is_active'] ?? $salePoint->is_active
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Sale point updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('delete', SalePoint::class);

        $salePoint = SalePoint::findOrFail($id);
        $salePoint->delete();

        return response()->json([
            'status' => true,
            'message' => 'Sale point deleted successfully',
        ]);
    }

    public function bulk_upload_salePoints(Request $request)
    {
        $this->authorize('create', SalePoint::class);
        
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        try {
            $file = $request->file('file');
            $spreadsheet = IOFactory::load($file->getPathname());
            $sheet = $spreadsheet->getActiveSheet();
            $rows = $sheet->toArray();

            if (empty($rows) || count($rows) < 2) {
                return response()->json([
                    'status' => false,
                    'message' => 'File is empty or missing data rows.',
                ], 422);
            }

            $header = array_map('strtolower', $rows[0]);
            $inserted = 0;

            for ($i = 1; $i < count($rows); $i++) {
                $rowData = array_combine($header, $rows[$i]);

                SalePoint::create([
                    'territory_id' => $rowData['territory_id'] ?? null,
                    'name' => $rowData['name'] ?? null,
                    'code_number' => $rowData['code_number'] ?? null,
                    'address' => $rowData['address'] ?? null,
                    'contact_name' => $rowData['contact_name'] ?? null,
                    'contact_number' => $rowData['contact_number'] ?? null,
                    'is_active' => $rowData['is_active'] ?? 'Inactive',
                ]);

                $inserted++;
            }

            return response()->json([
                'status' => true,
                'message' => "File uploaded successfully! Total inserted: {$inserted}",
            ]);
            
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error uploading file: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function salePoint_by_territory_(Request $request, $id)
    {
        $sale_points = SalePoint::where('territory_id', $id)->get();

        return response()->json([
            'sale_points' => $sale_points,
        ]);
    }

    // API
    public function salePoints_by_territory(Request $request)
    {
        try {
            $territoryIds = collect(); // Store allowed territory IDs

            if ($request->filled('region_id') && $request->region_id != 0) {
                $region_id = $request->region_id;
                $territoryIds = Territory::whereHas('area.region', function ($query) use ($region_id) {
                    $query->where('id', $region_id);
                })->pluck('id');
            }

            if ($request->filled('area_id') && $request->area_id != 0) {
                $area_id = $request->area_id;
                $territoryIds = Territory::whereHas('area', function ($query) use ($area_id) {
                    $query->where('id', $area_id);
                })->pluck('id');
            }

            if ($request->filled('territory_id') && $request->territory_id != 0) {
                $territory_id = $request->territory_id;
                $territoryIds = collect([$territory_id]);
            }

            $serializeData = [];

            // Fetch and format sales points data
            $salePoints = SalePoint::where('is_active', 'Active')
                ->whereIn('territory_id', $territoryIds)
                // ->whereHas('territories', function ($query) use ($territoryIds) {
                //     if ($territoryIds->isNotEmpty()) {
                //         $query->whereIn('territory_id', $territoryIds);
                //     }
                // })
                ->orderBy('id', 'desc')
                ->get();

            foreach ($salePoints as $salePoint) {
                $serializeData[] = [
                    'sale_point_id' => $salePoint->id,
                    'territory_id' => $salePoint->territory->id,
                    'area_id' => $salePoint->territory->area->id,
                    'region_id' => $salePoint->territory->area->region->id,
                    'sale_point_name' => $salePoint->name,
                    'code_number' => $salePoint->code_number,
                    'address' => $salePoint->address,
                    'contact_number' => $salePoint->contact_number,
                ];
            }

            return response()->json([
                'status' => 'SUCCESS',
                'count' => $salePoints->count(),
                'data' => $serializeData,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'ERROR',
                'message' => 'Failed to retrieve data.',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    // helper
    private function generate_unique_code_number()
    {
        $code_number = $this->code_number();

        $existing_check = SalePoint::where('code_number', $code_number)->first();

        if ($existing_check) {
            return $this->generate_unique_code_number();
        }

        return $code_number;
    }

    private function code_number()
    {
        $date = now();
        $year = substr($date->year, -2);
        $month = str_pad($date->month, 2, '0', STR_PAD_LEFT);
        $day = str_pad($date->day, 2, '0', STR_PAD_LEFT);

        return 'S' . $year . $month . $day . rand(0, 999);
    }
}
