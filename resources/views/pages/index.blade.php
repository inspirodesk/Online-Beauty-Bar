@extends('layouts.app')

@section('content')
<div class="card">

    <div class="card-header">
        <div class="row">
            <div class="col-md-8">
                <h4>Pages</h4>
            </div>
        </div>
    </div>

    <div class="card-body">
        <table class="table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Status</th>
                    <th>Author</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pages as $page)
                    <tr>
                        <td>{{ $page->title }}</td>
                        <td>{{ $page->status }}</td>
                        <td>{{ $page->author }}</td>
                        <td>
                            <a href="{{ route('pages.show', $page->id) }}" class="btn btn-sm btn-warning">View</a>
                            <a href="{{ route('pages.edit', $page->id) }}" class="btn btn-sm btn-primary">Edit</a>
                            <form action="{{ route('pages.destroy', $page->id) }}" method="POST" style="display: inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
