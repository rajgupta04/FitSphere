<x-app-layout>
@section('title', 'Create Sports Event')
<div class="max-w-3xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 lg:p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-yellow-500 to-orange-500 flex items-center justify-center"><i class="fas fa-trophy text-white text-lg"></i></div>
            <div><h3 class="text-xl font-bold">Create Sports Event</h3><p class="text-sm text-gray-400">Organize a new sports event</p></div>
        </div>
        <form method="POST" action="{{ route('events.store') }}" class="space-y-5">
            @csrf
            <div class="grid md:grid-cols-2 gap-5">
                <div><label class="block text-sm font-semibold mb-2">Event Title *</label><input type="text" name="title" value="{{ old('title') }}" required class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500" placeholder="e.g., Basketball Tournament">@error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-semibold mb-2">Sport Type *</label><input type="text" name="sport_type" value="{{ old('sport_type') }}" required class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500" placeholder="e.g., Basketball"></div>
            </div>
            <div><label class="block text-sm font-semibold mb-2">Description</label><textarea name="description" rows="3" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500" placeholder="Event description...">{{ old('description') }}</textarea></div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div><label class="block text-sm font-semibold mb-2">Event Date *</label><input type="date" name="event_date" value="{{ old('event_date') }}" required class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500"></div>
                <div><label class="block text-sm font-semibold mb-2">Start Time</label><input type="time" name="start_time" value="{{ old('start_time') }}" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500"></div>
                <div><label class="block text-sm font-semibold mb-2">End Time</label><input type="time" name="end_time" value="{{ old('end_time') }}" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500"></div>
                <div><label class="block text-sm font-semibold mb-2">Max Participants *</label><input type="number" name="max_participants" value="{{ old('max_participants', 20) }}" required min="2" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500"></div>
            </div>
            <div><label class="block text-sm font-semibold mb-2">Location</label><input type="text" name="location" value="{{ old('location') }}" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500" placeholder="e.g., City Sports Arena"></div>
            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-primary-500 to-accent-500 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition-all"><i class="fas fa-save mr-2"></i>Create Event</button>
                <a href="{{ route('events.index') }}" class="px-6 py-3 rounded-xl border border-gray-200 dark:border-gray-600 hover:bg-gray-50 dark:hover:bg-gray-700 transition text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
