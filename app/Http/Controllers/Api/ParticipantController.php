<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function index()
    {
        return Participant::with('ticket')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:participants,email',
            'phone_number' => 'sometimes|string|max:20',
            'ticket_id' => 'sometimes|exists:tickets,id',
            'registered_at' => 'sometimes|date',
        ]);

        $participant = Participant::create($validated);

        return response()->json($participant, 201);
    }

    public function show($id)
    {
        $participant = Participant::with('ticket')->findOrFail($id);
        return response()->json($participant, 200);
    }

    public function update(Request $request, $id)
    {
        $participant = Participant::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:participants,email,' . $participant->id,
            'phone_number' => 'sometimes|string|max:20',
            'ticket_id' => 'sometimes|exists:tickets,id',
            'registered_at' => 'sometimes|date',
        ]);

        $participant->update($validated);

        return response()->json($participant, 200);
    }

    public function destroy($id)
    {
        $participant = Participant::findOrFail($id);
        $participant->delete();

        return response()->json(null, 204);
    }
}
