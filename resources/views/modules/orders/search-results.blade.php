{{-- resources/views/modules/orders/search-results.blade.php --}}

@forelse ($orders as $order)
    <tr>
        <td>{{ $order->number }}</td>
        <td>{{ $order->status }}</td>
        <td>{{ $order->total }}</td>
        <td>{{ $order->shipping_first_name . " " . $order->shipping_last_name }}</td>
        <td>{{ $order->shipping_phone }}</td>
        <td>{{ $order->created_via }}</td>
        <td>
            <a class="btn btn-sm btn-danger" href="{{ route('orders.show', $order->id) }}">View</a>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center">No orders found.</td>
    </tr>
@endforelse
