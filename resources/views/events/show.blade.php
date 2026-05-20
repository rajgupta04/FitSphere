<x-app-layout>
@section('title', $event->title)
@section('subtitle', $event->sport_type . ' Event')

<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="h-48 bg-gradient-to-r from-primary-600 via-purple-600 to-accent-600 relative flex items-center justify-center">
            <i class="fas fa-trophy text-8xl text-white/10"></i>
            <div class="absolute inset-0 flex items-center justify-center"><h1 class="text-3xl font-bold text-white text-center px-4">{{ $event->title }}</h1></div>
        </div>
        <div class="p-6 lg:p-8">
            <div class="grid md:grid-cols-2 gap-6 mb-6">
                <div class="space-y-3">
                    <div class="flex items-center gap-3"><i class="fas fa-tag text-primary-500 w-5"></i><span class="text-sm"><strong>Sport:</strong> {{ $event->sport_type }}</span></div>
                    <div class="flex items-center gap-3"><i class="fas fa-calendar text-blue-500 w-5"></i><span class="text-sm"><strong>Date:</strong> {{ $event->event_date->format('F d, Y') }}</span></div>
                    <div class="flex items-center gap-3"><i class="fas fa-clock text-green-500 w-5"></i><span class="text-sm"><strong>Time:</strong> {{ $event->start_time ? \Carbon\Carbon::parse($event->start_time)->format('h:i A') : 'TBD' }} - {{ $event->end_time ? \Carbon\Carbon::parse($event->end_time)->format('h:i A') : 'TBD' }}</span></div>
                    <div class="flex items-center gap-3"><i class="fas fa-map-marker-alt text-red-500 w-5"></i><span class="text-sm"><strong>Location:</strong> {{ $event->location ?? 'TBD' }}</span></div>
                    <div class="flex items-center gap-3"><i class="fas fa-user text-gray-500 w-5"></i><span class="text-sm"><strong>Organizer:</strong> {{ $event->creator->name }}</span></div>
                </div>
                <div>
                    <div class="p-4 rounded-xl bg-gray-50 dark:bg-gray-700/50 text-center">
                        <p class="text-3xl font-bold text-primary-500">{{ $event->registrations->count() }}<span class="text-lg text-gray-400">/{{ $event->max_participants }}</span></p>
                        <p class="text-sm text-gray-400 mt-1">Participants</p>
                        <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2 mt-3">
                            <div class="bg-primary-500 h-2 rounded-full transition-all" style="width: {{ min(($event->registrations->count() / $event->max_participants) * 100, 100) }}%"></div>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">{{ $event->available_slots }} slots remaining</p>
                    </div>
                    <div class="mt-4">
                        @if($isRegistered)
                        <form method="POST" action="{{ route('events.cancel-registration', $event) }}" onsubmit="return confirm('Cancel registration?')">
                            @csrf @method('DELETE')
                            <button class="w-full py-3 rounded-xl bg-red-100 dark:bg-red-900/30 text-red-600 font-semibold hover:bg-red-200 transition"><i class="fas fa-times mr-2"></i>Cancel Registration</button>
                        </form>
                        @elseif(!$event->is_full && $event->status === 'upcoming')
                        <form method="POST" action="{{ route('events.register', $event) }}">
                            @csrf
                            <input type="text" name="team_name" placeholder="Team name (optional)" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 mb-2 text-sm">
                            <button class="w-full py-3 rounded-xl bg-gradient-to-r from-primary-500 to-accent-500 text-white font-semibold hover:shadow-lg transition"><i class="fas fa-check mr-2"></i>Register Now</button>
                        </form>
                        @else
                        <button disabled class="w-full py-3 rounded-xl bg-gray-200 dark:bg-gray-700 text-gray-400 font-semibold cursor-not-allowed">{{ $event->is_full ? 'Event Full' : 'Registration Closed' }}</button>
                        @endif
                    </div>
                </div>
            </div>

            @if($event->description)
            <div class="mb-6"><h4 class="font-semibold mb-2">About this Event</h4><p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed">{{ $event->description }}</p></div>
            @endif

            @if($event->registrations->count())
            <h4 class="font-semibold mb-3"><i class="fas fa-users text-primary-500 mr-2"></i>Registered Participants</h4>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                @foreach($event->registrations as $reg)
                <div class="flex items-center gap-2 p-2 rounded-lg bg-gray-50 dark:bg-gray-700/50">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-primary-500 to-accent-500 flex items-center justify-center text-white text-xs font-bold">{{ strtoupper(substr($reg->user->name, 0, 1)) }}</div>
                    <div class="min-w-0"><p class="text-sm font-medium truncate">{{ $reg->user->name }}</p>@if($reg->team_name)<p class="text-[10px] text-gray-400">{{ $reg->team_name }}</p>@endif</div>
                </div>
                @endforeach
            </div>
            @endif

            <div class="flex items-center gap-3 mt-6 pt-6 border-t border-gray-100 dark:border-gray-700">
                <a href="{{ route('events.index') }}" class="px-5 py-2.5 rounded-xl border border-gray-200 dark:border-gray-600 text-sm font-medium hover:bg-gray-50 dark:hover:bg-gray-700 transition">← Back to Events</a>
                @if(auth()->user()->isAdmin())
                <a href="{{ route('events.edit', $event) }}" class="px-5 py-2.5 rounded-xl bg-primary-100 dark:bg-primary-900/30 text-primary-600 font-semibold text-sm"><i class="fas fa-pen mr-1"></i>Edit</a>
                @endif
            </div>
        </div>
    </div>
</div>
</x-app-layout>
