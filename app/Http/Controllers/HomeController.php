<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;
use App\Models\Order;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $orderStatuses = [
            'pending' => 'Pending',
            'processing' => 'Processing',
            'on-hold' => 'On Hold',
            'completed' => 'Completed',
            'cancelled' => 'Cancelled',
            'refunded' => 'Refunded',
        ];

        $orderCounts = [];
        $orderAmounts = [];

        foreach ($orderStatuses as $statusKey => $statusName) {
            $query = \App\Models\Order::where('status', $statusKey);

            if ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            }

            $orderCounts[$statusKey] = $query->count();
            $orderAmounts[$statusKey] = $query->sum('total'); // Adjust 'total' field as needed
        }

        // Sales status counts
        $salesStatuses = [
            'Pending' => 'Pending',
            'Getting Ready' => 'Getting Ready',
            'Packing' => 'Packing',
            'Sent for Delivery' => 'Sent for Delivery',
            'Dispatched' => 'Dispatched',
            'Delivered' => 'Delivered',
        ];

        $salesCounts = [];
        $salesAmounts = [];

        foreach ($salesStatuses as $statusKey => $statusName) {
            $query = \App\Models\Sale::where('delivery_status', $statusKey);

            if ($startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            }

            if ($endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            }

            $salesCounts[$statusKey] = $query->count();
            $salesAmounts[$statusKey] = $query->sum('final_total'); // Adjust 'final_total' field as needed
        }

        return view('dashboard', compact('orderCounts', 'orderAmounts', 'salesCounts', 'salesAmounts', 'orderStatuses', 'salesStatuses'));
    }


    public function nav()
    {
        $setting = Setting::findOrFail(1);
        return view('layouts.nav',compact('setting'));
    }

}
