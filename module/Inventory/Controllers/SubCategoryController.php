<?php

namespace Module\Inventory\Controllers;

use App\Http\Controllers\Controller;

use Module\Inventory\Models\Category;
use Module\Inventory\Models\SubCategory;

use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    public function subCategories(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Catalog', 'url' => null],
            ['title' => 'Sub Categories', 'url' => null]
        ];

        $data['categories'] = Category::all();
        $data['subCategories'] = SubCategory::orderBy('id', 'desc')->get();

        return view('Inventory::subCategories.list', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|unique:sub_categories|max:255'
        ]);

        SubCategory::create([
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name'])
        ]);

        return redirect()->route('catalog.sub_categories')->with('success', 'Sub category added successfully');
    }

    //sub categories by category
    public function sub_categories_by_category_($id)
    {
        $data['sub_categories'] = SubCategory::where('category_id', $id)->get();

        return response()->json([
            'sub_categories' => $data['sub_categories'],
        ]);
    }
}
