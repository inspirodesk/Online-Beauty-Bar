@extends('layouts.app')

@section('content')
<div class="container">
    <h1>API Settings</h1>

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

    <form action="{{ route('settings.updateapi') }}" method="POST">
        @csrf

        <div class="form-group col-3x3">
            <label for="woocommerce_url">WooCommerce URL</label>
            <input type="url" class="form-control" id="woocommerce_url" name="woocommerce_url" value="{{ old('woocommerce_url', $settings['woocommerce_url']) }}" required>
        </div>

        <div class="form-group col-3x3">
            <label for="woocommerce_consumer_key">WooCommerce Consumer Key</label>
            <input type="text" class="form-control" id="woocommerce_consumer_key" name="woocommerce_consumer_key" value="{{ old('woocommerce_consumer_key', $settings['woocommerce_consumer_key']) }}" required>
        </div>

        <div class="form-group col-3x3">
            <label for="woocommerce_consumer_secret">WooCommerce Consumer Secret</label>
            <input type="text" class="form-control" id="woocommerce_consumer_secret" name="woocommerce_consumer_secret" value="{{ old('woocommerce_consumer_secret', $settings['woocommerce_consumer_secret']) }}" required>
        </div>

        <div class="form-group col-3x3">
            <label for="api_key">API Key</label>
            <input type="text" class="form-control" id="api_key" name="api_key" value="{{ old('api_key', $settings['api_key']) }}" required>
        </div>

        <div class="form-group col-3x3">
            <label for="fde_client_id">FDE Client ID</label>
            <input type="text" class="form-control" id="fde_client_id" name="fde_client_id" value="{{ old('fde_client_id', $settings['fde_client_id']) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Settings</button>
    </form>
</div>
@endsection
