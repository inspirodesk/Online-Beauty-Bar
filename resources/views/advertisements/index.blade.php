@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header">
                <div class="float-start">
                    <h5>Advertisement List</h5>
                </div>

            </div>
            <div class="card-body">

                <table class="table" id="pc-dt-simple">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Date</th>
                            <th>Category</th>
                            <th>Author</th>
                            <th>Contact Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($advertisements as $advertisement)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $advertisement->title }}</td>
                            <td>{{ $advertisement->date }}</td>
                            <td>
                                @if($advertisement->ispopup !== 1)
                                {{ $advertisement->category}}
                                @else
                                    PopUp <br>
                                    @if($advertisement->isclosepopup !== 1)
                                    Display :{{$advertisement->display_time}}
                                    @endif
                                @endif
                            </td>
                            <td>{{ $advertisement->author }}</td>
                            <td>{{ $advertisement->mobile }}</td>
                            <td>
                                <a href="{{ route('advertisements.show', $advertisement->id) }}" class="btn btn-warning btn-sm show-advertisement-details" data-advertisement-id="{{ $advertisement->id }}">Show</a>
                                <a href="{{ route('advertisements.edit', $advertisement->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                <form id="deleteForm_{{ $advertisement->id }}" action="{{ route('advertisements.destroy', $advertisement->id) }}" method="post" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteAdvertisement('{{ $advertisement->id }}')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $advertisements->links() }}

            </div>
        </div>
    </div>
</div>

@endsection
