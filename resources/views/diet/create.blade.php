<x-app-layout>
@section('title', 'Log Meal')
@section('subtitle', 'Add a meal to your diet log')

<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 lg:p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-green-500 to-emerald-500 flex items-center justify-center"><i class="fas fa-utensils text-white text-lg"></i></div>
            <div><h3 class="text-xl font-bold">Log a Meal</h3><p class="text-sm text-gray-400">Record what you ate</p></div>
        </div>
        <form method="POST" action="{{ route('diet.store') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="log_date" value="{{ date('Y-m-d') }}">
            <div class="grid md:grid-cols-2 gap-5">
                <div>
                    <label class="block text-sm font-semibold mb-2">Meal Type *</label>
                    <select name="meal_type" required class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500">
                        <option value="breakfast">🌅 Breakfast</option>
                        <option value="lunch">☀️ Lunch</option>
                        <option value="dinner">🌙 Dinner</option>
                        <option value="snack">🍪 Snack</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-semibold mb-2">Food Name *</label>
                    <input type="text" name="food_name" value="{{ old('food_name') }}" required class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500" placeholder="e.g., Grilled Chicken Salad">
                    @error('food_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div><label class="block text-sm font-semibold mb-2">Calories *</label><input type="number" name="calories" value="{{ old('calories', 0) }}" required min="0" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500"></div>
                <div><label class="block text-sm font-semibold mb-2">Protein (g)</label><input type="number" name="protein_g" value="{{ old('protein_g', 0) }}" step="0.1" min="0" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500"></div>
                <div><label class="block text-sm font-semibold mb-2">Carbs (g)</label><input type="number" name="carbs_g" value="{{ old('carbs_g', 0) }}" step="0.1" min="0" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500"></div>
                <div><label class="block text-sm font-semibold mb-2">Fat (g)</label><input type="number" name="fat_g" value="{{ old('fat_g', 0) }}" step="0.1" min="0" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500"></div>
            </div>
            <div><label class="block text-sm font-semibold mb-2">Notes</label><textarea name="notes" rows="2" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500" placeholder="Any notes about this meal...">{{ old('notes') }}</textarea></div>
            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-green-500 to-emerald-500 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition-all"><i class="fas fa-save mr-2"></i> Log Meal</button>
                <a href="{{ route('diet.index') }}" class="px-6 py-3 rounded-xl border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
