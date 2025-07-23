<?php

namespace Module\Market\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Module\Market\Models\Area;
use Module\Market\Models\Region;

class AreaController extends Controller
{
    public const IS_ACTIVES = [
        'Active',
        'Inactive'
    ];

    public function areas(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Location', 'url' => null],
            ['title' => 'Areas', 'url' => null]
        ];

        $data['is_actives'] = self::IS_ACTIVES;
        $data['regions'] = Region::where('is_active', 'Active')->orderBy('id', 'desc')->get();

        $query = Area::query();

        if ($request->filled('is_active')) {
            $is_active = $request->is_active;
            $query->where('is_active', $is_active);
        }

        $data['areas'] = $query->orderBy('id', 'desc')->paginate(20);

        return view('Market::areas.list', $data);
    }

    public function store(Request $request)
    {
        $validated_area = $request->validate([
            'depot_id' => 'required',
            'region_id' => 'required',
            'name' => 'required|string|unique:areas|max:255'
        ]);

        Area::create([
            'depot_id' => $validated_area['depot_id'],
            'region_id' => $validated_area['region_id'],
            'name' => $validated_area['name'],
            'slug' => Str::slug($validated_area['name'])
        ]);

        return redirect()->route('location.areas')->with('success', 'Area added successfully');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'name' => 'nullable|unique:zone,name',
            'is_active' => 'nullable|in:Active,Inactive'
        ]);

        $area = Area::find($id);

        if ($area) {
            $area->update([
                'user_id' => $data['user_id'] ?? $area->user_id,
                'name' => $data['name'] ?? $area->name,
                'is_active' => $data['is_active'] ?? $area->is_active
            ]);
        }

        return redirect()->back()->with('success', 'Area updated successfully');
    }

    public function associated_region_zone_by_area_($id)
    {
        $data['region_zone'] = Area::where('id', $id)
        ->with('region.zone')
        ->first();

        return response()->json([
            'region_zone' => $data['region_zone'],
        ]);
    }

    // for api response
    public function area_list(Request $request)
    {
        try {
            // Retrieve areas
            $areas = Area::where('is_active', 'active')->orderBy('id', 'desc')->get();

            // Check if any areas are found
            if ($areas->isEmpty()) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'No active areas found.'
                ], 404);
            }

            // Serialize areas using a foreach loop
            $serializeAreas = [];
            foreach ($areas as $area) {
                if ($area->user) {
                    $associated_emp = $area->user->employee->name . ' (' . $area->user->username . ')';
                } else {
                    $associated_emp = 'Not Associated';
                }
                
                $serializeAreas[] = [
                    'area_id' => $area->id,
                    'region_id' => $area->region->id,
                    'associated_emp' => $associated_emp,
                    'name' => $area->name
                ];
            }

            // Return successful response
            return response()->json([
                'status' => 'Success',
                'data' => $serializeAreas,
                'message' => 'Areas retrieved successfully.'
            ], 200);

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error retrieving areas: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'status' => 'Error',
                'message' => 'Failed to retrieve areas.',
                'error' => $e->getMessage() // Optionally include the error message in development
            ], 500);
        }
    }
}
