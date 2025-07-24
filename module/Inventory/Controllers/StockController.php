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

    // API
    public function availabel_stocks(Request $request)
    {
        try {
            $stocks = Stock::whereNot('quantity', 0)->get();

            // Check if any products are not found
            if ($stocks->isEmpty()) {
                return response()->json([
                    'status' => 'ERROR',
                    'message' => 'No products found.'
                ], 200);
            }

            // Serialize products using a foreach loop
            $serializeStocks = [];
            foreach ($stocks as $stock) {
                $serializeStocks[] = [
                    'stock_id' => $stock->id,
                    'product_name' => $stock->product_name,
                    'sku' => $stock->sku,
                    'unit_price' => $stock->mrp
                ];
            }

            // Return successful response
            return response()->json([
                'status' => 'SUCCESS',
                'data' => $serializeStocks,
                'message' => 'Products retrieved successfully.'
            ], 200);

        } catch (\Exception $e) {
            // Return error response
            return response()->json([
                'status' => 'ERROR',
                'message' => 'Failed to retrieve products.',
                'error' => $e->getMessage() // Optionally include the error message in development
            ], 200);
        }
    }
}
