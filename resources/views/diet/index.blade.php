<x-app-layout>
@section('title', 'Diet & Nutrition')
@section('subtitle', 'Track meals and monitor nutrition intake')

<div class="space-y-6">
    <!-- Today's Nutrition Summary -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-bold text-lg"><i class="fas fa-utensils text-green-500 mr-2"></i>Today's Nutrition</h3>
            <a href="{{ route('diet.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-green-500 to-emerald-500 text-white px-4 py-2 rounded-xl text-sm font-semibold hover:shadow-lg transition"><i class="fas fa-plus"></i> Log Meal</a>
        </div>
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="text-center p-4 rounded-xl bg-orange-50 dark:bg-orange-900/20 border border-orange-100 dark:border-orange-900/30">
                <i class="fas fa-fire text-orange-500 text-2xl mb-2"></i>
                <p class="text-2xl font-bold">{{ number_format($todayTotals['calories']) }}</p>
                <p class="text-xs text-gray-400">Calories</p>
            </div>
            <div class="text-center p-4 rounded-xl bg-red-50 dark:bg-red-900/20 border border-red-100 dark:border-red-900/30">
                <i class="fas fa-drumstick-bite text-red-500 text-2xl mb-2"></i>
                <p class="text-2xl font-bold">{{ number_format($todayTotals['protein'], 1) }}g</p>
                <p class="text-xs text-gray-400">Protein</p>
            </div>
            <div class="text-center p-4 rounded-xl bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-100 dark:border-yellow-900/30">
                <i class="fas fa-bread-slice text-yellow-500 text-2xl mb-2"></i>
                <p class="text-2xl font-bold">{{ number_format($todayTotals['carbs'], 1) }}g</p>
                <p class="text-xs text-gray-400">Carbs</p>
            </div>
            <div class="text-center p-4 rounded-xl bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-900/30">
                <i class="fas fa-cheese text-blue-500 text-2xl mb-2"></i>
                <p class="text-2xl font-bold">{{ number_format($todayTotals['fat'], 1) }}g</p>
                <p class="text-xs text-gray-400">Fat</p>
            </div>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Today's Meals -->
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
                <h4 class="font-bold mb-4">Today's Meals</h4>
                @if($todayMeals->count())
                <div class="space-y-3">
                    @foreach($todayMeals as $meal)
                    <div class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50 group">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center
                            {{ $meal->meal_type === 'breakfast' ? 'bg-yellow-100 dark:bg-yellow-900/30' : '' }}
                            {{ $meal->meal_type === 'lunch' ? 'bg-green-100 dark:bg-green-900/30' : '' }}
                            {{ $meal->meal_type === 'dinner' ? 'bg-blue-100 dark:bg-blue-900/30' : '' }}
                            {{ $meal->meal_type === 'snack' ? 'bg-purple-100 dark:bg-purple-900/30' : '' }}">
                            <i class="fas {{ $meal->meal_type === 'breakfast' ? 'fa-sun text-yellow-500' : '' }}{{ $meal->meal_type === 'lunch' ? 'fa-cloud-sun text-green-500' : '' }}{{ $meal->meal_type === 'dinner' ? 'fa-moon text-blue-500' : '' }}{{ $meal->meal_type === 'snack' ? 'fa-cookie text-purple-500' : '' }}"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-sm">{{ $meal->food_name }}</p>
                            <p class="text-xs text-gray-400 capitalize">{{ $meal->meal_type }}</p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-sm text-orange-500">{{ $meal->calories }} cal</p>
                            <p class="text-[10px] text-gray-400">P:{{ $meal->protein_g }}g C:{{ $meal->carbs_g }}g F:{{ $meal->fat_g }}g</p>
                        </div>
                        <form method="POST" action="{{ route('diet.destroy', $meal) }}" onsubmit="return confirm('Delete this entry?')">
                            @csrf @method('DELETE')
                            <button class="opacity-0 group-hover:opacity-100 p-1 text-red-400 hover:text-red-600 transition"><i class="fas fa-trash text-xs"></i></button>
                        </form>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 text-gray-400">
                    <i class="fas fa-utensils text-3xl mb-2 opacity-30"></i>
                    <p class="text-sm">No meals logged today. <a href="{{ route('diet.create') }}" class="text-primary-500">Log one now!</a></p>
                </div>
                @endif
            </div>

            <!-- Weekly Chart -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700 mt-6">
                <h4 class="font-bold mb-4"><i class="fas fa-chart-area text-primary-500 mr-2"></i>Weekly Nutrition</h4>
                <canvas id="nutritionChart" height="200"></canvas>
            </div>
        </div>

        <!-- Suggested Meals -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
            <h4 class="font-bold mb-4"><i class="fas fa-lightbulb text-yellow-500 mr-2"></i>Healthy Suggestions</h4>
            <div class="space-y-3">
                @foreach($suggestedMeals as $meal)
                <div class="p-3 rounded-xl border border-gray-100 dark:border-gray-700 hover:border-green-300 dark:hover:border-green-700 transition">
                    <p class="font-semibold text-sm">{{ $meal->name }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $meal->description }}</p>
                    <div class="flex items-center gap-3 mt-2 text-xs text-gray-500">
                        <span class="text-orange-500 font-medium">{{ $meal->calories }} cal</span>
                        <span>P:{{ $meal->protein_g }}g</span>
                        <span>C:{{ $meal->carbs_g }}g</span>
                        <span>F:{{ $meal->fat_g }}g</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const textColor = document.documentElement.classList.contains('dark') ? '#9ca3af' : '#6b7280';
    new Chart(document.getElementById('nutritionChart'), {
        type: 'bar', data: {
            labels: {!! json_encode($chartData['labels']) !!},
            datasets: [
                { label: 'Calories', data: {!! json_encode($chartData['calories']) !!}, backgroundColor: 'rgba(249,115,22,0.7)', borderRadius: 6 },
                { label: 'Protein (g)', data: {!! json_encode($chartData['protein']) !!}, backgroundColor: 'rgba(239,68,68,0.7)', borderRadius: 6 },
                { label: 'Carbs (g)', data: {!! json_encode($chartData['carbs']) !!}, backgroundColor: 'rgba(234,179,8,0.7)', borderRadius: 6 },
            ]
        },
        options: { responsive: true, plugins: { legend: { labels: { color: textColor, usePointStyle: true, pointStyle: 'circle', padding: 12, font: { size: 11 } } } }, scales: { x: { grid: { display: false }, ticks: { color: textColor } }, y: { grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { color: textColor } } } }
    });
});
</script>
@endpush
</x-app-layout>
