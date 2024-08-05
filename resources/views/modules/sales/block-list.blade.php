@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Block Sales</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table id="sales-table" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer Name</th>
                <th>Contact Number</th>
                <th>Order ID</th>
                <th>Products</th>
                <th>Total Amount</th>
                <th>Actions</th>
                <th>Order Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->customer_name }}</td>
                    <td>{{ $sale->contact_number }}</td>
                    <td>{{ $sale->order_no }}</td>
                    <td>
                        @foreach ($sale->products as $product)
                            {{ $product->name }} ({{ $product->amount }})<br>
                        @endforeach
                    </td>
                    <td>{{ $sale->final_total }}</td>
                    <td>
                        <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-success">Show</a>
                        <form action="{{ route('sales.deleteUser', $sale->id) }}" method="POST" style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                    <td>
                        <form action="{{ route('sales.updateStatus', $sale->id) }}" method="POST" style="display: inline-block; margin-top: 20px;">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline btn-danger dropdown-toggle" data-toggle="dropdown">
                                        {{ ucfirst($sale->delivery_status) }}
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-status="Pending">Pending</a>
                                        <a class="dropdown-item" href="#" data-status="Getting Ready">Getting Ready</a>
                                        <a class="dropdown-item" href="#" data-status="Packing">Packing</a>
                                        <a class="dropdown-item" href="#" data-status="Sent for Delivery">Sent for Delivery</a>
                                        <a class="dropdown-item" href="#" data-status="Dispatched">Dispatched</a>
                                        <a class="dropdown-item" href="#" data-status="Delivered">Delivered</a>
                                    </div>
                                    <input type="hidden" name="delivery_status" value="{{ $sale->delivery_status }}"> <!-- Hidden field to store the selected status -->
                                </div>
                            </div>
                        </form>
                        <form action="{{ route('sales.block', $sale->id) }}" method="POST" style="display: inline-block; margin-top: 20px;">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline btn-danger dropdown-toggle" data-toggle="dropdown">
                                        {{ ucfirst($sale->block_status) }}
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-status="Active">Active</a>
                                        <a class="dropdown-item" href="#" data-status="Block">Block</a>
                                    </div>
                                    <input type="hidden" name="block_status" id="block_status" value="{{ $sale->block_status }}">
                                </div>
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('#sales-table').DataTable();
});
</script>
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Handle dropdown item click
        $('.dropdown-item').on('click', function(e) {
            e.preventDefault();
            var status = $(this).data('status');
            var form = $(this).closest('form');

            // Update hidden field with selected status
            form.find('input[name="delivery_status"]').val(status);
            form.submit();
        });
    });
</script>
<script>
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            let status = this.getAttribute('data-status');
            document.getElementById('block_status').value = status;
            this.closest('form').submit();
        });
    });
</script>

@endsection

ck_c96608daa0d2cecfa73918bfa00d5e277549667e
cs_700dbb85ac64aa70f0bc58b021ac6ba3967662cb
