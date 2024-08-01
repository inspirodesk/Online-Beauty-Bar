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
                    <form action="{{ route('pages.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title">
                            @if ($errors->has('title'))
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="title">Title</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" name="content" id="classic-editor"></textarea>
                            @if ($errors->has('content'))
                                <span class="text-danger">{{ $errors->first('content') }}</span>
                            @endif
                        </div>
                        <input type="hidden" class="form-control" name="author" value="{{ auth()->user()->name }}">
                        <input type="hidden" class="form-control" name="status" value="Published">
                        <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                </div>
        </div>
    </div>
</div>

@endsection
