<x-app-layout>
@section('title', 'Log Fitness Activity')
@section('subtitle', 'Record your daily health metrics')

<div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 lg:p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-green-500 to-emerald-500 flex items-center justify-center"><i class="fas fa-heartbeat text-white text-lg"></i></div>
            <div>
                <h3 class="text-xl font-bold">{{ $todayLog ? 'Update' : 'Log' }} Today's Activity</h3>
                <p class="text-sm text-gray-400">{{ now()->format('l, F d, Y') }}</p>
            </div>
        </div>

        <form method="POST" action="{{ route('fitness.store') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="log_date" value="{{ date('Y-m-d') }}">

            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold mb-2"><i class="fas fa-shoe-prints text-green-500 mr-1"></i> Steps</label>
                    <input type="number" name="steps" value="{{ old('steps', $todayLog?->steps ?? 0) }}" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500" min="0">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2"><i class="fas fa-tint text-blue-500 mr-1"></i> Water Intake (ml)</label>
                    <input type="number" name="water_intake_ml" value="{{ old('water_intake_ml', $todayLog?->water_intake_ml ?? 0) }}" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500" min="0">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2"><i class="fas fa-utensils text-orange-500 mr-1"></i> Calories Consumed</label>
                    <input type="number" name="calories_consumed" value="{{ old('calories_consumed', $todayLog?->calories_consumed ?? 0) }}" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500" min="0">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2"><i class="fas fa-fire text-red-500 mr-1"></i> Calories Burned</label>
                    <input type="number" name="calories_burned" value="{{ old('calories_burned', $todayLog?->calories_burned ?? 0) }}" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500" min="0">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2"><i class="fas fa-moon text-indigo-500 mr-1"></i> Sleep Hours</label>
                    <input type="number" name="sleep_hours" value="{{ old('sleep_hours', $todayLog?->sleep_hours ?? 0) }}" step="0.5" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500" min="0" max="24">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2"><i class="fas fa-weight text-purple-500 mr-1"></i> Weight (kg)</label>
                    <input type="number" name="weight" value="{{ old('weight', $todayLog?->weight) }}" step="0.1" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500" min="20" max="300">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2"><i class="fas fa-heart text-pink-500 mr-1"></i> Heart Rate (bpm)</label>
                    <input type="number" name="heart_rate" value="{{ old('heart_rate', $todayLog?->heart_rate) }}" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500" min="30" max="250">
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2"><i class="fas fa-smile text-yellow-500 mr-1"></i> Mood</label>
                    <select name="mood" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500">
                        <option value="">Select mood</option>
                        @foreach(['great' => '😄 Great', 'good' => '🙂 Good', 'neutral' => '😐 Neutral', 'bad' => '😟 Bad', 'terrible' => '😢 Terrible'] as $val => $label)
                        <option value="{{ $val }}" {{ old('mood', $todayLog?->mood) == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-semibold mb-2">Notes</label>
                <textarea name="notes" rows="2" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500">{{ old('notes', $todayLog?->notes) }}</textarea>
            </div>

            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-green-500 to-emerald-500 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition-all hover:-translate-y-0.5">
                    <i class="fas fa-save mr-2"></i> {{ $todayLog ? 'Update' : 'Save' }} Log
                </button>
                <a href="{{ route('fitness.index') }}" class="px-6 py-3 rounded-xl border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition font-medium text-sm">Cancel</a>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
