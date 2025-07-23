<?php

namespace Module\Market\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Module\Market\Models\Zone;
use Module\Access\Models\User;
use Module\Access\Models\Employee;

class ZoneController extends Controller
{
    public function zones(Request $request)
    {
        $this->authorize('read', Zone::class);

        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Location', 'url' => null],
            ['title' => 'Zones', 'url' => null]
        ];

        $data['zones'] = Zone::orderBy('id', 'desc')->get();
        $data['users'] = User::whereHas('employee.designation', function ($query) {
            $query->where('slug', 'sells-manager');
        })
        ->get();

        return view('Market::zones.list', $data);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Zone::class);

        $data = $request->validate([
            'name' => 'required|string|unique:zones|max:255',
            'description' => 'nullable'
        ]);

        Zone::create([
            'name' => Str::title($data['name']),
            'slug' => Str::slug($data['name']),
            'description' => $data['description'] ?? null
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Zone added successfully',
        ]);
    }

    public function zone($id)
    {
        $this->authorize('update', Zone::class);

        $zone = Zone::with('user')->findOrFail($id);

        return response()->json([
            'zone' => $zone
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update', Zone::class);

        $zone = Zone::findOrFail($id);

        $data = $request->validate([
            'name' => 'sometimes|required|unique:zones,name,' . $id,
            'user_id' => 'nullable|exists:users,id|unique:zones,user_id,' . $id,
            'description' => 'nullable',
            'is_active' => 'nullable|in:Active,Inactive'
        ]);

        $updateZone = [
            'name' => isset($data['name']) ? Str::title($data['name']) : $zone->name,
            'slug' => isset($data['name']) ? Str::slug($data['name']) : $zone->slug,
            'is_active' => $data['is_active'] ?? $zone->is_active,
        ];

        if (array_key_exists('user_id', $data)) {
            $updateZone['user_id'] = $data['user_id'];
        }

        $zone->update($updateZone);


        if (array_key_exists('user_id', $data)) {
            if (isset($data['user_id'])) {
                $employee_by_zone = Employee::where('zone_id', $zone->id)->first();
                if ($employee_by_zone) {
                    $employee_by_zone->update([
                        'zone_id' => null
                    ]);
                }

                $employee_by_user = Employee::where('user_id', $data['user_id'])->first();
                $employee_by_user->update([
                    'zone_id' => $zone->id
                ]);
            } else {
                $employee = Employee::where('zone_id', $zone->id)->first();
                $employee->update([
                    'zone_id' => null
                ]);
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'Zone updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('delete', Zone::class);

        $zone = Zone::findOrFail($id);
        $zone->delete();

        return response()->json([
            'success' => true,
            'message' => 'Zone deleted successfully',
        ]);
    }
}
