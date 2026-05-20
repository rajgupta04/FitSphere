<x-app-layout>
@section('title', $workout->name)
@section('subtitle', 'Workout details and exercises')

<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="gradient-primary p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <span class="px-3 py-1 rounded-full text-xs font-bold bg-white/20 backdrop-blur">{{ ucfirst($workout->category) }}</span>
                    <h2 class="text-2xl font-bold mt-2">{{ $workout->name }}</h2>
                    <p class="text-white/70 text-sm mt-1">{{ $workout->workout_date->format('F d, Y') }}</p>
                </div>
                <div class="text-right">
                    @if($workout->completed)
                    <span class="inline-flex items-center gap-1 bg-green-400/20 text-green-100 px-4 py-2 rounded-xl text-sm font-bold"><i class="fas fa-check-circle"></i> Completed</span>
                    @else
                    <span class="inline-flex items-center gap-1 bg-yellow-400/20 text-yellow-100 px-4 py-2 rounded-xl text-sm font-bold"><i class="fas fa-clock"></i> Pending</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-3 gap-4 mb-6">
                <div class="text-center p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                    <i class="fas fa-clock text-purple-500 text-xl mb-2"></i>
                    <p class="text-xl font-bold">{{ $workout->duration_minutes }}<span class="text-sm font-normal text-gray-400">min</span></p>
                    <p class="text-xs text-gray-400">Duration</p>
                </div>
                <div class="text-center p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                    <i class="fas fa-fire text-orange-500 text-xl mb-2"></i>
                    <p class="text-xl font-bold text-orange-500">{{ $workout->calories_burned }}</p>
                    <p class="text-xs text-gray-400">Calories</p>
                </div>
                <div class="text-center p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                    <i class="fas fa-bolt text-yellow-500 text-xl mb-2"></i>
                    <p class="text-xl font-bold capitalize">{{ $workout->intensity }}</p>
                    <p class="text-xs text-gray-400">Intensity</p>
                </div>
            </div>
            @if($workout->description)
            <div class="mb-6">
                <h4 class="font-semibold mb-2">Description</h4>
                <p class="text-gray-600 dark:text-gray-300 text-sm">{{ $workout->description }}</p>
            </div>
            @endif
            @if($workout->exercises->count())
            <h4 class="font-semibold mb-3"><i class="fas fa-list-ul text-primary-500 mr-2"></i>Exercises ({{ $workout->exercises->count() }})</h4>
            <div class="space-y-2">
                @foreach($workout->exercises as $exercise)
                <div class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                    <div class="w-8 h-8 rounded-lg gradient-primary flex items-center justify-center text-white text-xs font-bold">{{ $loop->iteration }}</div>
                    <div class="flex-1">
                        <p class="font-medium text-sm">{{ $exercise->name }}</p>
                        <p class="text-xs text-gray-400">{{ $exercise->sets }} sets × {{ $exercise->reps }} reps {{ $exercise->weight ? '@ '.$exercise->weight.'kg' : '' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
            <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('workouts.edit', $workout) }}" class="px-5 py-2.5 rounded-xl bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 font-semibold text-sm hover:bg-primary-200 transition"><i class="fas fa-pen mr-1"></i> Edit</a>
                <a href="{{ route('workouts.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">← Back</a>
            </div>
        </div>
    </div>
</div>
</x-app-layout>
