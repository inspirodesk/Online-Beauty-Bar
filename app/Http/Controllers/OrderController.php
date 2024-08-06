<?php

namespace App\Http\Controllers;

use App\Services\WooCommerceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Order;
use App\Models\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

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
            'status' => 'required|string|in:pending,send-for-delivery,pending,processing,on-hold,completed,cancelled,refunded',
        ]);


        // Redirect to the send for delivery form if status is "Sent for Delivery"
        if ($request->input('status') === 'send-for-delivery') {
            return redirect()->route('orders.sendForDelivery', $id);
        }
        else
        {
            // Find sale by ID
            $order = Order::findOrFail($id);

            // Update sale status
            $order->status = $request->input('status');
            $order->save();

            // Update customer status
            $customer = Customer::where('link_id', $order->woocommerce_id)->firstOrFail();
            $customer->status = $request->input('status');
            $customer->save();

            // // Update the WooCommerce product status
            $this->woocommerceService->updateProductStatus($order->woocommerce_id, $request->status);
        }



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

    public function sendForDelivery($id)
    {
        // Fetch sale details
        $order= Order::findOrFail($id);

        // Fetch recipient details
        $recipient_name = $order->shipping_first_name.' '.$order->shipping_last_name;
        $recipient_contact_no = $order->shipping_phone;
        $recipient_address = $order->shipping_address_1;
        $recipient_city = $order->shipping_city; // Assuming this is a constant or fetched from the database
        $order_id = $order->number;

        return view('modules.orders.send_for_delivery', compact('recipient_name', 'recipient_contact_no', 'recipient_address', 'recipient_city', 'order_id'));
    }

    public function processDeliveryRequest(Request $request)
    {
        // Validate request
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'recipient_id' => 'required|string|max:255',
            'recipient_contact_no' => 'required|string|max:20',
            'recipient_address' => 'required|string|max:255',
            'recipient_city' => 'required|string|max:50',
            'order_id' => 'required|string|max:50',
            'parcel_type' => 'required|integer|min:0|max:30',
            'cod_amount' => 'required|numeric|min:0',
            'exchange' => 'required|boolean',
        ]);

        // Prepare data for the API request
        $api_key = env('API_KEY');
        $client_id = env('FDE_CLIENT_ID');

        $response = Http::post('https://fardardomestic.com/api/p_request_v1.02.php', [
            'client_id' => $client_id,
            'api_key' => $api_key,
            'recipient_name' => $request->recipient_name,
            'recipient_contact_no' => $request->recipient_contact_no,
            'recipient_address' => $request->recipient_address,
            'recipient_city' => $request->recipient_city,
            'parcel_type' => $request->parcel_type,
            'parcel_description' => $request->parcel_description,
            'cod_amount' => $request->cod_amount,
            'order_id' => $request->order_id,
            'exchange' => $request->exchange,
        ]);

        // Handle the response
        $responseBody = $response->json();
        $statusCode = $responseBody['status'];
        $messages = [
            201 => 'Inactive Client API Status',
            202 => 'Invalid Apikey',
            203 => 'Not Added the Parcel',
            204 => 'Successfully Added the Parcel',
            205 => 'Recipient Name Is Empty',
            206 => 'Recipient Contact Number Is Empty',
            207 => 'Recipient Address Is Empty',
            208 => 'Recipient Contact Number is Invalid',
            209 => 'Recipient City Is Empty',
            210 => 'Parcel Type Is Empty',
            211 => 'Parcel Type Is Not a Number',
            212 => 'Parcel Description Is Empty',
            218 => 'Recipient City Is Invalid',
            219 => 'Parcel Type Is Not valid',
            220 => 'COD amount Is Not a Number',
            221 => 'Invalid COD amount. It must be greater than or equal to 0'
        ];

        if ($statusCode == 204) {
            // Update the delivery status in the database
            $order =Order::where('woocommerce_id', $request->recipient_id)->firstOrFail();
            $customer = Customer::where('link_id', $request->recipient_id)->firstOrFail();

            $order->status = 'send-for-delivery';
            $order->save();

            $customer->status = 'Send For Delivery';
            $customer->save();

            // // Update the WooCommerce product status
            $this->woocommerceService->updateProductStatus($order->woocommerce_id, $order->status);

            return redirect()->route('orders.index')->with('success', 'Parcel successfully added. Waybill No: ' . $responseBody['waybill_no']);
        } else {
            $errorMessage = $messages[$statusCode] ?? 'Unknown error occurred';
            return redirect()->route('orders.index')->with('error', 'Failed to add the parcel. Error: ' . $errorMessage);
        }
    }
}
