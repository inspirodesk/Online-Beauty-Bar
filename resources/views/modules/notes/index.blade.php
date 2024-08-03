@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Notes</h2>
    <hr>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Form to add a new note -->
    <form action="{{ route('notes.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="order_note">Order Note:</label>
            <textarea class="form-control" id="order_note" name="order_note" rows="3" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Note</button>
    </form>

    <hr>

    <!-- DataTable -->
    <h3>Existing Notes:</h3>
    <table class="table table-striped" id="notes-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Note</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notes as $note)
                <tr id="note-row-{{ $note->id }}">
                    <td>{{ $note->id }}</td>
                    <td id="note-text-{{ $note->id }}">{{ $note->order_note }}</td>
                    <td>{{ $note->created_at }}</td>
                    <td>
                        <a href="{{ route('notes.show', $note->id) }}" class="btn btn-info btn-sm">View</a>
                        <form action="{{ route('notes.destroy', $note->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
                <!-- Inline Edit Form -->
            @endforeach
        </tbody>
    </table>
</div>

<!-- Include DataTables CSS and JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.3/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.3/js/jquery.dataTables.min.js"></script>

<script>
function editNote(id) {
    $(`#note-row-${id}`).hide();
    $(`#edit-form-${id}`).show();
}

function cancelEdit(id) {
    $(`#note-row-${id}`).show();
    $(`#edit-form-${id}`).hide();
}

$(document).ready(function() {
    $('#notes-table').DataTable({
        // DataTable options can be customized here
    });
});
</script>
@endsection
