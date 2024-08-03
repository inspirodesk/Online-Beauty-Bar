<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    /**
     * Display a listing of the notes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::all();
        return view('modules.notes.index', compact('notes'));
    }

    /**
     * Store a newly created note in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_note' => 'required|string|max:255',
        ]);

        Note::create([
            'order_note' => $request->order_note,
        ]);

        return redirect()->route('notes.index')->with('success', 'Note added successfully.');
    }

    /**
     * Update the specified note in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'order_note' => 'required|string|max:255',
        ]);

        $note = Note::findOrFail($id);
        $note->update([
            'order_note' => $request->order_note,
        ]);

        return redirect()->route('notes.index')->with('success', 'Note updated successfully.');
    }

    /**
     * Remove the specified note from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = Note::findOrFail($id);
        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Note deleted successfully.');
    }

    public function show(Note $note)
    {
        return view('modules.notes.show', compact('note'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $notes = Note::where('order_note', 'like', "%{$query}%")->get();

        return response()->json(['notes' => $notes]);
    }

}
