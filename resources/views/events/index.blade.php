<x-app-layout>
@section('title', 'Sports Events')
@section('subtitle', 'Discover and join sports events')

<div class="space-y-6">
    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        @if(auth()->user()->isAdmin())
        <a href="{{ route('events.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-primary-500 to-accent-500 text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:shadow-lg transition"><i class="fas fa-plus"></i> Create Event</a>
        @else
        <div></div>
        @endif
        <form method="GET" action="{{ route('events.index') }}" class="flex gap-2">
            <select name="sport_type" class="text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 px-3 py-2" onchange="this.form.submit()">
                <option value="">All Sports</option>
                @foreach(['Basketball','Yoga','Running','Swimming','Cricket','Table Tennis','Football','Tennis'] as $sport)
                <option value="{{ $sport }}" {{ request('sport_type') == $sport ? 'selected' : '' }}>{{ $sport }}</option>
                @endforeach
            </select>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search events..." class="text-sm rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 px-4 py-2 w-44">
        </form>
    </div>

    @if($events->count())
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($events as $event)
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
            <div class="h-32 bg-gradient-to-r from-primary-500 via-purple-500 to-accent-500 relative flex items-center justify-center">
                <i class="fas fa-trophy text-6xl text-white/20"></i>
                <div class="absolute top-3 right-3 px-3 py-1 rounded-full text-xs font-bold bg-white/20 backdrop-blur text-white capitalize">{{ $event->status }}</div>
                <div class="absolute bottom-3 left-3 bg-white/20 backdrop-blur rounded-lg px-3 py-1.5 text-white">
                    <p class="text-lg font-bold leading-none">{{ $event->event_date->format('d') }}</p>
                    <p class="text-[10px]">{{ $event->event_date->format('M Y') }}</p>
                </div>
            </div>
            <div class="p-5">
                <h3 class="font-bold text-lg mb-1 group-hover:text-primary-500 transition">{{ $event->title }}</h3>
                <div class="flex items-center gap-3 text-xs text-gray-400 mb-3">
                    <span><i class="fas fa-tag mr-1"></i>{{ $event->sport_type }}</span>
                    <span><i class="fas fa-map-marker-alt mr-1"></i>{{ $event->location ?? 'TBD' }}</span>
                </div>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center gap-1 text-xs text-gray-400">
                        <i class="fas fa-users"></i>
                        <span>{{ $event->registrations_count }}/{{ $event->max_participants }}</span>
                    </div>
                    <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-1.5">
                        <div class="bg-primary-500 h-1.5 rounded-full" style="width: {{ min(($event->registrations_count / $event->max_participants) * 100, 100) }}%"></div>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('events.show', $event) }}" class="flex-1 text-center py-2 rounded-xl bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 text-sm font-semibold hover:bg-primary-200 transition">View Details</a>
                    @if(in_array($event->id, $myRegistrations))
                    <span class="px-3 py-2 rounded-xl bg-green-100 dark:bg-green-900/30 text-green-600 text-xs font-bold"><i class="fas fa-check"></i> Joined</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="mt-6">{{ $events->links() }}</div>
    @else
    <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
        <i class="fas fa-trophy text-6xl text-gray-200 dark:text-gray-600 mb-4"></i>
        <h3 class="text-xl font-bold text-gray-400 mb-2">No Events Found</h3>
        <p class="text-gray-400">Check back later for upcoming sports events!</p>
    </div>
    @endif
</div>
</x-app-layout>
