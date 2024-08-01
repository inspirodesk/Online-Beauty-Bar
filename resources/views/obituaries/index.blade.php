@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    <h5>Obituary List</h5>
                </div>

            </div>
            <div class="card-body" style="max-height: 500px; overflow-y: auto;">

                <table class="table" id="pc-dt-simple">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Date of Death</th>
                            <th>Temporary Address</th>
                            <th>Date Of Cremation</th>
                            <th>Contact Person</th>
                            <th>Advertisement End Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($obituaries as $obituary)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $obituary->name }}</td>
                            <td>{{ $obituary->dateOfDeath }}</td>
                            <td>{{ $obituary->temporaryAddress }}</td>
                            <td>{{ $obituary->dateOfCremation }}</td>
                            <td>
                                @foreach ($obituary->contactDetails as $contactDetail)
                                {{ $contactDetail->contact_name }}: {{ $contactDetail->contact_number }}<br>
                                @endforeach
                            </td>
                            <td>{{ $obituary->adEndDate }}</td>
                            <td>
                                <a href="{{ route('obituaries.show', $obituary->id) }}" class="btn btn-warning btn-sm show-obituary-details" data-obituary-id="{{ $obituary->id }}">Show</a>
                                <a href="{{ route('obituaries.edit', $obituary->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form id="deleteForm_{{ $obituary->id }}" action="{{ route('obituaries.destroy', $obituary->id) }}" method="post" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteObituary('{{ $obituary->id }}')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $obituaries->links() }}

            </div>
        </div>
    </div>
</div>

@endsection
