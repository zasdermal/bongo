<?php

namespace Module\Access\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Module\Access\Models\SubMenu;
use Module\Access\Models\Permission;

class PermissionController extends Controller
{
    public function permissions(Request $request)
    {
        $this->authorize('read', Permission::class);

        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'User Management', 'url' => null],
            ['title' => 'Permissions', 'url' => null]
        ];
        
        $data['sub_menus'] = SubMenu::all();
        $data['permissions'] = Permission::paginate(30);

        return view('Access::permissions.list', $data);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Permission::class);

        $data = $request->validate([
            'sub_menu_id' => 'required|exists:sub_menus,id',
            'name' => [
                'required',
                'in:Create,Read,Update,Delete',
                Rule::unique('permissions')->where(function ($query) use ($request) {
                    return $query->where('sub_menu_id', $request->sub_menu_id)
                                ->where('name', $request->name);
                }),
            ]
        ], [
            'name.unique' => 'This permission already exists for the selected sub menu.',
        ]);

        Permission::create([
            'sub_menu_id' => $data['sub_menu_id'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name'])
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Permission added successfully',
        ]);
    }

    public function permission($id)
    {
        $this->authorize('update', Permission::class);

        $permission = Permission::find($id);

        return response()->json([
            'sub_menu_id' => $permission->sub_menu_id,
            'name' => $permission->name,
        ]);
    }

    public function update(Request $request, $id)
    {
        $this->authorize('update', Permission::class);

        $permission = Permission::find($id);

        $data = $request->validate([
            'sub_menu_id' => 'required|exists:sub_menus,id',
            'name' => [
                'required',
                'in:Create,Read,Update,Delete',
                Rule::unique('permissions')->where(function ($query) use ($request) {
                    return $query->where('sub_menu_id', $request->sub_menu_id)
                                ->where('name', $request->name);
                })->ignore($permission->id),
            ]
        ], [
            'name.unique' => 'This permission already exists for the selected sub menu.',
        ]);

        
        if ($permission) {
            $permission->update([
                'sub_menu_id' => $data['sub_menu_id'],
                'name' => $data['name'],
                'slug' => Str::slug($data['name'])
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Permission updated successfully',
        ]);
    }

    public function destroy($id)
    {
        $this->authorize('delete', Permission::class);

        $permission = Permission::findOrFail($id);
        $permission->delete();

        return response()->json([
            'success' => true,
            'message' => 'Permission deleted successfully',
        ]);
    }
}
