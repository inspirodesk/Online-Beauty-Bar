@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Sale</h2>
    <hr><br>
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('sales.update', $sale->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="customer_name">Customer Name:</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ old('customer_name', $sale->customer_name) }}" required>
                    <input type="hidden" class="form-control" id="cus_id" name="cus_id" value="{{ old('cus_id', $sale->cus_id) }}" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address', $sale->address) }}" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="contact_number">Contact Number:</label>
                    <input type="text" class="form-control" id="contact_number" name="contact_number" value="{{ old('contact_number', $sale->contact_number) }}" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="whatsapp_number">WhatsApp Number:</label>
                    <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number', $sale->whatsapp_number) }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="order_no">Order No:</label>
                    <input type="text" class="form-control" id="order_no" name="order_no" value="{{ old('order_no', $sale->order_no) }}" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="track_no">Track No:</label>
                    <input type="text" class="form-control" id="track_no" name="track_no" value="{{ old('track_no', $sale->track_no) }}" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="payment_method">Payment Method:</label>
                    <select class="form-control" id="payment_method" name="payment_method" required>
                        <option value="COD" {{ old('payment_method', $sale->payment_method) == 'COD' ? 'selected' : '' }}>COD</option>
                        <option value="Online" {{ old('payment_method', $sale->payment_method) == 'Online' ? 'selected' : '' }}>Online</option>
                        <option value="Bank Deposit" {{ old('payment_method', $sale->payment_method) == 'Bank Deposit' ? 'selected' : '' }}>Bank Deposit</option>
                        <option value="Online Transfer" {{ old('payment_method', $sale->payment_method) == 'Online Transfer' ? 'selected' : '' }}>Online Transfer</option>
                        <option value="Other" {{ old('payment_method', $sale->payment_method) == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="pending" {{ old('status', $sale->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ old('status', $sale->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-3">
                <div class="form-group">
                    <label for="delivery_status">Delivery Status:</label>
                    <select class="form-control" id="delivery_status" name="delivery_status">
                        <option value="pending" {{ old('delivery_status', $sale->delivery_status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ old('delivery_status', $sale->delivery_status) == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="on-hold" {{ old('delivery_status', $sale->delivery_status) == 'on-hold' ? 'selected' : '' }}>On Hold</option>
                        <option value="completed" {{ old('delivery_status', $sale->delivery_status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ old('delivery_status', $sale->delivery_status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        <option value="refunded" {{ old('delivery_status', $sale->delivery_status) == 'refunded' ? 'selected' : '' }}>Refunded</option>
                        <option value="failed" {{ old('delivery_status', $sale->delivery_status) == 'failed' ? 'selected' : '' }}>Failed</option>
                        <option value="trash" {{ old('delivery_status', $sale->delivery_status) == 'trash' ? 'selected' : '' }}>Trash</option>
                    </select>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="attachment">Attachment:</label>
                    <input type="file" class="form-control" id="attachment" name="attachment">
                    @if ($sale->attachment)
                        <a href="{{ asset('storage/' . $sale->attachment) }}" target="_blank">View Current Attachment</a>
                    @endif
                </div>
            </div>
        </div>
        <hr><br>
        <div class="row">
            <div class="col-8">
                <div id="products-container">
                    @foreach ($sale->products as $index => $product)
                        <div class="row product-row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="product_name_{{ $index }}">Product Name:</label>
                                    <input type="text" class="form-control" name="products[{{ $index }}][name]" value="{{ $product->name }}" required>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="product_amount_{{ $index }}">Product Amount:</label>
                                    <input type="number" class="form-control" name="products[{{ $index }}][amount]" value="{{ $product->amount }}" required>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="product_quantity_{{ $index }}">Quantity:</label>
                                    <input type="number" class="form-control" name="products[{{ $index }}][quantity]" value="{{ $product->quantity }}" required>
                                </div>
                            </div>
                            <div class="col-3">
                                <button style="margin-top: 30px" type="button" class="btn btn-sm btn-danger remove-product-btn">Remove</button>
                            </div>
                        </div>
                    @endforeach
                    <div class="row product-row">

                    </div>
                </div>
                <div class="col-4">
                    <button style="margin-top: 30px" type="button" id="add-product-btn" class="btn btn-sm btn-danger">Add New Product</button>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="discount">Discount:</label>
                    <input type="number" class="form-control" id="discount" name="discount" value="{{ old('discount', $sale->discount) }}" step="0.01">
                </div>
                <div class="form-group">
                    <label for="subtotal">Subtotal:</label>
                    <input type="number" class="form-control" id="subtotal" name="subtotal" value="{{ old('subtotal', $sale->subtotal) }}" readonly>
                </div>
                <div class="form-group">
                    <label for="final_total">Final Total:</label>
                    <input type="number" class="form-control" id="final_total" name="final_total" value="{{ old('final_total', $sale->final_total) }}" readonly>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-sm btn-primary">Update</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let productCount = {{ $sale->products->count() }};

    function calculateTotal() {
        let subtotal = 0;

        document.querySelectorAll('input[name$="[amount]"]').forEach(function(input) {
            const amount = parseFloat(input.value) || 0;
            const quantityInput = input.closest('.product-row').querySelector('input[name$="[quantity]"]');
            const quantity = parseFloat(quantityInput.value) || 0;
            subtotal += amount * quantity;
        });

        const discount = parseFloat(document.getElementById('discount').value) || 0;
        const finalTotal = subtotal - discount;

        document.getElementById('subtotal').value = subtotal.toFixed(2);
        document.getElementById('final_total').value = finalTotal.toFixed(2);
    }

    document.getElementById('add-product-btn').addEventListener('click', function() {
        productCount++;
        const container = document.getElementById('products-container');

        const newRow = document.createElement('div');
        newRow.classList.add('row', 'product-row');
        newRow.innerHTML = `
            <div class="col-3">
                <div class="form-group">
                    <label for="product_name_${productCount}">Product Name:</label>
                    <input type="text" class="form-control" name="products[${productCount - 1}][name]" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="product_amount_${productCount}">Product Amount:</label>
                    <input type="number" class="form-control" name="products[${productCount - 1}][amount]" required>
                </div>
            </div>
            <div class="col-3">
                <div class="form-group">
                    <label for="product_quantity_${productCount}">Quantity:</label>
                    <input type="number" class="form-control" name="products[${productCount - 1}][quantity]" required>
                </div>
            </div>
            <div class="col-3">
                <button style="margin-top: 30px" type="button" class="btn btn-sm btn-danger remove-product-btn">Remove</button>
            </div>
        `;

        container.appendChild(newRow);
    });

    document.getElementById('products-container').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-product-btn')) {
            event.target.closest('.product-row').remove();
            calculateTotal();
        }
    });

    document.getElementById('products-container').addEventListener('input', function(event) {
        if (event.target.matches('input[name$="[amount]"], input[name$="[quantity]"]')) {
            calculateTotal();
        }
    });

    document.getElementById('discount').addEventListener('input', function() {
        calculateTotal();
    });

    // Initial calculation
    calculateTotal();
});


</script>
@endsection
