{{-- resources/views/modules/orders/status.blade.php --}}

@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Orders - Status: {{ ucfirst($status) }}</h2>
    <br>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
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
@endsection
