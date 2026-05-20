<x-app-layout>
@section('title', 'Create Workout')
@section('subtitle', 'Design a new workout plan')

<div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 lg:p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 rounded-xl gradient-primary flex items-center justify-center"><i class="fas fa-plus text-white text-lg"></i></div>
            <div>
                <h3 class="text-xl font-bold">New Workout</h3>
                <p class="text-sm text-gray-400">Fill in the details for your workout session</p>
            </div>
        </div>

        <form method="POST" action="{{ route('workouts.store') }}" class="space-y-5">
            @csrf
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold mb-2">Workout Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500 focus:border-primary-500" placeholder="e.g., Morning Run">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Category *</label>
                    <select name="category" required class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500">
                        <option value="">Select category</option>
                        <option value="cardio" {{ old('category') == 'cardio' ? 'selected' : '' }}>🏃 Cardio</option>
                        <option value="strength" {{ old('category') == 'strength' ? 'selected' : '' }}>💪 Strength</option>
                        <option value="yoga" {{ old('category') == 'yoga' ? 'selected' : '' }}>🧘 Yoga</option>
                        <option value="sports" {{ old('category') == 'sports' ? 'selected' : '' }}>⚽ Sports</option>
                    </select>
                    @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Description</label>
                <textarea name="description" rows="3" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500" placeholder="Describe your workout...">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-semibold mb-2">Duration (min) *</label>
                    <input type="number" name="duration_minutes" value="{{ old('duration_minutes', 30) }}" required min="1" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Calories Burned *</label>
                    <input type="number" name="calories_burned" value="{{ old('calories_burned', 200) }}" required min="0" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Intensity *</label>
                    <select name="intensity" required class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500">
                        <option value="low" {{ old('intensity') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="moderate" {{ old('intensity', 'moderate') == 'moderate' ? 'selected' : '' }}>Moderate</option>
                        <option value="high" {{ old('intensity') == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Workout Date *</label>
                <input type="date" name="workout_date" value="{{ old('workout_date', date('Y-m-d')) }}" required class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500">
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Notes</label>
                <textarea name="notes" rows="2" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500" placeholder="Any additional notes...">{{ old('notes') }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-primary-500 to-accent-500 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition-all hover:-translate-y-0.5">
                    <i class="fas fa-save mr-2"></i> Create Workout
                </button>
                <a href="{{ route('workouts.index') }}" class="px-6 py-3 rounded-xl border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition font-medium text-sm">Cancel</a>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
