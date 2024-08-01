<!-- resources/views/pages/edit.blade.php -->
<!-- resources/views/pages/create.blade.php -->

@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
    <!-- Basic Inputs -->
        <div class="card">
            <div class="card-header">
            <h5>Create New Page</h5>
            </div>
                <div class="card-body">
                    <form action="{{ route('pages.update', $page->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ $page->title }}">
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" id="classic-editor" name="content">{{ $page->content }}</textarea>
                            @if ($errors->has('content'))
                                <span class="text-danger">{{ $errors->first('content') }}</span>
                            @endif
                        </div>
                        <!-- Other fields: content, status, author -->
                        <input type="text" class="form-control" name="author" value="{{ $page->author }}">
                        <input type="text" class="form-control" name="status" value="{{ $page->status }}">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
        </div>
    </div>
</div>

@endsection
