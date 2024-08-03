@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Order Details</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table table-bordered" cellpadding="10">
        <tr>
            <th>Customer Details</th>
            <th>Product Details</th>
            <th>Payment Details</th>
        </tr>
        <tr>
            <td>
                <b>Full Name : </b>{{ $order->shipping_first_name.' '.$order->shipping_last_name }}<br>
                <b>Address : </b>{{ $order->shipping_address_1.','.$order->shipping_city.','.$order->shipping_country.','.$order->shipping_postcode }}
                <br>
                <b>Email : </b>{{ $order->shipping_email}}
                <br>
                <b>Mobile : </b>{{ $order->shipping_phone }}
            </td>
            <td>
                @if($order->line_items)
                    <ul>
                        @foreach(json_decode($order->line_items) as $item)
                            <b>Product Name : </b>{{ $item->name }}<br>
                            <b>Product Qty : </b>{{ $item->quantity }}<br>
                            <b>Product Subtotal : </b>{{ $item->subtotal }}<br>
                            <hr>

                        @endforeach
                        <b>Total : </b> {{$order->total;}}
                    </ul>
                @endif
            </td>
            <td>
                <b>Order Status : </b>{{ $order->status }}<br>
                <b>Payment Method : </b>{{ $order->payment_method_title }}<br>
            </td>
        </tr>
    </table>

@endsection
