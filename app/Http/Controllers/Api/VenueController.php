<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Venue;
use Illuminate\Http\Request;

class VenueController extends Controller
{
    public function index()
    {
        return Venue::with('events')->get();
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'capacity' => 'required|integer|min:1',
            'contact_number' => 'sometimes|string|max:20',
        ]);

        $venue = Venue::create($validated);

        return response()->json($venue, 201);
    }

    public function show($id)
    {
        $venue = Venue::with('events')->findOrFail($id);
        return response()->json($venue, 200);
    }

    public function update(Request $request, $id)
    {
        $venue = Venue::findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'location' => 'sometimes|string|max:255',
            'capacity' => 'sometimes|integer|min:1',
            'contact_number' => 'sometimes|string|max:20',
        ]);

        $venue->update($validated);

        return response()->json($venue, 200);
    }

    public function destroy($id)
    {
        $venue = Venue::findOrFail($id);
        $venue->delete();

        return response()->json(null, 204);
    }
}
