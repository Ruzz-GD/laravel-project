<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        return Ticket::with('event', 'participants')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required|exists:events,id',
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'sometimes|string|max:50',
        ]);

        $ticket = Ticket::create($validated);

        return response()->json($ticket, 201);
    }

    public function show($id)
    {
        $ticket = Ticket::with('event', 'participants')->findOrFail($id);
        return response()->json($ticket, 200);
    }

    public function update(Request $request, $id)
    {
        $ticket = Ticket::findOrFail($id);

        $validated = $request->validate([
            'event_id' => 'sometimes|exists:events,id',
            'type' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'status' => 'sometimes|string|max:50',
        ]);

        $ticket->update($validated);

        return response()->json($ticket, 200);
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return response()->json(null, 204);
    }
}
