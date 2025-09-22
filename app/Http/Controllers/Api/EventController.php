<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return Event::with(['venue', 'organizer', 'tickets'])->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'sometimes|string',
            'date' => 'required|date',
            'time' => 'sometimes|date_format:H:i',
            'venue_id' => 'required|exists:venues,id',
            'organizer_id' => 'sometimes|exists:users,id',
        ]);

        $event = Event::create($validated);

        return response()->json($event, 201);
    }

    public function show($id)
    {
        $event = Event::with(['venue', 'organizer', 'tickets'])->findOrFail($id);
        return response()->json($event, 200);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'date' => 'sometimes|date',
            'time' => 'sometimes|date_format:H:i',
            'venue_id' => 'sometimes|exists:venues,id',
            'organizer_id' => 'sometimes|exists:users,id',
        ]);

        $event->update($validated);

        return response()->json($event, 200);
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return response()->json(null, 204);
    }
}
