<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Http\Requests\StoreNoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Services\NoteService;
use Illuminate\Routing\Controllers\Middleware;

class NoteController extends Controller
{
    public function __construct(
        protected NoteService $noteService
    )
    {

    }

    public static function middleware(): array
    {
        return [
            new Middleware('can:view note', only: ['index', 'show','getNotes']),
            new Middleware('can:add note', only: ['create', 'store']),
            new Middleware('can:edit note', only: ['edit', 'update']),
            new Middleware('can:delete note', only: ['destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreNoteRequest $request)
    {
        return $this->noteService->saveNote($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Note $note)
    {
        return $this->noteService->findNoteType($note->type);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Note $note)
    {
        return $note->only('id', 'type', 'description');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNoteRequest $request, Note $note): \Illuminate\Http\JsonResponse
    {
        if($note->user_id == auth()->id() || auth()->user()->hasRole('super admin'))
        {
            // Fill the new values
            $note->fill($request->only('type', 'description'));

            // Check if any field actually changed
            if (! $note->isDirty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No changes detected.'
                ], 200);
            }

            // Save updated note
            $note->save();

            return response()->json([
                'success' => true,
                'message' => 'Note updated successfully.'
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'You are not authorized to update this note.'
        ],401);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Note $note): \Illuminate\Http\JsonResponse
    {
        if($note->user_id == auth()->id() || auth()->user()->hasRole('super admin'))
        {
            return $note->delete() ?
                response()->json(['success' => true, 'message' => 'Note deleted.'], 200) :
                response()->json(['success' => false, 'message' => 'Something went wrong.'], 500);
        }
        return response()->json([
            'success' => false,
            'message' => 'You are not authorized to delete this note.'
        ],401);
    }

    public function getNotes(string $lead_id): \Illuminate\Http\JsonResponse
    {
        return $this->noteService->getNotes($lead_id);

    }
}
