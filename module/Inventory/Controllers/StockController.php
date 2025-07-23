<?php

namespace Module\Inventory\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Module\Inventory\Models\Stock;
use Module\Inventory\Models\Product;

use Illuminate\Support\Facades\Log;

class StockController extends Controller
{
    public function stocks(Request $request)
    {
        $data['breadcrumbs'] = [
            ['title' => 'Dashboard', 'url' => route('dashboard')],
            ['title' => 'Stocks', 'url' => null],
        ];

        $data['products'] = Product::all();
        $data['stocks'] = Stock::orderBy('id', 'desc')->paginate(30);

        return view('Inventory::stocks.list', $data);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|array',
            'product_id.*' => 'exists:products,id',
            'quantity' => 'required|array',
            'quantity.*' => 'numeric|min:1',
            'mrp' => 'required|array',
            'mrp.*' => 'numeric|min:0',
        ]);

        foreach ($data['product_id'] as $index => $product_id) {
            $product = Product::findOrFail($product_id);
            $sku = $product->sku;

            $existingStock = Stock::where('sku', $sku)->first();

            if ($existingStock) {
                $existingStock->update([
                    'quantity' => $existingStock->quantity + $data['quantity'][$index]
                ]);
                
            } else {
                Stock::create([
                'product_name' => $product->title,
                'sku' => $product->sku,
                'quantity' => $data['quantity'][$index],
                'mrp' => $data['mrp'][$index]
            ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Stocks added successfully!',
        ]);
    }
}
