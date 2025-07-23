<?php

namespace Module\Market\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Module\Market\Models\Zone;
use Module\Market\Models\Region;

class RegionController extends Controller
{
    public const IS_ACTIVES = [
        'Active',
        'Inactive'
    ];

    public function regions(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Location', 'url' => null],
            ['title' => 'Regions', 'url' => null]
        ];

        $data['is_actives'] = self::IS_ACTIVES;
        $data['zones'] = Zone::where('is_active', 'Active')->orderBy('id', 'desc')->get();

        $data['regions'] = Region::orderBy('id', 'desc')->get();

        return view('Market::regions.list', $data);
    }

    public function store(Request $request)
    {
        $validated_region = $request->validate([
            'zone_id' => 'required',
            'name' => 'required|string|unique:regions|max:255'
        ]);

        Region::create([
            'zone_id' => $validated_region['zone_id'],
            'name' => $validated_region['name'],
            'slug' => Str::slug($validated_region['name'])
        ]);

        return redirect()->route('location.regions')->with('success', 'Region added successfully');
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'name' => 'nullable|unique:zone,name',
            'is_active' => 'nullable|in:Active,Inactive'
        ]);

        $region = Region::find($id);

        if ($region) {
            $region->update([
                'user_id' => $data['user_id'] ?? $region->user_id,
                'name' => $data['name'] ?? $region->name,
                'is_active' => $data['is_active'] ?? $region->is_active
            ]);
        }

        return redirect()->back()->with('success', 'Region updated successfully');
    }

    public function associated_zone_by_region_($id)
    {
        $region = Region::find($id);
        $data['zone'] = $region->zone;

        return response()->json([
            'zone' => $data['zone'],
        ]);
    }

    // for api response
    public function region_list(Request $request)
    {
        try {
            // Retrieve regions
            $regions = Region::where('is_active', 'active')->orderBy('id', 'desc')->get();

            // Check if any regions are found
            if ($regions->isEmpty()) {
                return response()->json([
                    'status' => 'Error',
                    'message' => 'No active regions found.'
                ], 404);
            }

            // Serialize regions using a foreach loop
            $serializeRegions = [];
            foreach ($regions as $region) {
                if ($region->user) {
                    $associated_emp = $region->user->employee->name . ' (' . $region->user->username . ')';
                } else {
                    $associated_emp = 'Not Associated';
                }
                
                $serializeRegions[] = [
                    'region_id' => $region->id,
                    'zone_id' => $region->zone->id,
                    'associated_emp' => $associated_emp,
                    'name' => $region->name
                ];
            }

            // Return successful response
            return response()->json([
                'status' => 'Success',
                'data' => $serializeRegions,
                'message' => 'Regions retrieved successfully.'
            ], 200);

        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error('Error retrieving regions: ' . $e->getMessage());

            // Return error response
            return response()->json([
                'status' => 'Error',
                'message' => 'Failed to retrieve regions.',
                'error' => $e->getMessage() // Optionally include the error message in development
            ], 500);
        }
    }
}
