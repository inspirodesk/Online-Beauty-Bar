@extends('layouts.app')

@section('content')
<div class="row">
    <!-- Site create form -->

    <div class="col-md-12">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    Manage Sites
                </div>
            </div>
            <div class="card-body">
                <a href="{{ route('sites.create') }}" class="btn btn-primary btn-sm my-2"><i class="bi bi-plus-circle"></i> Create New Site</a>

                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Site Name</th>
                            <th scope="col" style="width: 250px;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($sites as $site)
                        <tr>
                            <th scope="row">{{ $site->id }}</th>
                            <td>{{ $site->name }}</td>
                            <td>
                                <form id="deleteForm_{{ $site->id }}" action="{{ route('sites.destroy', $site->id) }}" method="post">
                                    @csrf
                                    @method('DELETE')

                                    <a href="{{ route('sites.edit', $site->id) }}" class="btn btn-primary btn-sm"><i class="bi bi-pencil-square"></i> Edit</a>

                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteSite('{{ $site->id }}')">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <td colspan="3">
                            <span class="text-danger">
                                <strong>No Site Found!</strong>
                            </span>
                        </td>
                        @endforelse
                    </tbody>
                </table>

                {{ $sites->links() }}

            </div>
        </div>
    </div>
</div>
@endsection
