<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Models\Exercise;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WorkoutController extends Controller
{
    /**
     * Display a listing of workouts.
     */
    public function index(Request $request)
    {
        $query = Workout::where('user_id', $request->user()->id);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by date range
        if ($request->filled('from')) {
            $query->where('workout_date', '>=', $request->from);
        }
        if ($request->filled('to')) {
            $query->where('workout_date', '<=', $request->to);
        }

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $workouts = $query->orderBy('workout_date', 'desc')->paginate(10);

        // Stats
        $stats = [
            'total' => Workout::where('user_id', $request->user()->id)->count(),
            'completed' => Workout::where('user_id', $request->user()->id)->where('completed', true)->count(),
            'calories' => Workout::where('user_id', $request->user()->id)->sum('calories_burned'),
            'duration' => Workout::where('user_id', $request->user()->id)->sum('duration_minutes'),
        ];

        return view('workouts.index', compact('workouts', 'stats'));
    }

    /**
     * Show the form for creating a new workout.
     */
    public function create()
    {
        return view('workouts.create');
    }

    /**
     * Store a newly created workout.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:cardio,strength,yoga,sports',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1',
            'calories_burned' => 'required|integer|min:0',
            'intensity' => 'required|in:low,moderate,high',
            'workout_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = $request->user()->id;

        $workout = Workout::create($validated);

        // Handle exercises if provided
        if ($request->has('exercises')) {
            foreach ($request->exercises as $exercise) {
                if (!empty($exercise['name'])) {
                    $workout->exercises()->create($exercise);
                }
            }
        }

        return redirect()->route('workouts.index')
            ->with('success', 'Workout created successfully!');
    }

    /**
     * Display the specified workout.
     */
    public function show(Workout $workout)
    {
        $this->authorize('view', $workout);
        $workout->load('exercises');
        return view('workouts.show', compact('workout'));
    }

    /**
     * Show the form for editing the workout.
     */
    public function edit(Workout $workout)
    {
        $this->authorize('update', $workout);
        $workout->load('exercises');
        return view('workouts.edit', compact('workout'));
    }

    /**
     * Update the specified workout.
     */
    public function update(Request $request, Workout $workout)
    {
        $this->authorize('update', $workout);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:cardio,strength,yoga,sports',
            'description' => 'nullable|string',
            'duration_minutes' => 'required|integer|min:1',
            'calories_burned' => 'required|integer|min:0',
            'intensity' => 'required|in:low,moderate,high',
            'workout_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $workout->update($validated);

        return redirect()->route('workouts.index')
            ->with('success', 'Workout updated successfully!');
    }

    /**
     * Remove the specified workout.
     */
    public function destroy(Workout $workout)
    {
        $this->authorize('delete', $workout);
        $workout->delete();

        return redirect()->route('workouts.index')
            ->with('success', 'Workout deleted successfully!');
    }

    /**
     * Toggle workout completion status.
     */
    public function toggleComplete(Workout $workout)
    {
        $this->authorize('update', $workout);
        $workout->update(['completed' => !$workout->completed]);

        return back()->with('success', 'Workout status updated!');
    }
}
