<!-- resources/views/modules/notes/partials/notes_list.blade.php -->

@if($notes->isEmpty())
    <p>No notes found.</p>
@else
    <ul class="list-group" id="notes-list">
        @foreach($notes as $note)
            <li class="list-group-item">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <strong>Note #{{ $note->id }}:</strong>
                        <span id="note-text-{{ $note->id }}">{{ $note->order_note }}</span><br>
                        <p><b>Created at :</b>{{ $note->created_at }} </p>
                    </div>
                    <div>
                        <a href="{{ route('notes.show', $note->id) }}" class="btn btn-info btn-sm float-right mx-2">View</a>
                        <!-- Edit button -->
                        <button class="btn btn-warning btn-sm" onclick="editNote({{ $note->id }})">Edit</button>
                        <!-- Delete button -->
                        <form action="{{ route('notes.destroy', $note->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </div>

                <!-- Inline Edit Form -->
                <div id="edit-form-{{ $note->id }}" class="edit-form d-none mt-2">
                    <form action="{{ route('notes.update', $note->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="edit_order_note_{{ $note->id }}">Order Note:</label>
                            <textarea class="form-control" id="edit_order_note_{{ $note->id }}" name="order_note" rows="3" required>{{ $note->order_note }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Note</button>
                        <button type="button" class="btn btn-secondary" onclick="cancelEdit({{ $note->id }})">Cancel</button>
                    </form>
                </div>
            </li>
        @endforeach
    </ul>
@endif
