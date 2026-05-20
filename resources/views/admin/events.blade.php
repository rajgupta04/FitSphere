<x-app-layout>
@section('title', 'Admin Events')
<div class="space-y-6">
    <h3 class="text-lg font-bold"><i class="fas fa-trophy text-primary-500 mr-2"></i>All Events</h3>
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-gray-50 dark:bg-gray-700/50"><tr>
                    <th class="px-4 py-3 text-left font-semibold text-gray-500 text-xs uppercase">Event</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-500 text-xs uppercase">Sport</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-500 text-xs uppercase">Date</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-500 text-xs uppercase">Participants</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-500 text-xs uppercase">Status</th>
                    <th class="px-4 py-3 text-center font-semibold text-gray-500 text-xs uppercase">Actions</th>
                </tr></thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                    @foreach($events as $e)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/30 transition">
                        <td class="px-4 py-3 font-medium">{{ $e->title }}</td>
                        <td class="px-4 py-3 text-center text-xs">{{ $e->sport_type }}</td>
                        <td class="px-4 py-3 text-center text-xs text-gray-400">{{ $e->event_date->format('M d, Y') }}</td>
                        <td class="px-4 py-3 text-center"><span class="font-medium">{{ $e->registrations_count }}</span>/{{ $e->max_participants }}</td>
                        <td class="px-4 py-3 text-center"><span class="px-2 py-1 rounded-full text-xs font-medium capitalize {{ $e->status === 'upcoming' ? 'bg-blue-100 text-blue-600' : ($e->status === 'completed' ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-600') }}">{{ $e->status }}</span></td>
                        <td class="px-4 py-3 text-center"><a href="{{ route('events.edit', $e) }}" class="text-primary-500 hover:text-primary-600 text-xs font-medium">Edit</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-4">{{ $events->links() }}</div>
    </div>
</div>
</x-app-layout>
