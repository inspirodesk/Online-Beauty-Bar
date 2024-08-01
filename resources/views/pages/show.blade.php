@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
    <!-- Basic Inputs -->
        <div class="card">
            <div class="card-header">
            <h5>{{ $page->title }}</h5>
            </div>
                <div class="card-body">
                    <p><strong>Status:</strong> {{ $page->status }}</p>
                    <p><strong>Author:</strong> {{ $page->author }}</p>
                    <p><strong>Content:</strong></p>
                    <p>{{ $page->content }}</p>

                    <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-primary">Edit</a>
                    <form action="{{ route('pages.destroy', $page->id) }}" method="POST" style="display: inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </div>
        </div>
    </div>
</div>
@endsection
