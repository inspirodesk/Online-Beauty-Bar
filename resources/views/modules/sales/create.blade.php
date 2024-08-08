@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Sale</h2>
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

    <form action="{{ route('sales.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="customer_name">Customer Name:</label>
                    <input type="text" class="form-control" id="customer_name" name="customer_name" value="{{ old('customer_name') }}" required>
                </div>
            </div>
            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required>
                </div>
            </div>
            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="contact_number">Contact Number:</label>
                    <input type="text" class="form-control" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" required>
                </div>
            </div>
            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="whatsapp_number">WhatsApp Number:</label>
                    <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" value="{{ old('whatsapp_number') }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="order_no">Order No:</label>
                    <input type="text" class="form-control" id="order_no" name="order_no" value="{{ old('order_no') }}" required>
                </div>
            </div>
            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="track_no">Track No:</label>
                    <input type="text" class="form-control" id="track_no" name="track_no" value="{{ old('track_no') }}" required>
                </div>
            </div>
            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="payment_method">Payment Method:</label>
                    <select class="form-control" id="payment_method" name="payment_method" required>
                        <option value="COD">COD</option>
                        <option value="Online">Online</option>
                        <option value="Bank Deposit">Bank Deposit</option>
                        <option value="Online Transfer">Online Transfer</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="status">Status:</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="pending">Pending</option>
                        <option value="completed">Completed</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row" style="display: none">
            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="delivery_status">Delivery Status:</label>
                    <select class="form-control" id="delivery_status" name="delivery_status">
                        <option value="Pending" selected>Pending</option>
                        <option value="Getting Ready">Getting Ready</option>
                        <option value="Packing">Packing</option>
                        <option value="Sent for Delivery">Sent for Delivery</option>
                        <option value="Dispatched">Dispatched</option>
                        <option value="Delivered">Delivered</option>
                    </select>
                </div>
            </div>
            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="attachment">Attachment:</label>
                    <input type="file" class="form-control" id="attachment" name="attachment">
                </div>
            </div>
        </div>
        <hr><br>
        <div class="row">
            <div class="col-12">
                <div id="products-container">
                    <div class="row product-row">
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="product_name_1">Product Name:</label>
                                <input type="text" class="form-control product-name" name="products[0][name]" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="product_quantity_1">Product Quantity:</label>
                                <input type="number" class="form-control" name="products[0][quantity]" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-12">
                            <div class="form-group">
                                <label for="product_amount_1">Product Amount:</label>
                                <input type="number" class="form-control product-amount" name="products[0][amount]" required>
                            </div>
                        </div>
                        <div class="col-md-3 col-12 text-md-left text-center">
                            <button style="margin-top: 30px" type="button" class="btn btn-sm btn-danger remove-product-btn">Remove</button>
                        </div>
                    </div>

                </div>
                <button style="margin-top: 30px" type="button" id="add-product-btn" class="btn btn-sm btn-primary">Add New Product</button>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-4 col-12 offset-md-8">
                <div class="form-group">
                    <label for="delivery_amount">Delivery Amount:</label>
                    <input type="number" class="form-control" id="delivery_amount" name="delivery" value="{{ old('delivery_amount') }}" step="0.01">
                </div>
                <div class="form-group">
                    <label for="discount">Discount:</label>
                    <input type="number" class="form-control" id="discount" name="discount" value="{{ old('discount') }}" step="0.01">
                </div>
                <div class="form-group">
                    <label for="subtotal">Subtotal:</label>
                    <input type="number" class="form-control" id="subtotal" name="subtotal" value="{{ old('subtotal') }}" readonly>
                </div>
                <div class="form-group">
                    <label for="final_total">Final Total:</label>
                    <input type="number" class="form-control" id="final_total" name="final_total" value="{{ old('final_total') }}" readonly>
                </div>
                <div class="form-group text-center">
                    <button type="submit" class="btn btn-sm btn-primary">Submit</button>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let productCount = 1;

    // Fetch products for auto-complete
    let products = [];
    $.ajax({
        url: '{{ url("list-products") }}',
        method: 'GET',
        success: function(data) {
            products = data;
            initializeAutocomplete();
        }
    });

    document.getElementById('add-product-btn').addEventListener('click', function() {
        productCount++;
        const container = document.getElementById('products-container');

        const newRow = document.createElement('div');
        newRow.classList.add('row', 'product-row');
        newRow.innerHTML = `
            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="product_name_${productCount}">Product Name:</label>
                    <input type="text" class="form-control product-name" name="products[${productCount - 1}][name]" required>
                </div>
            </div>
            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="product_quantity_${productCount}">Product Quantity:</label>
                    <input type="number" class="form-control" name="products[${productCount - 1}][quantity]" required>
                </div>
            </div>
            <div class="col-md-3 col-12">
                <div class="form-group">
                    <label for="product_amount_${productCount}">Product Amount:</label>
                    <input type="number" class="form-control product-amount" name="products[${productCount - 1}][amount]" required>
                </div>
            </div>
            <div class="col-md-3 col-12 text-md-left text-center">
                <button style="margin-top: 30px" type="button" class="btn btn-sm btn-danger remove-product-btn">Remove</button>
            </div>
        `;

        container.appendChild(newRow);
        initializeAutocomplete();
    });

    document.getElementById('products-container').addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-product-btn')) {
            event.target.closest('.product-row').remove();
            calculateTotal();
        }
    });

    document.getElementById('products-container').addEventListener('input', function(event) {
        if (event.target.name.startsWith('products') && event.target.type === 'number') {
            calculateTotal();
        }
    });

    document.getElementById('discount').addEventListener('input', function() {
        calculateTotal();
    });

    document.getElementById('delivery_amount').addEventListener('input', function() {
        calculateTotal();
    });

    function calculateTotal() {
        let subtotal = 0;
        document.querySelectorAll('.product-row').forEach(function(row) {
            const quantity = parseFloat(row.querySelector('input[name$="[quantity]"]').value) || 0;
            const amount = parseFloat(row.querySelector('input[name$="[amount]"]').value) || 0;
            subtotal += quantity * amount;
        });

        const discount = parseFloat(document.getElementById('discount').value) || 0;
        const deliveryAmount = parseFloat(document.getElementById('delivery_amount').value) || 0;
        const finalTotal = subtotal - discount + deliveryAmount;

        document.getElementById('subtotal').value = subtotal.toFixed(2);
        document.getElementById('final_total').value = finalTotal.toFixed(2);
    }

    function initializeAutocomplete() {
        $('.product-name').autocomplete({
            source: products.map(product => product.name),
            select: function(event, ui) {
                const selectedProduct = products.find(product => product.name === ui.item.value);
                const amountField = $(this).closest('.product-row').find('.product-amount');
                amountField.val(selectedProduct.amount);
                calculateTotal();
            }
        });
    }

    initializeAutocomplete();
});
</script>
@endsection
