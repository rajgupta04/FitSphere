<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WorkoutController;
use App\Http\Controllers\FitnessLogController;
use App\Http\Controllers\DietController;
use App\Http\Controllers\SportsEventController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authenticated user routes
Route::middleware(['auth', 'verified'])->group(function () {

    // Onboarding
    Route::get('/onboarding', [App\Http\Controllers\OnboardingController::class, 'index'])->name('onboarding.index');
    Route::post('/onboarding', [App\Http\Controllers\OnboardingController::class, 'store'])->name('onboarding.store');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Workouts
    Route::resource('workouts', WorkoutController::class);
    Route::post('/workouts/{workout}/toggle-complete', [WorkoutController::class, 'toggleComplete'])->name('workouts.toggle-complete');

    // Fitness Tracking
    Route::get('/fitness', [FitnessLogController::class, 'index'])->name('fitness.index');
    Route::get('/fitness/create', [FitnessLogController::class, 'create'])->name('fitness.create');
    Route::post('/fitness', [FitnessLogController::class, 'store'])->name('fitness.store');

    // Diet & Nutrition
    Route::get('/diet', [DietController::class, 'index'])->name('diet.index');
    Route::get('/diet/create', [DietController::class, 'create'])->name('diet.create');
    Route::post('/diet', [DietController::class, 'store'])->name('diet.store');
    Route::delete('/diet/{dietLog}', [DietController::class, 'destroy'])->name('diet.destroy');

    // Sports Events
    Route::get('/events', [SportsEventController::class, 'index'])->name('events.index');
    Route::get('/events/create', [SportsEventController::class, 'create'])->name('events.create');
    Route::post('/events', [SportsEventController::class, 'store'])->name('events.store');
    Route::get('/events/{event}', [SportsEventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/edit', [SportsEventController::class, 'edit'])->name('events.edit');
    Route::put('/events/{event}', [SportsEventController::class, 'update'])->name('events.update');
    Route::delete('/events/{event}', [SportsEventController::class, 'destroy'])->name('events.destroy');
    Route::post('/events/{event}/register', [SportsEventController::class, 'register'])->name('events.register');
    Route::delete('/events/{event}/cancel-registration', [SportsEventController::class, 'cancelRegistration'])->name('events.cancel-registration');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');
    Route::delete('/notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    // Feedback
    Route::get('/feedback', [FeedbackController::class, 'index'])->name('feedback.index');
    Route::get('/feedback/create', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback', [FeedbackController::class, 'store'])->name('feedback.store');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::patch('/users/{user}/role', [AdminController::class, 'updateUserRole'])->name('users.update-role');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.delete');
    Route::get('/workouts', [AdminController::class, 'workouts'])->name('workouts');
    Route::get('/events', [AdminController::class, 'events'])->name('events');
    Route::get('/feedbacks', [AdminController::class, 'feedbacks'])->name('feedbacks');
    Route::patch('/feedbacks/{feedback}/status', [AdminController::class, 'updateFeedbackStatus'])->name('feedbacks.update-status');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
});

require __DIR__.'/auth.php';
