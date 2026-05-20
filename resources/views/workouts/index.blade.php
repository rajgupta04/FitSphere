<x-app-layout>
@section('title', 'My Workouts')
@section('subtitle', 'Manage and track your workout routines')

<div class="space-y-6">
    <!-- Stats Bar -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center"><i class="fas fa-list text-blue-500"></i></div>
                <div><p class="text-xl font-bold">{{ $stats['total'] }}</p><p class="text-xs text-gray-400">Total Workouts</p></div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center"><i class="fas fa-check-circle text-green-500"></i></div>
                <div><p class="text-xl font-bold">{{ $stats['completed'] }}</p><p class="text-xs text-gray-400">Completed</p></div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center"><i class="fas fa-fire text-orange-500"></i></div>
                <div><p class="text-xl font-bold">{{ number_format($stats['calories']) }}</p><p class="text-xs text-gray-400">Calories Burned</p></div>
            </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-100 dark:border-gray-700">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center"><i class="fas fa-clock text-purple-500"></i></div>
                <div><p class="text-xl font-bold">{{ number_format($stats['duration']) }}<span class="text-sm font-normal text-gray-400">min</span></p><p class="text-xs text-gray-400">Total Duration</p></div>
            </div>
        </div>
    </div>

    <!-- Actions & Filters -->
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        <a href="{{ route('workouts.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-primary-500 to-accent-500 text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:shadow-lg transition-all hover:-translate-y-0.5">
            <i class="fas fa-plus"></i> New Workout
        </a>
        <form method="GET" action="{{ route('workouts.index') }}" class="flex flex-wrap gap-2">
            <select name="category" class="text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 px-3 py-2 focus:ring-primary-500" onchange="this.form.submit()">
                <option value="">All Categories</option>
                <option value="cardio" {{ request('category') == 'cardio' ? 'selected' : '' }}>🏃 Cardio</option>
                <option value="strength" {{ request('category') == 'strength' ? 'selected' : '' }}>💪 Strength</option>
                <option value="yoga" {{ request('category') == 'yoga' ? 'selected' : '' }}>🧘 Yoga</option>
                <option value="sports" {{ request('category') == 'sports' ? 'selected' : '' }}>⚽ Sports</option>
            </select>
            <div class="relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search workouts..." class="text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 pl-9 pr-4 py-2 w-48 focus:ring-primary-500">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
            </div>
        </form>
    </div>

    <!-- Workouts Grid -->
    @if($workouts->count())
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($workouts as $workout)
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="p-5">
                <div class="flex items-center justify-between mb-3">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $workout->category === 'cardio' ? 'bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400' : '' }}
                        {{ $workout->category === 'strength' ? 'bg-blue-100 text-blue-600 dark:bg-blue-900/30 dark:text-blue-400' : '' }}
                        {{ $workout->category === 'yoga' ? 'bg-green-100 text-green-600 dark:bg-green-900/30 dark:text-green-400' : '' }}
                        {{ $workout->category === 'sports' ? 'bg-yellow-100 text-yellow-600 dark:bg-yellow-900/30 dark:text-yellow-400' : '' }}">
                        {{ ucfirst($workout->category) }}
                    </span>
                    @if($workout->completed)
                    <span class="text-green-500"><i class="fas fa-check-circle"></i></span>
                    @endif
                </div>
                <h3 class="font-bold text-lg mb-1 group-hover:text-primary-500 transition">{{ $workout->name }}</h3>
                <p class="text-xs text-gray-400 mb-4">{{ $workout->workout_date->format('M d, Y') }}</p>

                <div class="grid grid-cols-3 gap-2 mb-4">
                    <div class="text-center p-2 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                        <p class="text-xs text-gray-400">Duration</p>
                        <p class="font-bold text-sm">{{ $workout->duration_minutes }}m</p>
                    </div>
                    <div class="text-center p-2 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                        <p class="text-xs text-gray-400">Calories</p>
                        <p class="font-bold text-sm text-orange-500">{{ $workout->calories_burned }}</p>
                    </div>
                    <div class="text-center p-2 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                        <p class="text-xs text-gray-400">Intensity</p>
                        <p class="font-bold text-sm capitalize">{{ $workout->intensity }}</p>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <form method="POST" action="{{ route('workouts.toggle-complete', $workout) }}" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full py-2 rounded-xl text-xs font-semibold transition {{ $workout->completed ? 'bg-green-100 text-green-600 hover:bg-green-200 dark:bg-green-900/30' : 'bg-gray-100 text-gray-600 hover:bg-gray-200 dark:bg-gray-700' }}">
                            {{ $workout->completed ? '✓ Completed' : 'Mark Complete' }}
                        </button>
                    </form>
                    <a href="{{ route('workouts.edit', $workout) }}" class="p-2 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-primary-100 dark:hover:bg-primary-900/30 transition">
                        <i class="fas fa-pen text-xs text-gray-500"></i>
                    </a>
                    <form method="POST" action="{{ route('workouts.destroy', $workout) }}" onsubmit="return confirm('Delete this workout?')">
                        @csrf @method('DELETE')
                        <button class="p-2 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-red-100 dark:hover:bg-red-900/30 transition">
                            <i class="fas fa-trash text-xs text-gray-500"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-6">{{ $workouts->links() }}</div>
    @else
    <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
        <i class="fas fa-dumbbell text-6xl text-gray-200 dark:text-gray-600 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-400 mb-2">No Workouts Yet</h3>
        <p class="text-gray-400 mb-6">Start your fitness journey by creating your first workout!</p>
        <a href="{{ route('workouts.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-primary-500 to-accent-500 text-white px-6 py-3 rounded-xl font-semibold hover:shadow-lg transition">
            <i class="fas fa-plus"></i> Create Workout
        </a>
    </div>
    @endif
</div>
</x-app-layout>
