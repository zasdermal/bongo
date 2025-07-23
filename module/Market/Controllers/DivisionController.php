<?php

namespace Module\Market\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Module\Market\Models\Zone;
use Module\Market\Models\Division;

class DivisionController extends Controller
{
    public const IS_ACTIVES = [
        'Active',
        'Inactive'
    ];

    public function divisions(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Location', 'url' => null],
            ['title' => 'divisions', 'url' => null]
        ];

        $data['is_actives'] = self::IS_ACTIVES;
        $data['zones'] = Zone::where('is_active', 'Active')->orderBy('id', 'desc')->get();

        $query = Division::query();

        if ($request->filled('is_active')) {
            $is_active = $request->is_active;
            $query->where('is_active', $is_active);
        }

        $data['divisions'] = $query->orderBy('id', 'desc')->paginate(20);

        return view('Market::divisions.list', $data);
    }

    public function store(Request $request)
    {
        $validated_sub_area = $request->validate([
            'area_id' => 'required',
            'name' => 'required|string|unique:sub_areas|max:255'
        ]);

        SubArea::create([
            'area_id' => $validated_sub_area['area_id'],
            'name' => $validated_sub_area['name'],
            'slug' => Str::slug($validated_sub_area['name'])
        ]);

        return redirect()->route('location.sub_areas')->with('success', 'Sub area added successfully');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'name' => 'nullable|unique:zone,name',
            'is_active' => 'nullable|in:Active,Inactive'
        ]);

        $sub_area = SubArea::find($id);

        if ($sub_area) {
            $sub_area->update([
                'user_id' => $data['user_id'] ?? $sub_area->user_id,
                'name' => $data['name'] ?? $sub_area->name,
                'is_active' => $data['is_active'] ?? $sub_area->is_active
            ]);
        }

        return redirect()->back()->with('success', 'Sub Area updated successfully');
    }

    public function associated_sub_areas_for_(Request $request, $area_id)
    {
        $area = Area::with('sub_areas')->find($area_id);
        $data['sub_areas'] = $area->sub_areas;

        return response()->json([
            'sub_areas' => $data['sub_areas'],
        ]);
    }

    public function associated_region_zone_area_by_sub_area_(Request $request, $id)
    {
        $data['region_zone_area'] = SubArea::where('id', $id)
        ->with('area.region.zone')
        ->first();

        return response()->json([
            'region_zone_area' => $data['region_zone_area'],
        ]);
    }

    // for api response
    public function sub_area_list(Request $request)
    {
        try {
            // Retrieve sub areas
            $sub_areas = SubArea::where('is_active', 'active')->orderBy('id', 'desc')->get();

            // Check if any sub areas are found
            if ($sub_areas->isEmpty()) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'No active sub areas found.'
                ], 404);
            }

            // Serialize sub areas using a foreach loop
            $serializeSubAreas = [];
            foreach ($sub_areas as $sub_area) {
                if ($sub_area->user) {
                    $associated_emp = $sub_area->user->employee->name . ' (' . $sub_area->user->username . ')';
                } else {
                    $associated_emp = 'Not Associated';
                }
                
                $serializeSubAreas[] = [
                    'sub_area_id' => $sub_area->id,
                    'area_id' => $sub_area->area->id,
                    'associated_emp' => $associated_emp,
                    'name' => $sub_area->name
                ];
            }

            // Return successful response
            return response()->json([
                'status' => 'Success',
                'data' => $serializeSubAreas,
                'message' => 'Sub areas retrieved successfully.'
            ], 200);

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error retrieving sub areas: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'status' => 'Error',
                'message' => 'Failed to retrieve sub areas.',
                'error' => $e->getMessage() // Optionally include the error message in development
            ], 500);
        }
    }
}
