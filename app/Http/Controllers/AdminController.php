<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Workout;
use App\Models\FitnessLog;
use App\Models\DietLog;
use App\Models\SportsEvent;
use App\Models\Feedback;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'total_workouts' => Workout::count(),
            'total_events' => SportsEvent::count(),
            'total_feedback' => Feedback::count(),
            'active_users' => User::where('updated_at', '>=', Carbon::now()->subDays(7))->count(),
            'pending_feedback' => Feedback::where('status', 'pending')->count(),
            'upcoming_events' => SportsEvent::where('status', 'upcoming')->count(),
        ];
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();
        $recentFeedback = Feedback::with('user')->orderBy('created_at', 'desc')->take(5)->get();
        $userGrowth = $this->getUserGrowthData();
        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentFeedback', 'userGrowth'));
    }

    public function users(Request $request)
    {
        $query = User::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%'.$request->search.'%')
                  ->orWhere('email', 'like', '%'.$request->search.'%');
        }
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        $users = $query->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.users', compact('users'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:admin,user']);
        $user->update(['role' => $request->role]);
        return back()->with('success', 'User role updated.');
    }

    public function deleteUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Cannot delete yourself!');
        }
        $user->delete();
        return back()->with('success', 'User deleted.');
    }

    public function workouts()
    {
        $workouts = Workout::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.workouts', compact('workouts'));
    }

    public function events()
    {
        $events = SportsEvent::withCount('registrations')->orderBy('event_date', 'desc')->paginate(15);
        return view('admin.events', compact('events'));
    }

    public function feedbacks()
    {
        $feedbacks = Feedback::with('user')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.feedbacks', compact('feedbacks'));
    }

    public function updateFeedbackStatus(Request $request, Feedback $feedback)
    {
        $request->validate(['status' => 'required|in:pending,reviewed,resolved']);
        $feedback->update(['status' => $request->status]);
        return back()->with('success', 'Feedback status updated.');
    }

    public function analytics()
    {
        $userGrowth = $this->getUserGrowthData();
        $workoutStats = $this->getWorkoutStats();
        $topUsers = User::withCount('workouts')->orderBy('workouts_count', 'desc')->take(10)->get();
        return view('admin.analytics', compact('userGrowth', 'workoutStats', 'topUsers'));
    }

    private function getUserGrowthData(): array
    {
        $labels = [];
        $data = [];
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $labels[] = $date->format('M Y');
            $data[] = User::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)->count();
        }
        return compact('labels', 'data');
    }

    private function getWorkoutStats(): array
    {
        $labels = [];
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $labels[] = $date->format('D');
            $data[] = Workout::whereDate('workout_date', $date)->count();
        }
        return compact('labels', 'data');
    }
}
