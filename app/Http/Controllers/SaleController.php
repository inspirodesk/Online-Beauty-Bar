<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class SaleController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $sales = Sale::with('products')->where('block_status', 'Active')->get();
        return view('modules.sales.index', compact('sales'));
    }

    public function blockList()
    {
        $sales = Sale::with('products')->where('block_status', 'Block')->get();
        return view('modules.sales.block-list', compact('sales'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        return view('modules.sales.create');
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        // Generate a unique ID
        do {
            $uniqueId = Str::upper(Str::random(8));
            $exists = Sale::where('cus_id', $uniqueId)->exists();
        } while ($exists);

        $request->validate([
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'order_no' => 'required|string|max:50',
            'track_no' => 'required|string|max:50',
            'payment_method' => 'required|string|max:50',
            'status' => 'required|string|max:50',
            'delivery_status' => 'nullable|string|max:50',
            'discount' => 'nullable|numeric|min:0',
            'delivery' => 'nullable|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'final_total' => 'required|numeric|min:0',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'products' => 'required|array',
            'products.*.name' => 'required|string|max:255',
            'products.*.amount' => 'required|numeric|min:0',
            'products.*.quantity' => 'required|numeric|min:0',
        ]);

        // Check if the customer exists and their block status
        $existingCustomer = Sale::where('contact_number', $request->contact_number)->first();

        if ($existingCustomer && $existingCustomer->block_status == 'Block') {
            return redirect()->back()->withErrors(['contact_number' => 'This customer is already in the block list.']);
        }

        if (!$existingCustomer) {
            // If customer does not exist, create a new customer
            $customer = new Customer();
            $customer->name = $request->customer_name;
            $customer->status = $request->delivery_status;
            $customer->link_id = $uniqueId;
            $customer->address = $request->address;
            $customer->phone_no = $request->contact_number;
            $customer->save();
        } else {
            // If customer exists, use the existing customer
            $customer = $existingCustomer;
            $uniqueId = $customer->link_id;
        }

        // Create a new sale
        $sale = new Sale($request->all());

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments');
            $sale->attachment = $path;
        }

        $sale->cus_id = $uniqueId;
        $sale->block_status = 'Active';
        $sale->save();

        // Save associated products
        foreach ($request->input('products') as $productData) {
            $sale->products()->create($productData);
        }

        return redirect()->route('sales.index')->with('success', 'Sale created successfully.');
    }



    // Display the specified resource
    public function show($id)
    {
        $sale = Sale::with('products')->findOrFail($id);
        return view('modules.sales.show', compact('sale'));
    }

    // Show the form for editing the specified resource
    public function edit($id)
    {
        $sale = Sale::findOrFail($id);
        return view('modules.sales.edit', compact('sale'));
    }

    // Update the specified resource in storage
    public function update(Request $request, $id)
    {
        $request->validate([
            'cus_id' => 'required|string|max:255',
            'customer_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'contact_number' => 'required|string|max:20',
            'whatsapp_number' => 'nullable|string|max:20',
            'order_no' => 'required|string|max:50',
            'track_no' => 'required|string|max:50',
            'payment_method' => 'required|string|max:50',
            'status' => 'required|string|max:50',
            'delivery_status' => 'nullable|string|max:50',
            'discount' => 'nullable|numeric|min:0',
            'delivery' => 'nullable|numeric|min:0',
            'subtotal' => 'required|numeric|min:0',
            'final_total' => 'required|numeric|min:0',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'products' => 'required|array',
            'products.*.name' => 'required|string|max:255',
            'products.*.amount' => 'required|numeric|min:0',
            'products.*.quantity' => 'required|numeric|min:0',
        ]);


        $customer = Customer::where('link_id', $request->cus_id)->first();

        if ($customer) {
            // Update the existing customer record
            $customer->update([
                'name' => $request->customer_name,
                'status' => $request->delivery_status,
                'address' => $request->address,
                'phone_no' => $request->contact_number,
            ]);
        }

        $sale = Sale::findOrFail($id);
        $sale->fill($request->except('attachment'));

        if ($request->hasFile('attachment')) {
            // Delete old attachment if it exists
            if ($sale->attachment) {
                Storage::delete($sale->attachment);
            }

            $path = $request->file('attachment')->store('attachments');
            $sale->attachment = $path;
        }


        $sale->save();

        // Update associated products
        $sale->products()->delete(); // Remove existing products
        foreach ($request->input('products') as $productData) {
            $sale->products()->create($productData);
        }

        return redirect()->route('sales.index')->with('success', 'Sale updated successfully.');
    }

    // Remove the specified resource from storage
    public function destroy($id)
    {
        $sale = Sale::findOrFail($id);

        // Delete attachment if it exists
        if ($sale->attachment) {
            Storage::delete($sale->attachment);
        }

        // Delete associated products
        $sale->products()->delete();

        $sale->delete();

        return redirect()->route('sales.index')->with('success', 'Sale deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        // Validate request
        $request->validate([
            'delivery_status' => 'required|string|in:Pending,Getting Ready,Packing,Sent for Delivery,Dispatched,Delivered',
        ]);



        // Redirect to the send for delivery form if status is "Sent for Delivery"
        if ($request->input('delivery_status') === 'Sent for Delivery') {
            return redirect()->route('sales.sendForDelivery', $id);
        }
        else
        {
            // Find sale by ID
            $sale = Sale::findOrFail($id);

            // Update sale status
            $sale->delivery_status = $request->input('delivery_status');
            $sale->save();

            // Update customer status
            $customer = Customer::where('link_id', $sale->cus_id)->firstOrFail();
            $customer->status = $request->input('delivery_status');
            $customer->save();
        }

        // Redirect with success message
        return redirect()->route('sales.index')->with('success', 'Order status updated successfully.');
    }

    public function block(Request $request, $id)
    {
        $request->validate([
            'block_status' => 'required|string|in:Active,Block',
        ]);

        $sale = Sale::findOrFail($id);
        $sale->block_status = $request->input('block_status');
        $sale->save();

        return redirect()->route('sales.index')->with('success', 'Customer status updated successfully.');
    }

    public function deleteUser($id)
    {
        $sale = Sale::findOrFail($id);

        // Delete attachment if it exists
        if ($sale->attachment) {
            Storage::delete($sale->attachment);
        }

        // Delete associated products
        $sale->products()->delete();

        $sale->delete();

        return back()->with('success', 'Block sale deleted successfully.');
    }


    public function sendForDelivery($id)
    {
        // Fetch sale details
        $sale = Sale::findOrFail($id);

        // Fetch recipient details
        $recipient_name = $sale->customer_name;
        $recipient_contact_no = $sale->contact_number;
        $recipient_address = $sale->address;
        $recipient_city = 'nugegoda'; // Assuming this is a constant or fetched from the database
        $order_id = $sale->order_no;
        $cus_id = $sale->cus_id;

        return view('modules.sales.send_for_delivery', compact('cus_id','recipient_name', 'recipient_contact_no', 'recipient_address', 'recipient_city', 'order_id'));
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
            $sale = Sale::where('order_no', $request->order_id)->firstOrFail();
            $customer = Customer::where('link_id', $request->recipient_id)->firstOrFail();

            $sale->delivery_status = 'Sent for Delivery';
            $sale->save();

            $customer->status = 'Sent for Delivery';
            $customer->save();

            return redirect()->route('sales.index')->with('success', 'Parcel successfully added. Waybill No: ' . $responseBody['waybill_no']);
        } else {
            $errorMessage = $messages[$statusCode] ?? 'Unknown error occurred';
            return redirect()->route('sales.index')->with('error', 'Failed to add the parcel. Error: ' . $errorMessage);
        }
    }






}
