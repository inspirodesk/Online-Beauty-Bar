@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Sales</h2>

    <!-- Align the button to the right -->
    <div class="text-end mb-3">
        <a href="{{ route('sales.create') }}" class="btn btn-primary">Create Sale</a>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <!-- Responsive Table Wrapper -->
    <div class="table-responsive">
        <table id="sales-table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Contact Number</th>
                    <th>Order ID</th>
                    <th>City</th>
                    <th>Products</th>
                    <th>Total Amount</th>
                    <th>Actions</th>
                    <th>Order Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                    <tr class="sale-row" data-block-status="{{ $sale->block_status }}">
                        <td>{{ $sale->id }}</td>
                        <td>{{ $sale->customer_name }}</td>
                        <td>{{ $sale->contact_number }}</td>
                        <td>{{ $sale->order_no }}</td>
                        <td>{{ $sale->track_no }}</td>
                        <td>
                            @foreach ($sale->products as $product)
                                {{ $product->name }} ({{ $product->amount }})<br>
                            @endforeach
                        </td>
                        <td>{{ $sale->final_total }}</td>
                        <td>
                            <a href="{{ route('sales.edit', $sale->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <a href="{{ route('sales.show', $sale->id) }}" class="btn btn-sm btn-success">Show</a>
                            <form action="{{ route('sales.destroy', $sale->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                        <td>
                            <form action="{{ route('sales.updateStatus', $sale->cus_id) }}" method="POST" style="display: inline-block; margin-top: 20px;">
                                @csrf
                                @method('PATCH')
                                <div class="form-group">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline btn-danger dropdown-toggle" data-toggle="dropdown">
                                            @if(ucfirst($sale->delivery_status)=='Pending')Processing @else {{ ucfirst($sale->delivery_status) }} @endif
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item delivery-status-item" href="#" data-status="Pending">Processing</a>
                                            <a class="dropdown-item delivery-status-item" href="#" data-status="Sent for Delivery">Sent to Delivery</a>
                                            <a class="dropdown-item delivery-status-item" href="#" data-status="Delivered">Completed</a>
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
                                            <a class="dropdown-item block-status-item" href="#" data-status="Active">Active</a>
                                            <a class="dropdown-item block-status-item" href="#" data-status="Block">Block</a>
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
</div>

<!-- JavaScript for handling DataTable and form interactions -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script>
$(document).ready(function() {
    var table = $('#sales-table').DataTable({
        responsive: true,
        stateSave: true
    });



    // Save the current page index to local storage before form submission
    $('#sales-table').on('click', 'form', function() {
        var pageIndex = table.page.info().page;
        localStorage.setItem('datatable_page', pageIndex);
    });

    // Delegate event handling for block status
    $('#sales-table tbody').on('click', '.block-status-item', function(e) {
        e.preventDefault();
        var status = $(this).data('status');
        var form = $(this).closest('form');

        // Update hidden field with selected status
        form.find('input[name="block_status"]').val(status);
        form.submit();
    });

    // Delegate event handling for delivery status
    $('#sales-table tbody').on('click', '.delivery-status-item', function(e) {
        e.preventDefault();
        var status = $(this).data('status');
        var form = $(this).closest('form');

        // Update hidden field with selected status
        form.find('input[name="delivery_status"]').val(status);
        form.submit();
    });

    // Handle block status filter
    $('#block-status-filter').on('change', function() {
        var selectedStatus = $(this).val().toLowerCase();
        $('.sale-row').each(function() {
            var rowStatus = $(this).data('block-status').toLowerCase();
            if (selectedStatus === "" || rowStatus === selectedStatus) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
});
</script>
@endsection
