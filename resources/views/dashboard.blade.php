<x-app-layout>
@section('title', 'Dashboard')
@section('subtitle', 'Your fitness overview at a glance')

<div class="space-y-6 animate-fade-in">
    <!-- Welcome Banner -->
    <div class="relative overflow-hidden rounded-2xl gradient-primary p-6 lg:p-8 text-white">
        <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-1/2 w-32 h-32 bg-white/5 rounded-full translate-y-1/2"></div>
        <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
            <div>
                <h2 class="text-2xl lg:text-3xl font-bold">Welcome back, {{ Auth::user()->name }}! 👋</h2>
                <p class="mt-2 text-white/80 text-sm lg:text-base">Track your fitness journey and crush your goals today.</p>
                <div class="flex items-center gap-4 mt-4">
                    <a href="{{ route('workouts.create') }}" class="inline-flex items-center gap-2 bg-white text-primary-600 px-5 py-2.5 rounded-xl font-semibold text-sm hover:bg-white/90 transition shadow-lg">
                        <i class="fas fa-plus"></i> New Workout
                    </a>
                    <a href="{{ route('fitness.create') }}" class="inline-flex items-center gap-2 bg-white/20 text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:bg-white/30 transition backdrop-blur">
                        <i class="fas fa-chart-line"></i> Log Activity
                    </a>
                </div>
            </div>
            <div class="flex items-center gap-6">
                <!-- Fitness Score Circle -->
                <div class="text-center">
                    <div class="relative w-24 h-24">
                        <svg class="w-24 h-24 -rotate-90" viewBox="0 0 36 36">
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="3"/>
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="white" stroke-width="3" stroke-dasharray="{{ $fitnessScore }}, 100" stroke-linecap="round"/>
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-2xl font-bold">{{ $fitnessScore }}</span>
                        </div>
                    </div>
                    <p class="text-xs text-white/70 mt-1">Fitness Score</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats Row -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- BMI Card -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <i class="fas fa-weight text-blue-500"></i>
                </div>
                <span class="text-xs font-medium px-2 py-1 rounded-full {{ $user->bmi_category === 'Normal' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">
                    {{ $user->bmi_category }}
                </span>
            </div>
            <p class="text-2xl font-bold">{{ $user->bmi ?? 'N/A' }}</p>
            <p class="text-xs text-gray-400 mt-1">BMI Score</p>
        </div>

        <!-- Calories Burned -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center">
                    <i class="fas fa-fire-flame-curved text-orange-500"></i>
                </div>
                <i class="fas fa-arrow-up text-green-400 text-xs"></i>
            </div>
            <p class="text-2xl font-bold">{{ number_format($weeklyCaloriesBurned) }}</p>
            <p class="text-xs text-gray-400 mt-1">Calories Burned (Week)</p>
        </div>

        <!-- Workouts Completed -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                    <i class="fas fa-dumbbell text-purple-500"></i>
                </div>
                <span class="text-xs text-gray-400">{{ $completedWorkouts }}/{{ $totalWorkoutsToday }} today</span>
            </div>
            <p class="text-2xl font-bold">{{ $weeklyDuration }} <span class="text-sm font-normal text-gray-400">min</span></p>
            <p class="text-xs text-gray-400 mt-1">Workout Time (Week)</p>
        </div>

        <!-- Daily Steps -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                    <i class="fas fa-shoe-prints text-green-500"></i>
                </div>
            </div>
            <p class="text-2xl font-bold">{{ $todayLog ? number_format($todayLog->steps) : '0' }}</p>
            <p class="text-xs text-gray-400 mt-1">Steps Today</p>
            @if($todayLog && $todayLog->steps > 0)
            <div class="mt-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                <div class="bg-green-500 h-1.5 rounded-full transition-all duration-500" style="width: {{ min(($todayLog->steps / 10000) * 100, 100) }}%"></div>
            </div>
            <p class="text-[10px] text-gray-400 mt-1">{{ min(round(($todayLog->steps / 10000) * 100), 100) }}% of 10K goal</p>
            @endif
        </div>
    </div>

    <!-- Daily Activity Summary -->
    @if($todayLog)
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
        <h3 class="text-lg font-bold mb-4"><i class="fas fa-chart-pie text-primary-500 mr-2"></i>Today's Activity Summary</h3>
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
            <div class="text-center p-3 rounded-xl bg-blue-50 dark:bg-blue-900/20">
                <i class="fas fa-tint text-blue-500 text-xl mb-2"></i>
                <p class="text-lg font-bold">{{ number_format($todayLog->water_intake_ml) }}<span class="text-xs font-normal">ml</span></p>
                <p class="text-[11px] text-gray-400">Water Intake</p>
            </div>
            <div class="text-center p-3 rounded-xl bg-orange-50 dark:bg-orange-900/20">
                <i class="fas fa-utensils text-orange-500 text-xl mb-2"></i>
                <p class="text-lg font-bold">{{ number_format($todayLog->calories_consumed) }}</p>
                <p class="text-[11px] text-gray-400">Calories In</p>
            </div>
            <div class="text-center p-3 rounded-xl bg-red-50 dark:bg-red-900/20">
                <i class="fas fa-fire text-red-500 text-xl mb-2"></i>
                <p class="text-lg font-bold">{{ number_format($todayLog->calories_burned) }}</p>
                <p class="text-[11px] text-gray-400">Calories Out</p>
            </div>
            <div class="text-center p-3 rounded-xl bg-indigo-50 dark:bg-indigo-900/20">
                <i class="fas fa-moon text-indigo-500 text-xl mb-2"></i>
                <p class="text-lg font-bold">{{ $todayLog->sleep_hours }}<span class="text-xs font-normal">hrs</span></p>
                <p class="text-[11px] text-gray-400">Sleep</p>
            </div>
            <div class="text-center p-3 rounded-xl bg-pink-50 dark:bg-pink-900/20">
                <i class="fas fa-heart text-pink-500 text-xl mb-2"></i>
                <p class="text-lg font-bold">{{ $todayLog->heart_rate ?? '-' }}<span class="text-xs font-normal">bpm</span></p>
                <p class="text-[11px] text-gray-400">Heart Rate</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Calories Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold"><i class="fas fa-fire-flame-curved text-orange-500 mr-2"></i>Calories (7 Days)</h3>
            </div>
            <canvas id="caloriesChart" class="w-full" height="200"></canvas>
        </div>

        <!-- Steps Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold"><i class="fas fa-shoe-prints text-green-500 mr-2"></i>Daily Steps (7 Days)</h3>
            </div>
            <canvas id="stepsChart" class="w-full" height="200"></canvas>
        </div>
    </div>

    <!-- Bottom Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Recent Workouts -->
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold"><i class="fas fa-dumbbell text-purple-500 mr-2"></i>Recent Workouts</h3>
                <a href="{{ route('workouts.index') }}" class="text-sm text-primary-500 hover:text-primary-600 font-medium">View All →</a>
            </div>
            @if($recentWorkouts->count())
            <div class="space-y-3">
                @foreach($recentWorkouts as $workout)
                <div class="flex items-center gap-4 p-3 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700/50 transition group">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center
                        {{ $workout->category === 'cardio' ? 'bg-red-100 dark:bg-red-900/30' : '' }}
                        {{ $workout->category === 'strength' ? 'bg-blue-100 dark:bg-blue-900/30' : '' }}
                        {{ $workout->category === 'yoga' ? 'bg-green-100 dark:bg-green-900/30' : '' }}
                        {{ $workout->category === 'sports' ? 'bg-yellow-100 dark:bg-yellow-900/30' : '' }}">
                        <i class="fas {{ $workout->category === 'cardio' ? 'fa-running text-red-500' : '' }}{{ $workout->category === 'strength' ? 'fa-dumbbell text-blue-500' : '' }}{{ $workout->category === 'yoga' ? 'fa-spa text-green-500' : '' }}{{ $workout->category === 'sports' ? 'fa-futbol text-yellow-500' : '' }}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-sm truncate">{{ $workout->name }}</p>
                        <p class="text-xs text-gray-400">{{ $workout->workout_date->format('M d, Y') }} · {{ $workout->duration_minutes }} min</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-semibold text-orange-500">{{ $workout->calories_burned }} cal</p>
                        @if($workout->completed)
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-green-100 text-green-600 font-medium">Done</span>
                        @else
                        <span class="text-[10px] px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-600 font-medium">Pending</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="text-center py-8 text-gray-400">
                <i class="fas fa-dumbbell text-4xl mb-3 opacity-30"></i>
                <p>No workouts yet. <a href="{{ route('workouts.create') }}" class="text-primary-500">Create one!</a></p>
            </div>
            @endif
        </div>

        <!-- Upcoming Events -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold"><i class="fas fa-calendar-alt text-blue-500 mr-2"></i>Upcoming Events</h3>
                <a href="{{ route('events.index') }}" class="text-sm text-primary-500 hover:text-primary-600 font-medium">View All →</a>
            </div>
            @if($upcomingEvents->count())
            <div class="space-y-3">
                @foreach($upcomingEvents as $event)
                <a href="{{ route('events.show', $event) }}" class="block p-3 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-primary-300 dark:hover:border-primary-600 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl gradient-info flex flex-col items-center justify-center text-white text-xs">
                            <span class="font-bold text-sm">{{ $event->event_date->format('d') }}</span>
                            <span class="text-[10px]">{{ $event->event_date->format('M') }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-sm truncate">{{ $event->title }}</p>
                            <p class="text-xs text-gray-400"><i class="fas fa-map-marker-alt mr-1"></i>{{ $event->location ?? 'TBD' }}</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <div class="text-center py-8 text-gray-400">
                <i class="fas fa-calendar text-3xl mb-2 opacity-30"></i>
                <p class="text-sm">No upcoming events</p>
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const isDark = document.documentElement.classList.contains('dark');
    const gridColor = isDark ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
    const textColor = isDark ? '#9ca3af' : '#6b7280';

    // Calories Chart
    new Chart(document.getElementById('caloriesChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode($chartDays) !!},
            datasets: [{
                label: 'Burned',
                data: {!! json_encode($chartCaloriesBurned) !!},
                backgroundColor: 'rgba(239, 68, 68, 0.8)',
                borderRadius: 8,
                barPercentage: 0.6,
            }, {
                label: 'Consumed',
                data: {!! json_encode($chartCaloriesConsumed) !!},
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderRadius: 8,
                barPercentage: 0.6,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { labels: { color: textColor, usePointStyle: true, pointStyle: 'circle', padding: 15, font: { size: 11 } } } },
            scales: {
                x: { grid: { display: false }, ticks: { color: textColor, font: { size: 11 } } },
                y: { grid: { color: gridColor }, ticks: { color: textColor, font: { size: 11 } } }
            }
        }
    });

    // Steps Chart
    new Chart(document.getElementById('stepsChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($chartDays) !!},
            datasets: [{
                label: 'Steps',
                data: {!! json_encode($chartSteps) !!},
                borderColor: '#10b981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#10b981',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { labels: { color: textColor, usePointStyle: true, pointStyle: 'circle', padding: 15, font: { size: 11 } } } },
            scales: {
                x: { grid: { display: false }, ticks: { color: textColor, font: { size: 11 } } },
                y: { grid: { color: gridColor }, ticks: { color: textColor, font: { size: 11 } } }
            }
        }
    });
});
</script>
@endpush

</x-app-layout>
