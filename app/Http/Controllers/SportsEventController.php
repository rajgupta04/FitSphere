<?php

namespace App\Http\Controllers;

use App\Models\SportsEvent;
use App\Models\EventRegistration;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SportsEventController extends Controller
{
    /**
     * Display upcoming and past events.
     */
    public function index(Request $request)
    {
        $query = SportsEvent::query();

        if ($request->filled('sport_type')) {
            $query->where('sport_type', $request->sport_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $events = $query->withCount('registrations')
            ->orderBy('event_date', 'asc')
            ->paginate(9);

        $myRegistrations = EventRegistration::where('user_id', auth()->id())
            ->pluck('sports_event_id')
            ->toArray();

        return view('events.index', compact('events', 'myRegistrations'));
    }

    /**
     * Show form to create a new event (admin only).
     */
    public function create()
    {
        return view('events.create');
    }

    /**
     * Store a new sports event.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sport_type' => 'required|string|max:100',
            'event_date' => 'required|date|after:today',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'location' => 'nullable|string|max:255',
            'max_participants' => 'required|integer|min:2',
        ]);

        $validated['created_by'] = $request->user()->id;
        SportsEvent::create($validated);

        return redirect()->route('events.index')
            ->with('success', 'Sports event created successfully!');
    }

    /**
     * Display event details.
     */
    public function show(SportsEvent $event)
    {
        $event->load('registrations.user', 'creator');
        $isRegistered = EventRegistration::where('user_id', auth()->id())
            ->where('sports_event_id', $event->id)
            ->exists();

        return view('events.show', compact('event', 'isRegistered'));
    }

    /**
     * Register for an event.
     */
    public function register(Request $request, SportsEvent $event)
    {
        if ($event->is_full) {
            return back()->with('error', 'This event is full!');
        }

        $existing = EventRegistration::where('user_id', auth()->id())
            ->where('sports_event_id', $event->id)
            ->first();

        if ($existing) {
            return back()->with('error', 'You are already registered for this event!');
        }

        EventRegistration::create([
            'user_id' => auth()->id(),
            'sports_event_id' => $event->id,
            'team_name' => $request->team_name,
            'status' => 'registered',
        ]);

        return back()->with('success', 'Successfully registered for the event!');
    }

    /**
     * Cancel event registration.
     */
    public function cancelRegistration(SportsEvent $event)
    {
        EventRegistration::where('user_id', auth()->id())
            ->where('sports_event_id', $event->id)
            ->delete();

        return back()->with('success', 'Registration cancelled.');
    }

    /**
     * Edit event (admin only).
     */
    public function edit(SportsEvent $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update event.
     */
    public function update(Request $request, SportsEvent $event)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'sport_type' => 'required|string|max:100',
            'event_date' => 'required|date',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'location' => 'nullable|string|max:255',
            'max_participants' => 'required|integer|min:2',
            'status' => 'required|in:upcoming,ongoing,completed,cancelled',
        ]);

        $event->update($validated);

        return redirect()->route('events.show', $event)
            ->with('success', 'Event updated successfully!');
    }

    /**
     * Delete event.
     */
    public function destroy(SportsEvent $event)
    {
        $event->delete();
        return redirect()->route('events.index')
            ->with('success', 'Event deleted successfully!');
    }
}
