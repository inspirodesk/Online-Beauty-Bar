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
        $customers = Customer::where('status', 'processing')->get();

        return view('prints.index', compact('customers'));
    }
}
