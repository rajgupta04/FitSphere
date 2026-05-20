<?php

namespace App\Http\Controllers;

use App\Models\Workout;
use App\Models\FitnessLog;
use App\Models\DietLog;
use App\Models\SportsEvent;
use App\Models\Notification;
use App\Models\ProgressReport;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show the user dashboard with widgets and analytics.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today();
        $weekStart = Carbon::now()->startOfWeek();

        // Today's fitness log
        $todayLog = FitnessLog::where('user_id', $user->id)
            ->where('log_date', $today)
            ->first();

        // Today's workouts
        $todayWorkouts = Workout::where('user_id', $user->id)
            ->where('workout_date', $today)
            ->get();

        $completedWorkouts = $todayWorkouts->where('completed', true)->count();
        $totalWorkoutsToday = $todayWorkouts->count();

        // Weekly stats
        $weeklyWorkouts = Workout::where('user_id', $user->id)
            ->whereBetween('workout_date', [$weekStart, $today])
            ->get();

        $weeklyCaloriesBurned = $weeklyWorkouts->sum('calories_burned');
        $weeklyDuration = $weeklyWorkouts->sum('duration_minutes');

        // Weekly calories consumed
        $weeklyDiet = DietLog::where('user_id', $user->id)
            ->whereBetween('log_date', [$weekStart, $today])
            ->sum('calories');

        // Chart data - last 7 days
        $chartDays = [];
        $chartCaloriesBurned = [];
        $chartCaloriesConsumed = [];
        $chartSteps = [];
        $chartWeight = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $chartDays[] = $date->format('D');

            $dayLog = FitnessLog::where('user_id', $user->id)
                ->where('log_date', $date)
                ->first();

            $dayWorkouts = Workout::where('user_id', $user->id)
                ->where('workout_date', $date)
                ->sum('calories_burned');

            $dayDiet = DietLog::where('user_id', $user->id)
                ->where('log_date', $date)
                ->sum('calories');

            $chartCaloriesBurned[] = $dayWorkouts ?: ($dayLog ? $dayLog->calories_burned : 0);
            $chartCaloriesConsumed[] = $dayDiet ?: ($dayLog ? $dayLog->calories_consumed : 0);
            $chartSteps[] = $dayLog ? $dayLog->steps : 0;
            $chartWeight[] = $dayLog ? $dayLog->weight : null;
        }

        // Upcoming events
        $upcomingEvents = SportsEvent::where('event_date', '>=', $today)
            ->where('status', 'upcoming')
            ->orderBy('event_date')
            ->take(3)
            ->get();

        // Unread notifications
        $unreadNotifications = Notification::where('user_id', $user->id)
            ->unread()
            ->latest()
            ->take(5)
            ->get();

        // Fitness score (simple calculation)
        $fitnessScore = $this->calculateFitnessScore($user);

        // Recent workouts
        $recentWorkouts = Workout::where('user_id', $user->id)
            ->orderBy('workout_date', 'desc')
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'user',
            'todayLog',
            'todayWorkouts',
            'completedWorkouts',
            'totalWorkoutsToday',
            'weeklyCaloriesBurned',
            'weeklyDuration',
            'weeklyDiet',
            'chartDays',
            'chartCaloriesBurned',
            'chartCaloriesConsumed',
            'chartSteps',
            'chartWeight',
            'upcomingEvents',
            'unreadNotifications',
            'fitnessScore',
            'recentWorkouts',
        ));
    }

    /**
     * Calculate a simple fitness score based on user activity.
     */
    private function calculateFitnessScore($user): int
    {
        $score = 50; // base score
        $weekStart = Carbon::now()->startOfWeek();

        // Add points for workouts
        $weeklyWorkouts = Workout::where('user_id', $user->id)
            ->whereBetween('workout_date', [$weekStart, Carbon::today()])
            ->where('completed', true)
            ->count();
        $score += min($weeklyWorkouts * 5, 20);

        // Add points for logging fitness
        $weeklyLogs = FitnessLog::where('user_id', $user->id)
            ->whereBetween('log_date', [$weekStart, Carbon::today()])
            ->count();
        $score += min($weeklyLogs * 3, 15);

        // Add points for healthy BMI
        if ($user->bmi) {
            if ($user->bmi >= 18.5 && $user->bmi < 25) {
                $score += 15;
            } elseif ($user->bmi >= 25 && $user->bmi < 30) {
                $score += 8;
            }
        }

        return min($score, 100);
    }
}
