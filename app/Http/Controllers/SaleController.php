<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SaleController extends Controller
{
    // Display a listing of the resource
    public function index()
    {
        $sales = Sale::with('products')->get();
        return view('modules.sales.index', compact('sales'));
    }

    // Show the form for creating a new resource
    public function create()
    {
        return view('modules.sales.create');
    }

    // Store a newly created resource in storage
    public function store(Request $request)
    {
        do {
            $uniqueId = Str::upper(Str::random(8));  // Generate a unique ID
            $exists = Sale::where('cus_id', $uniqueId)->exists(); // Check if it already exists
        } while ($exists); // Repeat until a unique ID is found

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
            'subtotal' => 'required|numeric|min:0',
            'final_total' => 'required|numeric|min:0',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'products' => 'required|array',
            'products.*.name' => 'required|string|max:255',
            'products.*.amount' => 'required|numeric|min:0',
            'products.*.quantity' => 'required|numeric|min:0',
        ]);



        $customer = new Customer();
            $customer->name = $request->customer_name;
            $customer->status = $request->delivery_status;
            $customer->link_id = $uniqueId;
            $customer->address = $request->address;
            $customer->phone_no = $request->contact_number;
            $customer->save();

        $sale = new Sale($request->all());

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments');
            $sale->attachment = $path;
        }

        $sale->cus_id = $uniqueId;
        $sale->discount = 0;
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

        // Find sale by ID
        $sale = Sale::findOrFail($id);

        // Find customer by ID
        $customer = Customer::where('link_id', $sale->cus_id)->firstOrFail();

        // Log status for debugging
        \Log::info('Updating sale status:', ['sale_id' => $id, 'status' => $request->input('delivery_status')]);

        // Update sale status
        $sale->delivery_status = $request->input('delivery_status');
        $sale->save();

        $customer->status = $request->input('delivery_status');
        $customer->save();



        // Redirect with success message
        return redirect()->route('sales.index')->with('success', 'Order status updated successfully.');
    }

}
