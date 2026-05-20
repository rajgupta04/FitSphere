<?php

namespace App\Http\Controllers;

use App\Models\DietLog;
use App\Models\Meal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DietController extends Controller
{
    /**
     * Display diet overview with nutrition tracking.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today();

        // Today's meals
        $todayMeals = DietLog::where('user_id', $user->id)
            ->where('log_date', $today)
            ->orderByRaw("CASE meal_type WHEN 'breakfast' THEN 1 WHEN 'lunch' THEN 2 WHEN 'dinner' THEN 3 WHEN 'snack' THEN 4 END")
            ->get();

        $todayTotals = [
            'calories' => $todayMeals->sum('calories'),
            'protein' => $todayMeals->sum('protein_g'),
            'carbs' => $todayMeals->sum('carbs_g'),
            'fat' => $todayMeals->sum('fat_g'),
        ];

        // Diet history
        $dietHistory = DietLog::where('user_id', $user->id)
            ->orderBy('log_date', 'desc')
            ->paginate(20);

        // Suggested meals
        $suggestedMeals = Meal::where('is_healthy', true)
            ->inRandomOrder()
            ->take(6)
            ->get();

        // Weekly chart data
        $chartData = $this->getWeeklyChartData($user->id);

        return view('diet.index', compact('todayMeals', 'todayTotals', 'dietHistory', 'suggestedMeals', 'chartData'));
    }

    /**
     * Show form to add a meal entry.
     */
    public function create()
    {
        $meals = Meal::orderBy('name')->get();
        return view('diet.create', compact('meals'));
    }

    /**
     * Store a new diet log entry.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'log_date' => 'required|date',
            'meal_type' => 'required|in:breakfast,lunch,dinner,snack',
            'food_name' => 'required|string|max:255',
            'calories' => 'required|integer|min:0',
            'protein_g' => 'nullable|numeric|min:0',
            'carbs_g' => 'nullable|numeric|min:0',
            'fat_g' => 'nullable|numeric|min:0',
            'fiber_g' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = $request->user()->id;
        DietLog::create($validated);

        return redirect()->route('diet.index')
            ->with('success', 'Meal logged successfully!');
    }

    /**
     * Delete a diet log entry.
     */
    public function destroy(DietLog $dietLog)
    {
        if ($dietLog->user_id !== auth()->id()) {
            abort(403);
        }
        $dietLog->delete();

        return back()->with('success', 'Diet log entry deleted!');
    }

    /**
     * Get weekly nutrition chart data.
     */
    private function getWeeklyChartData($userId): array
    {
        $labels = [];
        $calories = [];
        $protein = [];
        $carbs = [];
        $fat = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('D');

            $dayLogs = DietLog::where('user_id', $userId)
                ->where('log_date', $date)
                ->get();

            $calories[] = $dayLogs->sum('calories');
            $protein[] = (float)$dayLogs->sum('protein_g');
            $carbs[] = (float)$dayLogs->sum('carbs_g');
            $fat[] = (float)$dayLogs->sum('fat_g');
        }

        return compact('labels', 'calories', 'protein', 'carbs', 'fat');
    }
}
