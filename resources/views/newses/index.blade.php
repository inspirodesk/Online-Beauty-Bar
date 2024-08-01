@extends('layouts.app')

@section('content')
<div class="card">

    <div class="card-header">
        <div class="row">
            <div class="col-md-8">
                <h4>News List</h4>
            </div>
            <div class="col-md-4">
                <input type="text" class="form-control" id="searchInput" placeholder="Type to search">
            </div>
        </div>
    </div>

    <div class="card-body">
        <!-- @can('create-news')
            <a href="{{ route('newses.create') }}" class="btn btn-success btn-sm my-2"><i class="bi bi-plus-circle"></i> Add New News</a>
        @endcan -->

        <table class="table" id="pc-dt-simple">
            <thead>
                <tr>
                <th scope="col" width="20px">S#</th>
                <th scope="col" width="600px">News Title</th>
                <th scope="col" width="">Status</th>
                <th scope="col" width="">Category</th>
                <th scope="col" width="">Site Selection</th>
                <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($newses as $news)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $news->name }}</td>
                    <td>{{ $news->status }}</td>
                    <td>
                         @php
                        $categories = $news->categories()->pluck('name')->toArray();
                         @endphp
                        {{ implode(', ', $categories) }}
                    </td>
                    <td>
                        @php
                        $sites = $news->sites()->pluck('name')->toArray();
                        @endphp
                        {{ implode(', ', $sites) }}
                    </td>
                    <td>
                        <a href="{{ route('newses.show', $news->id) }}" class="btn btn-warning btn-sm show-news-details" data-news-id="{{ $news->id }}">Show</a>
                        <a href="{{ route('newses.edit', $news->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <form id="deleteForm_{{ $news->id }}" action="{{ route('newses.destroy', $news->id) }}" method="post" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="button" class="btn btn-danger btn-sm" onclick="confirmDeleteNews('{{ $news->id }}')">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $newses->links() }}

    </div>
</div>
<script>
      $(document).ready(function () {
        $('#searchInput').on('input', function () {
            var searchTerm = $(this).val().toLowerCase();
            $('tbody tr').each(function () {
                var newsTitle = $(this).find('td:eq(0)').text().toLowerCase(); // Use eq(1) for the second column
                var category = $(this).find('td:eq(2)').text().toLowerCase(); // Use eq(3) for the fourth column
                var site = $(this).find('td:eq(3)').text().toLowerCase(); // Use eq(4) for the fifth column

                if (newsTitle.includes(searchTerm) || category.includes(searchTerm) || site.includes(searchTerm)) {
                    $(this).show();
                } else {
                    $(this).hide();
                }
            });
        });
    });

    </script>
@endsection
