<x-app-layout>
@section('title', 'Edit Workout')
@section('subtitle', 'Update your workout details')

<div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 lg:p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-500 flex items-center justify-center"><i class="fas fa-pen text-white text-lg"></i></div>
            <div>
                <h3 class="text-xl font-bold">Edit: {{ $workout->name }}</h3>
                <p class="text-sm text-gray-400">Update workout information</p>
            </div>
        </div>

        <form method="POST" action="{{ route('workouts.update', $workout) }}" class="space-y-5">
            @csrf @method('PUT')
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold mb-2">Workout Name *</label>
                    <input type="text" name="name" value="{{ old('name', $workout->name) }}" required class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500 focus:border-primary-500">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Category *</label>
                    <select name="category" required class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500">
                        <option value="cardio" {{ old('category', $workout->category) == 'cardio' ? 'selected' : '' }}>🏃 Cardio</option>
                        <option value="strength" {{ old('category', $workout->category) == 'strength' ? 'selected' : '' }}>💪 Strength</option>
                        <option value="yoga" {{ old('category', $workout->category) == 'yoga' ? 'selected' : '' }}>🧘 Yoga</option>
                        <option value="sports" {{ old('category', $workout->category) == 'sports' ? 'selected' : '' }}>⚽ Sports</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Description</label>
                <textarea name="description" rows="3" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500">{{ old('description', $workout->description) }}</textarea>
            </div>
            <div class="grid grid-cols-3 gap-5">
                <div>
                    <label class="block text-sm font-semibold mb-2">Duration (min) *</label>
                    <input type="number" name="duration_minutes" value="{{ old('duration_minutes', $workout->duration_minutes) }}" required min="1" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Calories Burned *</label>
                    <input type="number" name="calories_burned" value="{{ old('calories_burned', $workout->calories_burned) }}" required min="0" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Intensity *</label>
                    <select name="intensity" required class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500">
                        <option value="low" {{ old('intensity', $workout->intensity) == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="moderate" {{ old('intensity', $workout->intensity) == 'moderate' ? 'selected' : '' }}>Moderate</option>
                        <option value="high" {{ old('intensity', $workout->intensity) == 'high' ? 'selected' : '' }}>High</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Workout Date *</label>
                <input type="date" name="workout_date" value="{{ old('workout_date', $workout->workout_date->format('Y-m-d')) }}" required class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500">
            </div>
            <div>
                <label class="block text-sm font-semibold mb-2">Notes</label>
                <textarea name="notes" rows="2" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500">{{ old('notes', $workout->notes) }}</textarea>
            </div>
            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-primary-500 to-accent-500 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition-all hover:-translate-y-0.5">
                    <i class="fas fa-save mr-2"></i> Update Workout
                </button>
                <a href="{{ route('workouts.index') }}" class="px-6 py-3 rounded-xl border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition font-medium text-sm">Cancel</a>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
