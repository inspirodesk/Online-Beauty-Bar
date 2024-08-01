@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    <h5>Remembrance List</h5>
                </div>

            </div>
            <div class="card-body" style="max-height: 500px; overflow-y: auto;">

                <table class="table" id="pc-dt-simple">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>Remembrance Day</th>
                            <th>Contact Person</th>
                            <th>Advertisement End Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rememberences as $rememberence)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $rememberence->name }}</td>
                            <td>{{ $rememberence->address }}</td>
                            <td>{{ $rememberence->rememberanceDay }}</td>
                            <td>
                                @foreach ($rememberence->contactDetails as $contactDetail)
                                {{ $contactDetail->contact_name }}: {{ $contactDetail->contact_number }}<br>
                                @endforeach
                            </td>
                            <td>{{ $rememberence->adEndDate }}</td>
                            <td>
                                <a href="{{ route('rememberences.show', $rememberence->id) }}" class="btn btn-warning btn-sm show-rememberence-details" data-rememberence-id="{{ $rememberence->id }}">Show</a>
                                <a href="{{ route('rememberences.edit', $rememberence->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form id="deleteForm_{{ $rememberence->id }}" action="{{ route('rememberences.destroy', $rememberence->id) }}" method="post" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteRememberence('{{ $rememberence->id }}')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $rememberences->links() }}

            </div>
        </div>
    </div>
</div>

@endsection
