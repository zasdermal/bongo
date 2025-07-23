<?php

namespace Module\Market\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Module\Market\Models\Area;
use Module\Market\Models\Territory;

class TerritoryController extends Controller
{
    public const IS_ACTIVES = [
        'Active',
        'Inactive'
    ];

    public function territories(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Location', 'url' => null],
            ['title' => 'Territories', 'url' => null]
        ];

        $data['is_actives'] = self::IS_ACTIVES;
        $data['sub_areas'] = Area::where('is_active', 'Active')->orderBy('id', 'desc')->get();

        $query = Territory::query();

        if ($request->filled('is_active')) {
            $is_active = $request->is_active;
            $query->where('is_active', $is_active);
        }

        $data['territories'] = $query->orderBy('id', 'desc')->paginate(20);

        return view('Market::territories.list', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'sub_area_id' => 'nullable',
            'name' => 'required|string|unique:territories|max:255'
        ]);

        Territory::create([
            'sub_area_id' => $data['sub_area_id'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name'])
        ]);

        return redirect()->route('location.territories')->with('success', 'Territory added successfully');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'name' => 'nullable|unique:zone,name',
            'is_active' => 'nullable|in:Active,Inactive'
        ]);

        $territory = Territory::find($id);

        if ($territory) {
            $territory->update([
                'user_id' => $data['user_id'] ?? $territory->user_id,
                'name' => $data['name'] ?? $territory->name,
                'is_active' => $data['is_active'] ?? $territory->is_active
            ]);
        }

        return redirect()->back()->with('success', 'Territory updated successfully');
    }

    public function associated_territories_for_(Request $request, $sub_area_id)
    {
        $sub_area = SubArea::with('territories')->find($sub_area_id);
        $data['territories'] = $sub_area->territories;

        return response()->json([
            'territories' => $data['territories'],
        ]);
    }

    public function design(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Location', 'url' => null],
            ['title' => 'Design', 'url' => null]
        ];
        $data['zones'] = Zone::all();
        $data['regions'] = Region::all();
        $data['areas'] = Area::all();
        $data['sub_areas'] = SubArea::all();
        $data['territories'] = Territory::where('is_active', 'Active')->get();

        $data['territory_employees'] = Employee::whereHas('designation', function ($query) {
            $query->where('slug', 'product-associate')
                ->where('territory_id', null);
        })->get();

        $data['sub_area_employees'] = Employee::whereHas('designation', function ($query) {
            $query->where('slug', 'sr-product-associate')
                ->where('sub_area_id', null);
        })->get();

        $data['area_employees'] = Employee::whereHas('designation', function ($query) {
            $query->where('slug', 'area-manager')
                ->where('area_id', null);
        })->get();

        $data['region_employees'] = Employee::whereHas('designation', function ($query) {
            $query->where('slug', 'regional-sells-manager')
                ->where('region_id', null);
        })->get();

        $data['zone_employees'] = Employee::whereHas('designation', function ($query) {
            $query->where('slug', 'national-sells-manager')
                ->where('zone_id', null);
        })->get();

        // $employeeTypes = [
        //     'territory_employees' => ['slug' => 'product-associate', 'column' => 'territory_id'],
        //     'sub_area_employees' => ['slug' => 'sr-product-associate', 'column' => 'sub_area_id'],
        //     'area_employees' => ['slug' => 'area-manager', 'column' => 'area_id'],
        // ];
        
        // $data = [];
        
        // foreach ($employeeTypes as $key => $conditions) {
        //     $data[$key] = Employee::whereHas('designation', function ($query) use ($conditions) {
        //         $query->where('slug', $conditions['slug'])
        //               ->where($conditions['column'], null);
        //     })->get();
        // }

        return view('location.design', $data);
    }

    // for api response
    public function territory_list(Request $request)
    {
        try {
            // Retrieve territories
            $territories = Territory::where('is_active', 'active')->orderBy('id', 'desc')->get();

            // Check if any territories are found
            if ($territories->isEmpty()) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'No active territories found.'
                ], 404);
            }

            // Serialize territories using a foreach loop
            $serializeTerritories = [];
            foreach ($territories as $territory) {
                if ($territory->user) {
                    $associated_emp = $territory->user->employee->name . ' (' . $territory->user->username . ')';
                } else {
                    $associated_emp = 'Not Associated';
                }
                
                $serializeTerritories[] = [
                    'territory_id' => $territory->id,
                    'sub_area_id' => $territory->sub_area->id,
                    'associated_emp' => $associated_emp,
                    'name' => $territory->name
                ];
            }

            // Return successful response
            return response()->json([
                'status' => 'Success',
                'data' => $serializeTerritories,
                'message' => 'Territories retrieved successfully.'
            ], 200);

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error retrieving territories: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'status' => 'Error',
                'message' => 'Failed to retrieve territories.',
                'error' => $e->getMessage() // Optionally include the error message in development
            ], 500);
        }
    }
}
