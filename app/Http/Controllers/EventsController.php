<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Assignment;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Display a listing of the events.
     */
    public function index()
    {
        $events = Event::with('assignment')->get();
        $assignments = Assignment::all();
        return view('events.index', compact('events', 'assignments'));
    }


    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        $assignments = Assignment::all(); // Fetch assignments to populate dropdown
        return view('events.create', compact('assignments'));
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request)
    {
        // Validate the input
        $validated = $request->validate([
            'kegiatan' => 'required|string|max:255',
            'assignment_id' => 'nullable|exists:assignments,id', // Assignment is nullable
            'tanggal' => 'required|date',
        ]);

        // Create a new event
        Event::create($validated);

        // Redirect to the index with success message
        return redirect()->route('events.index')->with('success', 'Event created successfully!');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event)
    {
        $assignments = Assignment::all(); // Fetch assignments to populate dropdown
        return view('events.edit', compact('event', 'assignments'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, Event $event)
    {
        // Validate the input
        $validated = $request->validate([
            'kegiatan' => 'required|string|max:255',
            'assignment_id' => 'nullable|exists:assignments,id', // Assignment is nullable
            'tanggal' => 'required|date',
        ]);

        // Update the event
        $event->update($validated);

        // Redirect to the index with success message
        return redirect()->route('events.index')->with('success', 'Event updated successfully!');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event)
    {
        // Delete the event
        $event->delete();

        // Redirect to the index with success message
        return redirect()->route('events.index')->with('success', 'Event deleted successfully!');
    }
}
