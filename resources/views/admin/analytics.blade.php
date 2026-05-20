<x-app-layout>
@section('title', 'Analytics')
@section('subtitle', 'Platform analytics and insights')

<div class="space-y-6">
    <!-- Charts -->
    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
            <h4 class="font-bold mb-4"><i class="fas fa-users text-blue-500 mr-2"></i>User Growth</h4>
            <canvas id="growthChart" height="250"></canvas>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
            <h4 class="font-bold mb-4"><i class="fas fa-dumbbell text-purple-500 mr-2"></i>Workout Activity</h4>
            <canvas id="activityChart" height="250"></canvas>
        </div>
    </div>

    <!-- Top Users -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
        <h4 class="font-bold mb-4"><i class="fas fa-medal text-yellow-500 mr-2"></i>Top Active Users</h4>
        <div class="grid md:grid-cols-2 lg:grid-cols-5 gap-4">
            @foreach($topUsers->take(5) as $i => $u)
            <div class="text-center p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                <div class="w-14 h-14 rounded-full mx-auto gradient-primary flex items-center justify-center text-white text-lg font-bold mb-2">
                    @if($i === 0) 🥇 @elseif($i === 1) 🥈 @elseif($i === 2) 🥉 @else {{ strtoupper(substr($u->name, 0, 1)) }} @endif
                </div>
                <p class="font-semibold text-sm">{{ $u->name }}</p>
                <p class="text-xs text-gray-400">{{ $u->workouts_count }} workouts</p>
            </div>
            @endforeach
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tc = document.documentElement.classList.contains('dark') ? '#9ca3af' : '#6b7280';
    new Chart(document.getElementById('growthChart'), {
        type: 'line', data: { labels: {!! json_encode($userGrowth['labels']) !!}, datasets: [{ label: 'New Users', data: {!! json_encode($userGrowth['data']) !!}, borderColor: '#3b82f6', backgroundColor: 'rgba(59,130,246,0.1)', fill: true, tension: 0.4 }] },
        options: { responsive: true, plugins: { legend: { labels: { color: tc } } }, scales: { x: { ticks: { color: tc, font: { size: 10 } }, grid: { display: false } }, y: { ticks: { color: tc }, grid: { color: 'rgba(0,0,0,0.05)' } } } }
    });
    new Chart(document.getElementById('activityChart'), {
        type: 'bar', data: { labels: {!! json_encode($workoutStats['labels']) !!}, datasets: [{ label: 'Workouts', data: {!! json_encode($workoutStats['data']) !!}, backgroundColor: 'rgba(139,92,246,0.7)', borderRadius: 8 }] },
        options: { responsive: true, plugins: { legend: { labels: { color: tc } } }, scales: { x: { ticks: { color: tc }, grid: { display: false } }, y: { ticks: { color: tc }, grid: { color: 'rgba(0,0,0,0.05)' } } } }
    });
});
</script>
@endpush
</x-app-layout>
