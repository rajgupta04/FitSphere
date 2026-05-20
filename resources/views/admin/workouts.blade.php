<x-app-layout>
@section('title', 'Admin Workouts')
<div class="space-y-6">
    <h3 class="text-lg font-bold"><i class="fas fa-dumbbell text-primary-500 mr-2"></i>All Workouts</h3>
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50"><tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-500 text-xs uppercase">Workout</th>
                    <th class="px-4 py-3 text-left font-semibold text-gray-500 text-xs uppercase">User</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-500 text-xs uppercase">Category</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-500 text-xs uppercase">Duration</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-500 text-xs uppercase">Calories</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-500 text-xs uppercase">Status</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-500 text-xs uppercase">Date</th>
                </tr></thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($workouts as $w)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                        <td class="px-4 py-3 font-medium">{{ $w->name }}</td>
                        <td class="px-4 py-3 text-gray-500">{{ $w->user->name }}</td>
                        <td class="px-4 py-3 text-center"><span class="px-2 py-1 rounded-full text-xs font-medium bg-primary-100 dark:bg-primary-900/30 text-primary-600 capitalize">{{ $w->category }}</span></td>
                        <td class="px-4 py-3 text-center">{{ $w->duration_minutes }}m</td>
                        <td class="px-4 py-3 text-center text-orange-500 font-medium">{{ $w->calories_burned }}</td>
                        <td class="px-4 py-3 text-center">@if($w->completed)<span class="text-green-500"><i class="fas fa-check-circle"></i></span>@else<span class="text-yellow-500"><i class="fas fa-clock"></i></span>@endif</td>
                        <td class="px-4 py-3 text-center text-xs text-gray-400">{{ $w->workout_date->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4">{{ $workouts->links() }}</div>
    </div>
</div>
</x-app-layout>
