<x-app-layout>
@section('title', 'Fitness Tracking')
@section('subtitle', 'Monitor your daily health metrics')

<div class="space-y-6">
    <!-- Weekly Averages -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition">
            <div class="flex items-center gap-3"><div class="w-10 h-10 rounded-xl bg-green-100 dark:bg-green-900/30 flex items-center justify-center"><i class="fas fa-shoe-prints text-green-500"></i></div>
            <div><p class="text-xl font-bold">{{ number_format($averages['steps']) }}</p><p class="text-xs text-gray-400">Avg Steps/Day</p></div></div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition">
            <div class="flex items-center gap-3"><div class="w-10 h-10 rounded-xl bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center"><i class="fas fa-tint text-blue-500"></i></div>
            <div><p class="text-xl font-bold">{{ number_format($averages['water']) }}<span class="text-sm font-normal text-gray-400">ml</span></p><p class="text-xs text-gray-400">Avg Water/Day</p></div></div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition">
            <div class="flex items-center gap-3"><div class="w-10 h-10 rounded-xl bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center"><i class="fas fa-moon text-indigo-500"></i></div>
            <div><p class="text-xl font-bold">{{ number_format($averages['sleep'], 1) }}<span class="text-sm font-normal text-gray-400">hrs</span></p><p class="text-xs text-gray-400">Avg Sleep/Day</p></div></div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-xl p-4 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition">
            <div class="flex items-center gap-3"><div class="w-10 h-10 rounded-xl bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center"><i class="fas fa-utensils text-orange-500"></i></div>
            <div><p class="text-xl font-bold">{{ number_format($averages['calories']) }}</p><p class="text-xs text-gray-400">Avg Calories/Day</p></div></div>
        </div>
    </div>

    <div class="flex items-center justify-between">
        <h3 class="font-bold text-lg">Activity Log</h3>
        <a href="{{ route('fitness.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-primary-500 to-accent-500 text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:shadow-lg transition"><i class="fas fa-plus"></i> Log Today</a>
    </div>

    <!-- Charts -->
    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
            <h4 class="font-bold mb-4"><i class="fas fa-shoe-prints text-green-500 mr-2"></i>Steps Trend</h4>
            <canvas id="stepsChart" height="200"></canvas>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
            <h4 class="font-bold mb-4"><i class="fas fa-moon text-indigo-500 mr-2"></i>Sleep Trend</h4>
            <canvas id="sleepChart" height="200"></canvas>
        </div>
    </div>

    <!-- Recent Logs -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50">
                    <tr>
                        <th class="px-4 py-3 text-left font-semibold text-gray-500 text-xs uppercase">Date</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-500 text-xs uppercase">Steps</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-500 text-xs uppercase">Water</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-500 text-xs uppercase">Sleep</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-500 text-xs uppercase">Cal In</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-500 text-xs uppercase">Cal Out</th>
                        <th class="px-4 py-3 text-center font-semibold text-gray-500 text-xs uppercase">Mood</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($logs as $log)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                        <td class="px-4 py-3 font-medium">{{ $log->log_date->format('M d, Y') }}</td>
                        <td class="px-4 py-3 text-center">{{ number_format($log->steps) }}</td>
                        <td class="px-4 py-3 text-center text-blue-500">{{ number_format($log->water_intake_ml) }}ml</td>
                        <td class="px-4 py-3 text-center text-indigo-500">{{ $log->sleep_hours }}h</td>
                        <td class="px-4 py-3 text-center">{{ number_format($log->calories_consumed) }}</td>
                        <td class="px-4 py-3 text-center text-orange-500">{{ number_format($log->calories_burned) }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($log->mood === 'great') 😄
                            @elseif($log->mood === 'good') 🙂
                            @elseif($log->mood === 'neutral') 😐
                            @elseif($log->mood === 'bad') 😟
                            @else 😢
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4">{{ $logs->links() }}</div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const textColor = document.documentElement.classList.contains('dark') ? '#9ca3af' : '#6b7280';
    const gridColor = document.documentElement.classList.contains('dark') ? 'rgba(255,255,255,0.06)' : 'rgba(0,0,0,0.06)';
    const labels = {!! json_encode(array_slice($chartData['labels'], -14)) !!};

    new Chart(document.getElementById('stepsChart'), {
        type: 'bar', data: { labels, datasets: [{ label: 'Steps', data: {!! json_encode(array_slice($chartData['steps'], -14)) !!}, backgroundColor: 'rgba(16, 185, 129, 0.7)', borderRadius: 6 }] },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { x: { grid: { display: false }, ticks: { color: textColor, font: { size: 10 } } }, y: { grid: { color: gridColor }, ticks: { color: textColor } } } }
    });

    new Chart(document.getElementById('sleepChart'), {
        type: 'line', data: { labels, datasets: [{ label: 'Hours', data: {!! json_encode(array_slice($chartData['sleep'], -14)) !!}, borderColor: '#6366f1', backgroundColor: 'rgba(99,102,241,0.1)', fill: true, tension: 0.4, pointRadius: 4, pointBackgroundColor: '#6366f1' }] },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { x: { grid: { display: false }, ticks: { color: textColor, font: { size: 10 } } }, y: { grid: { color: gridColor }, ticks: { color: textColor }, min: 0, max: 12 } } }
    });
});
</script>
@endpush
</x-app-layout>
