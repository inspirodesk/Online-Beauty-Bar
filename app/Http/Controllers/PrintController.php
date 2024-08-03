<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Sale;
use Illuminate\Http\Request;

class PrintController extends Controller
{
    public function index()
    {
        // Fetch customers with processing orders and sales
        $customers = Customer::where('customers.status', 'processing')
        ->join('sales', 'customers.link_id', '=', 'sales.cus_id')
        ->join('orders', 'customers.link_id', '=', 'orders.woocommerce_id')
        ->select('customers.*')
        ->distinct()
        ->get();

        return view('prints.index', compact('customers'));
    }
}
