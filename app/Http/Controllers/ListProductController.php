<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ListProduct;
use App\Services\WooCommerceService;

class ListProductController extends Controller
{
    protected $wooCommerceService;

    public function __construct(WooCommerceService $wooCommerceService)
    {
        $this->wooCommerceService = $wooCommerceService;
    }

    public function syncWooCommerceProducts()
    {
        try {
            $products = $this->wooCommerceService->getProducts();

            foreach ($products as $product) {
                ListProduct::updateOrCreate(
                    ['name' => $product->name],
                    ['amount' => $product->price]
                );
            }

            return response()->json(['message' => 'Products synchronized successfully.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to synchronize products: ' . $e->getMessage()], 500);
        }
    }

    public function getProducts()
    {
        $products = ListProduct::select('name', 'amount')->get();
        return response()->json($products);
    }

}
