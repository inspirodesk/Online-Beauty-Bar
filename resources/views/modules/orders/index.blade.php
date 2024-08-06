@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Orders</h2>

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
    <table id="orders-table" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Status</th>
                <th>Total</th>
                <th>Customer Name</th>
                <th>Number</th>
                <th>Order Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->woocommerce_id }}</td>
                    <td>{{ $order->status }}</td>
                    <td>{{ $order->total }}</td>
                    <td>{{ $order->shipping_first_name." ".$order->shipping_last_name }}</td>
                    <td>{{ $order->shipping_phone }}</td>
                    <td>{{ $order->created_via }}</td>
                    <td>
                        <a class="btn btn-sm btn-danger" href="{{ route('orders.show', $order->id) }}">View</a>
                        <form action="{{ route('orders.updateStatus', $order->id) }}" method="POST" style="display: inline-block; margin-left: 5px;">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline btn-danger dropdown-toggle" data-toggle="dropdown">
                                        {{ ucfirst($order->status) }}
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#" data-status="pending">Pending</a>
                                        <a class="dropdown-item" href="#" data-status="send-for-delivery">Send For Delivery</a>
                                        <a class="dropdown-item" href="#" data-status="on-hold">On Hold</a>
                                        <a class="dropdown-item" href="#" data-status="completed">Completed</a>
                                        <a class="dropdown-item" href="#" data-status="cancelled">Cancelled</a>
                                        <a class="dropdown-item" href="#" data-status="refunded">Refunded</a>
                                    </div>
                                    <input type="hidden" name="status" value="{{ $order->status }}"> <!-- Hidden field to store the selected status -->
                                </div>
                            </div>
                        </form>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Include pagination links if needed -->
    {{ $orders->links() }}
</div>

<script>
    $(document).ready(function() {
        $('#orders-table').DataTable();
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
                form.find('input[name="status"]').val(status);
                form.submit();
            });
        });
    </script>

@endsection
