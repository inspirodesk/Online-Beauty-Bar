@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Order Details</h2>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <table class="table table-bordered">
        <tr>
            <th>Customer Details</th>
            <th>Product Details</th>
            <th>Order & Payment Details</th>
        </tr>
        <tr>
            <td>
                <b>Full Name : </b>{{ $sale->customer_name }}<br>
                <b>Address : </b>{{ $sale->address }}
                <br>
                <b>Mobile : </b>{{ $sale->contact_number }}
                <br>
                <b>WhatsApp : </b>{{ $sale->whatsapp_number }}
            </td>
            <td>
                @if($sale->products)
                    <ul>
                        @foreach($sale->products as $product)
                            <b>Product Name : </b>{{ $product->name }}<br>
                            <b>Product Price : </b>{{ $product->amount }}<br>
                            <b>Product Qty : </b>{{ $product->quantity }}<br>
                            <hr>
                        @endforeach

                @endif
                        <ul>
                            <b>Product Discount : </b>{{ $sale->discount }}<br>
                            <b>Product Subtotal : </b>{{ $sale->subtotal }}<br>
                            <b>Product Total : </b>{{ $sale->final_total }}<br>
                        </ul>
                    </ul>
            </td>
            <td>
                <b>Payment Method : </b>{{ $sale->payment_method }}<br>
                <b>Payment Status : </b>{{ $sale->status }}<br>
                <b>Order Status : </b>{{ $sale->delivery_status }}<br>
            </td>
        </tr>
    </table>

@endsection
