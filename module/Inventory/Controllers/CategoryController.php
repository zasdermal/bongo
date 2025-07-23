<?php

namespace Module\Inventory\Controllers;

use App\Http\Controllers\Controller;

use Module\Inventory\Models\Category;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categories(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Catalog', 'url' => null],
            ['title' => 'Categories', 'url' => null]
        ];

        $data['categories'] = Category::orderBy('id', 'desc')->get();

        return view('Inventory::categories.list', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'wing_id' => 'required|exists:wings,id',
            'name' => 'required|string|unique:categories|max:255'
        ]);

        Category::create([
            'user_id' => auth()->user()->id,
            'wing_id' => $data['wing_id'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name'])
        ]);

        return redirect()->route('catalog.categories')->with('success', 'Category added successfully');
    }

    public function categories_by_wing_($id)
    {
        $data['categories'] = Category::where('wing_id', $id)->get();

        return response()->json([
            'categories' => $data['categories'],
        ]);
    }
}
