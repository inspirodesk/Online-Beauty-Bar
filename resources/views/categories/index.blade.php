@extends('layouts.app')

@section('content')
<div class="row">
    <!-- Category create form -->
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Manage Categories
                </div>
            </div>
            <div class="card-body">
                <a href="{{ route('categories.create') }}" class="btn btn-primary btn-sm my-2"><i class="bi bi-plus-circle"></i> Create New Category</a>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Category Name</th>
                            <th scope="col" style="width: 250px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categories as $category)
                        <tr>
                            <th scope="row">{{ $category->id }}</th>
                            <td>{{ $category->name }}</td>
                            <td>
                                <form id="deleteForm_{{ $category->id }}" action="{{ route('categories.destroy', $category->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>

                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteCategory('{{ $category->id }}')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <td colspan="3">
                            <span class="text-danger">
                                <strong>No Category Found!</strong>
                            </span>
                        </td>
                        @endforelse
                    </tbody>
                </table>

                {{ $categories->links() }}

            </div>
        </div>
    </div>
</div>
@endsection
