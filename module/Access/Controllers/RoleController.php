<?php

namespace Module\Access\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Module\Access\Models\Menu;
use Module\Access\Models\Role;

class RoleController extends Controller
{
    public function roles(Request $request)
    {
        $this->authorize('read', Role::class);
        
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'User Management', 'url' => null],
            ['title' => 'Roles', 'url' => null]
        ];
        $data['menus'] = Menu::all();
        $data['roles'] = Role::whereNotIn('slug', ['admin'])->get();

        return view('Access::roles.list', $data);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Role::class);

        $data = $request->validate([
            'name' => 'required|string|unique:roles|max:255'
        ]);

        Role::create([
            'name' => Str::title($data['name']),
            'slug' => Str::slug($data['name'])
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Role added successfully',
        ]);
    }

    public function role($id)
    {
        $this->authorize('update', Role::class);

        $role = Role::with('permissions')->findOrFail($id);

        return response()->json([
            'name' => $role->name,
            'permissions' => $role->permissions
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update', Role::class);

        $role = Role::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id
        ]);
        
        $role->update([
            'name' => Str::title($data['name']),
            'slug' => Str::slug($data['name'])
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Role updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('delete', Role::class);

        $role = Role::findOrFail($id);
        $role->delete();

        return response()->json([
            'success' => true,
            'message' => 'Role deleted successfully',
        ]);
    }

    public function assign_role_permissions(Request $request, $id)
    {
        $this->authorize('update', Role::class);
        
        $role = Role::findOrFail($id);
        $role->permissions()->sync($request->input('permissions'));

        return response()->json([
            'success' => true,
            'message' => 'Permissions updated to the role successfully',
        ]);
    }
}
