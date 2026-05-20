<?php

namespace App\Http\Controllers;

use App\Models\FitnessLog;
use Illuminate\Http\Request;
use Carbon\Carbon;

class FitnessLogController extends Controller
{
    /**
     * Display fitness tracking overview.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $logs = FitnessLog::where('user_id', $user->id)
            ->orderBy('log_date', 'desc')
            ->paginate(14);

        // Chart data for last 30 days
        $chartData = $this->getChartData($user->id, 30);

        // Today's log
        $todayLog = FitnessLog::where('user_id', $user->id)
            ->where('log_date', Carbon::today())
            ->first();

        // Weekly averages
        $weekStart = Carbon::now()->startOfWeek();
        $weeklyLogs = FitnessLog::where('user_id', $user->id)
            ->whereBetween('log_date', [$weekStart, Carbon::today()])
            ->get();

        $averages = [
            'steps' => $weeklyLogs->avg('steps') ?: 0,
            'water' => $weeklyLogs->avg('water_intake_ml') ?: 0,
            'sleep' => $weeklyLogs->avg('sleep_hours') ?: 0,
            'calories' => $weeklyLogs->avg('calories_consumed') ?: 0,
        ];

        return view('fitness.index', compact('logs', 'chartData', 'todayLog', 'averages'));
    }

    /**
     * Show the form for creating/editing today's log.
     */
    public function create()
    {
        $todayLog = FitnessLog::where('user_id', auth()->id())
            ->where('log_date', Carbon::today())
            ->first();

        return view('fitness.create', compact('todayLog'));
    }

    /**
     * Store or update today's fitness log.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'log_date' => 'required|date',
            'steps' => 'nullable|integer|min:0',
            'water_intake_ml' => 'nullable|integer|min:0',
            'calories_consumed' => 'nullable|integer|min:0',
            'calories_burned' => 'nullable|integer|min:0',
            'sleep_hours' => 'nullable|numeric|min:0|max:24',
            'weight' => 'nullable|numeric|min:20|max:300',
            'heart_rate' => 'nullable|integer|min:30|max:250',
            'mood' => 'nullable|in:great,good,neutral,bad,terrible',
            'notes' => 'nullable|string',
        ]);

        $validated['user_id'] = $request->user()->id;

        FitnessLog::updateOrCreate(
            ['user_id' => $validated['user_id'], 'log_date' => $validated['log_date']],
            $validated
        );

        // Update user weight if provided
        if (!empty($validated['weight'])) {
            $request->user()->update(['weight' => $validated['weight']]);
        }

        return redirect()->route('fitness.index')
            ->with('success', 'Fitness log saved successfully!');
    }

    /**
     * Get chart data for analytics.
     */
    private function getChartData($userId, $days): array
    {
        $labels = [];
        $steps = [];
        $water = [];
        $sleep = [];
        $weight = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('M d');

            $log = FitnessLog::where('user_id', $userId)
                ->where('log_date', $date)
                ->first();

            $steps[] = $log ? $log->steps : 0;
            $water[] = $log ? $log->water_intake_ml : 0;
            $sleep[] = $log ? (float)$log->sleep_hours : 0;
            $weight[] = $log && $log->weight ? (float)$log->weight : null;
        }

        return compact('labels', 'steps', 'water', 'sleep', 'weight');
    }
}
