<?php

namespace App\Http\Controllers;

use App\Services\WooCommerceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\Customer;
use Carbon\Carbon;

class OrderController extends Controller
{
    protected $woocommerceService;

    public function __construct(WooCommerceService $woocommerceService)
    {
        $this->woocommerceService = $woocommerceService;
    }


    public function syncOrders()
    {
        // Fetch orders from the WooCommerce service
        $orders = $this->woocommerceService->getOrders();

        // Iterate over each order
        foreach ($orders as $orderData) {
            // Access properties using object notation
            $shipping = $orderData->shipping ?? new \stdClass();
            $billing = $orderData->billing ?? new \stdClass();
            $lineItems = $orderData->line_items ?? [];

            // Initialize the order date variable
            $orderDate = $orderData->created_via ?? null;
            $parsedOrderDate = null;

            // Parse the order date if it exists
            if ($orderDate) {
                try {
                    $parsedOrderDate = Carbon::parse($orderDate)->toDateTimeString();
                } catch (\Exception $e) {
                    // Log error if date parsing fails
                    \Log::error("Date parsing error: " . $e->getMessage());
                }
            }

            // Update or create the order record
            Order::updateOrCreate(
                ['woocommerce_id' => $orderData->id],
                [
                    'status' => $orderData->status ?? null,
                    'payment_method_title' => $orderData->payment_method_title ?? null,
                    'total' => $orderData->total ?? null,
                    'shipping_first_name' => $shipping->first_name ?? null,
                    'shipping_last_name' => $shipping->last_name ?? null,
                    'shipping_company' => $shipping->company ?? null,
                    'shipping_address_1' => $shipping->address_1 ?? null,
                    'shipping_address_2' => $shipping->address_2 ?? null,
                    'shipping_city' => $shipping->city ?? null,
                    'shipping_state' => $shipping->state ?? null,
                    'shipping_postcode' => $shipping->postcode ?? null,
                    'shipping_country' => $shipping->country ?? null,
                    'shipping_email' => $billing->email ?? null,
                    'shipping_phone' => $billing->phone ?? null,
                    'name' => isset($lineItems[0]) ? ($lineItems[0]->name ?? null) : null,
                    'permalink' => isset($lineItems[0]) ? ($lineItems[0]->permalink ?? null) : null,
                    'number' => $orderData->number ?? null,
                    'created_via' => $parsedOrderDate,
                    'line_items' => $lineItems ? json_encode($lineItems) : null,
                ]
            );

            $customer = new Customer();
            $customer->name = $shipping->first_name.' '.$shipping->last_name;
            $customer->status = $orderData->status;
            $customer->link_id = $orderData->id;
            $customer->address = $shipping->address_1.','.$shipping->city.','.$shipping->country;
            $customer->phone_no = $billing->phone;
            $customer->save();
        }
        return response()->json(['message' => 'Orders synced successfully']);
    }





    public function index()
    {
        $orders = Order::paginate(10);
        return view('modules.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::findOrFail($id);
        return view('modules.orders.show', compact('order'));
    }


    public function updateStatus(Request $request, $id)
    {
        // Validate request
        $request->validate([
            'status' => 'required|string|in:pending,processing,on-hold,completed,cancelled,refunded',
        ]);

        // Find order by ID
        $order = Order::findOrFail($id);

        $customer = Customer::where('link_id', $order->woocommerce_id)->firstOrFail();

        // Update order status
        $order->status = $request->input('status');
        $order->save();

        $customer->status = $request->input('status');
        $customer->save();

        // // Update the WooCommerce product status
        $this->woocommerceService->updateProductStatus($order->woocommerce_id, $request->status);

        // Redirect with success message
        return redirect()->route('orders.index')->with('success', 'Order status updated successfully.');
    }

    public function showByStatus(Request $request, $status)
    {
        // Validate the status parameter
        $validStatuses = ['pending', 'processing', 'on-hold', 'completed', 'cancelled', 'refunded', 'failed', 'trash'];
        if (!in_array($status, $validStatuses)) {
            return redirect()->route('orders.index')->with('error', 'Invalid status value');
        }

        // Fetch orders by status
        $orders = Order::where('status', $status)->paginate(10);

        // Pass the status to the view for display
        return view('modules.orders.status', compact('orders', 'status'));
    }
}
