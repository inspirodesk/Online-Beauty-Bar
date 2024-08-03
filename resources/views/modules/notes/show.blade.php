@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Note Details</h2>
    <hr>

    <div class="form-group">
        <label for="order_note">Order Note:</label>
        <textarea class="form-control" id="order_note" rows="10" readonly>{{ $note->order_note }}</textarea>
    </div>

    <a href="{{ route('notes.index') }}" class="btn btn-primary">Back to List</a>
</div>
@endsection
