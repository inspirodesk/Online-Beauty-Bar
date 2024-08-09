@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Send Parcel for Delivery</h2>

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('sales.processDeliveryRequest') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <div class="form-group row">
                    <div class="col-md-4 col-12">
                        <label for="recipient_name">Recipient Name</label>
                        <input type="text" class="form-control" id="recipient_name" name="recipient_name" value="{{ $recipient_name }}" readonly>
                        <input type="hidden" id="recipient_id" name="recipient_id" value="{{ $cus_id }}" readonly>
                    </div>
                    <div class="col-md-4 col-12">
                        <label for="recipient_contact_no">Recipient Contact Number</label>
                        <input type="text" class="form-control" id="recipient_contact_no" name="recipient_contact_no" value="{{ $recipient_contact_no }}" readonly>
                    </div>
                    <div class="col-md-4 col-12">
                        <label for="recipient_address">Recipient Address</label>
                        <input type="text" class="form-control" id="recipient_address" name="recipient_address" value="{{ $recipient_address }}" readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4 col-12">
                        <label for="recipient_city">Recipient City</label>
                        <input type="text" class="form-control" id="recipient_city" name="recipient_city" value="{{ $recipient_city }}" readonly>
                    </div>
                    <div class="col-md-4 col-12">
                        <label for="order_id">Order ID</label>
                        <input type="text" class="form-control" id="order_id" name="order_id" value="{{ $order_id }}" readonly>
                    </div>
                    <div class="col-md-4 col-12">
                        <label for="parcel_type">Parcel Type</label>
                        <select class="form-control" id="parcel_type" name="parcel_type">
                            @for ($i = 0; $i <= 30; $i++)
                                <option value="{{ $i }}">{{ $i }} kg</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-4 col-12">
                        <label for="cod_amount">COD Amount</label>
                        <input type="text" class="form-control" id="cod_amount" name="cod_amount" required>
                    </div>
                    <div class="col-md-4 col-12">
                        <label for="exchange">Exchange</label>
                        <select class="form-control" id="exchange" name="exchange">
                            <option value="0" selected>No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                    <div class="col-md-4 col-12">
                        <label for="parcel_description">Parcel Description</label>
                        <input type="text" class="form-control" id="parcel_description" name="parcel_description" required>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Send for Delivery</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
