<x-app-layout>
@section('title', 'Admin Dashboard')
@section('subtitle', 'System overview and management')

<div class="space-y-6">
    <!-- Stats Grid -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        @php
        $statCards = [
            ['label' => 'Total Users', 'value' => $stats['total_users'], 'icon' => 'fa-users', 'color' => 'blue', 'gradient' => 'from-blue-500 to-cyan-500'],
            ['label' => 'Total Workouts', 'value' => $stats['total_workouts'], 'icon' => 'fa-dumbbell', 'color' => 'purple', 'gradient' => 'from-purple-500 to-violet-500'],
            ['label' => 'Upcoming Events', 'value' => $stats['upcoming_events'], 'icon' => 'fa-calendar', 'color' => 'green', 'gradient' => 'from-green-500 to-emerald-500'],
            ['label' => 'Pending Feedback', 'value' => $stats['pending_feedback'], 'icon' => 'fa-comment', 'color' => 'orange', 'gradient' => 'from-orange-500 to-amber-500'],
        ];
        @endphp
        @foreach($statCards as $card)
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-r {{ $card['gradient'] }} flex items-center justify-center shadow-lg"><i class="fas {{ $card['icon'] }} text-white"></i></div>
                <div><p class="text-2xl font-bold">{{ number_format($card['value']) }}</p><p class="text-xs text-gray-400">{{ $card['label'] }}</p></div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Charts -->
    <div class="grid lg:grid-cols-2 gap-6">
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
            <h4 class="font-bold mb-4"><i class="fas fa-chart-line text-blue-500 mr-2"></i>User Growth (12 Months)</h4>
            <canvas id="userGrowthChart" height="200"></canvas>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
            <h4 class="font-bold mb-4"><i class="fas fa-chart-bar text-purple-500 mr-2"></i>Daily Workouts (7 Days)</h4>
            <canvas id="workoutChart" height="200"></canvas>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <!-- Recent Users -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-bold"><i class="fas fa-user-plus text-green-500 mr-2"></i>Recent Users</h4>
                <a href="{{ route('admin.users') }}" class="text-sm text-primary-500 font-medium">View All →</a>
            </div>
            <div class="space-y-3">
                @foreach($recentUsers as $u)
                <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                    <div class="w-9 h-9 rounded-full gradient-primary flex items-center justify-center text-white text-xs font-bold">{{ strtoupper(substr($u->name, 0, 1)) }}</div>
                    <div class="flex-1 min-w-0"><p class="text-sm font-medium truncate">{{ $u->name }}</p><p class="text-xs text-gray-400">{{ $u->email }}</p></div>
                    <span class="text-xs text-gray-400">{{ $u->created_at->diffForHumans() }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Feedback -->
        <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-gray-700">
            <div class="flex items-center justify-between mb-4">
                <h4 class="font-bold"><i class="fas fa-comment-dots text-orange-500 mr-2"></i>Recent Feedback</h4>
                <a href="{{ route('admin.feedbacks') }}" class="text-sm text-primary-500 font-medium">View All →</a>
            </div>
            <div class="space-y-3">
                @foreach($recentFeedback as $fb)
                <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                    <div class="flex items-center justify-between mb-1">
                        <p class="text-sm font-medium">{{ $fb->subject }}</p>
                        <div class="flex gap-0.5">@for($i=1;$i<=5;$i++)<i class="fas fa-star text-[10px] {{ $i <= $fb->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>@endfor</div>
                    </div>
                    <p class="text-xs text-gray-400">{{ $fb->user->name }} · {{ $fb->created_at->diffForHumans() }}</p>
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
    new Chart(document.getElementById('userGrowthChart'), {
        type: 'line', data: { labels: {!! json_encode($userGrowth['labels']) !!}, datasets: [{ label: 'New Users', data: {!! json_encode($userGrowth['data']) !!}, borderColor: '#3b82f6', backgroundColor: 'rgba(59,130,246,0.1)', fill: true, tension: 0.4, pointRadius: 4 }] },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { x: { grid: { display: false }, ticks: { color: textColor, font: { size: 10 } } }, y: { grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { color: textColor } } } }
    });
    new Chart(document.getElementById('workoutChart'), {
        type: 'bar', data: { labels: {!! json_encode($userGrowth['labels']) !!}.slice(-7), datasets: [{ label: 'Workouts', data: {!! json_encode($userGrowth['data']) !!}.slice(-7), backgroundColor: 'rgba(139,92,246,0.7)', borderRadius: 8 }] },
        options: { responsive: true, plugins: { legend: { display: false } }, scales: { x: { grid: { display: false }, ticks: { color: textColor } }, y: { grid: { color: 'rgba(0,0,0,0.05)' }, ticks: { color: textColor } } } }
    });
});
</script>
@endpush
</x-app-layout>
