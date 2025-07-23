<?php

namespace Module\Access\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\View\View;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use Module\Access\Models\Role;
use Module\Access\Models\User;
use Module\Access\Models\Employee;
use Module\Access\Models\Designation;

use Module\Market\Models\Area;
use Module\Market\Models\Zone;
use Module\Market\Models\Region;
use Module\Market\Models\Division;
use Module\Market\Models\Territory;


class UserController extends Controller
{
    public function users(Request $request): View
    {
        $this->authorize('read', User::class);

        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'User Management', 'url' => null],
            ['title' => 'Users', 'url' => null],
        ];

        $query = User::query();
        $data['roles'] = Role::all();
        $data['areas'] = Area::all();
        $data['zones'] = Zone::all();
        $data['regions'] = Region::all();
        $data['divisions'] = Division::all();
        $data['territories'] = Territory::all();
        $data['designations'] = Designation::all();

        if ($request->filled('is_active')) {
            $is_active = $request->is_active;
            $query->where('is_active', $is_active);
        }

        if ($request->filled('username')) {
            $username = $request->username;
            $query->where('username', $username);
        }

        $data['users'] = $query->orderBy('id', 'desc')->paginate(20);

        return view('Access::users.list', $data);
    }

    public function store(Request $request): JsonResponse
    {
        $this->authorize('create', User::class);

        $data = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'username' => 'required|unique:users|max:255',
            'name' => 'required|string|max:255',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'role_id'=> $data['role_id'],
            'username' => $data['username'],
            'name' => Str::title($data['name']),
            'password' => Hash::make($data['password']),
        ]);
        
        Employee::create([
            'user_id' => $user->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'User added successfully',
        ]);
    }

    public function user($id)
    {
        $this->authorize('update', User::class);

        $user = User::with(
            'employee',
            'employee.zone'
        )->findOrFail($id);

        return response()->json([
            'user' => $user
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update', User::class);

        $user = User::findOrFail($id);

        $data = $request->validate([
             // User table fields
            'role_id' => 'sometimes|required|exists:roles,id',
            'name' => 'sometimes|required|string|max:255',
            'is_active' => 'nullable|in:Active,Inactive',
            // Employee table fields
            'designation_id' => 'nullable|exists:designations,id',
            'zone_id' => 'nullable|exists:zones,id|unique:employees,zone_id,' . optional($user->employee)->id,
            'division_id' => 'nullable|exists:divisions,id|unique:employees,division_id,' . optional($user->employee)->id,
            'region_id' => 'nullable|exists:regions,id|unique:employees,region_id,' . optional($user->employee)->id,
            'area_id' => 'nullable|exists:areas,id|unique:employees,area_id,' . optional($user->employee)->id,
            'territory_id' => 'nullable|exists:territories,id|unique:employees,territory_id,' . optional($user->employee)->id,
            'contact' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'joining_date' => 'nullable|date',
        ], [
            'zone_id.unique' => 'The zone is already assigned to another employee.',
        ]);

        $user->update([
            'role_id'=> $data['role_id'] ?? $user->role_id,
            'name' => isset($data['name']) ? Str::title($data['name']) : $user->name,
            'is_active' => $data['is_active'] ?? $user->is_active
        ]);

        $updateEmployee = [
            'designation_id'=> $data['designation_id'] ?? $user->employee->designation_id,
            'division_id'=> $data['division_id'] ?? $user->employee->division_id,
            'region_id'=> $data['region_id'] ?? $user->employee->region_id,
            'area_id'=> $data['area_id'] ?? $user->employee->area_id,
            'territory_id'=> $data['territory_id'] ?? $user->employee->territory_id,
            'contact' => $data['contact'] ?? $user->employee->contact,
            'address' => $data['address'] ?? $user->employee->address,
            'joining_date' => $data['joining_date'] ?? $user->employee->joining_date,
        ];

        if (array_key_exists('zone_id', $data)) {
            $updateEmployee['zone_id'] = $data['zone_id'];
        }

        $user->employee->update($updateEmployee);

        if (array_key_exists('zone_id', $data)) {
            if (isset($data['zone_id'])) {
                $zone_by_user = Zone::where('user_id', $user->id)->first();
                if ($zone_by_user) {
                    $zone_by_user->update([
                        'user_id' => null
                    ]);
                }
                
                $zone = Zone::where('id', $data['zone_id'])->first();
                $zone->update([
                    'user_id' => $user->id
                ]);
            } else {
                $zone = Zone::where('user_id', $user->id)->first();
                if ($zone) {
                    $zone->update([
                        'user_id' => null
                    ]);
                }
            }
        }

        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('delete', User::class);

        $user = User::findOrFail($id);
        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully',
        ]);
    }
}
