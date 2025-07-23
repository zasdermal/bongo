<?php

namespace Module\Inventory\Controllers;

use App\Http\Controllers\Controller;

use Module\Inventory\Models\Product;
use Module\Inventory\Models\Category;


use Illuminate\Support\Str;
use Illuminate\Http\Request;

use Intervention\Image\Facades\Image;

class ProductController extends Controller
{
    public function products(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Catalog', 'url' => null],
            ['title' => 'Products', 'url' => null]
        ];

        $data['categories'] = Category::all();
        $data['products'] = Product::orderBy('id', 'desc')->get();

        return view('Inventory::products.list', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'country_id' => 'required|exists:countries,id',
            'supplier_id' => 'required|exists:suppliers,id',
            'wing_id' => 'required|exists:wings,id',
            'title' => 'required|string',
            'image' => 'required',
            'sku' => 'required|string|unique:products,sku'
        ]);

        $image = $data['image'];
        $set_name = time() . '.' . $image->getClientOriginalExtension();
        $set_location = public_path('images/products/' . $set_name);

        Image::make($image)->save($set_location);

        Product::create([
            'category_id' => $data['category_id'],
            'sub_category_id' => $data['sub_category_id'],
            'country_id' => $data['country_id'],
            'supplier_id' => $data['supplier_id'],
            'wing_id' => $data['wing_id'],
            'title' => $data['title'],
            'slug' => Str::slug($data['title']),
            'image' => $set_name,
            'sku' => $data['sku'],
        ]);

        return redirect()->route('catalog.products')->with('success', 'Product catalog added successfully');
    }

    public function products_by_supplier_($id)
    {
        $data['products'] = Product::where('supplier_id', $id)->get();

        return response()->json([
            'products' => $data['products'],
        ]);
    }

    public function product_catalogs(Request $request)
    {
        $data['product_catalogs'] = Product::all();

        return response()->json([
            'product_catalogs' => $data['product_catalogs'],
        ]);
    }
}
