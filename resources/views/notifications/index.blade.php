<x-app-layout>
@section('title', 'Notifications')
@section('subtitle', 'Stay updated with your fitness activities')

<div class="max-w-3xl mx-auto space-y-4">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-bold">All Notifications</h3>
        @if($notifications->where('is_read', false)->count() > 0)
        <form method="POST" action="{{ route('notifications.mark-all-read') }}">@csrf
            <button class="text-sm text-primary-500 hover:text-primary-600 font-medium"><i class="fas fa-check-double mr-1"></i>Mark All Read</button>
        </form>
        @endif
    </div>

    @if($notifications->count())
    @foreach($notifications as $notification)
    <div class="flex items-start gap-4 p-4 rounded-2xl border transition-all duration-300 {{ $notification->is_read ? 'bg-white dark:bg-gray-800 border-gray-100 dark:border-gray-700' : 'bg-primary-50 dark:bg-primary-900/10 border-primary-200 dark:border-primary-800' }}">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0
            {{ $notification->type === 'achievement' ? 'bg-yellow-100 dark:bg-yellow-900/30' : '' }}
            {{ $notification->type === 'reminder' ? 'bg-blue-100 dark:bg-blue-900/30' : '' }}
            {{ $notification->type === 'info' ? 'bg-primary-100 dark:bg-primary-900/30' : '' }}
            {{ $notification->type === 'success' ? 'bg-green-100 dark:bg-green-900/30' : '' }}
            {{ $notification->type === 'warning' ? 'bg-orange-100 dark:bg-orange-900/30' : '' }}">
            <i class="fas {{ $notification->type === 'achievement' ? 'fa-trophy text-yellow-500' : '' }}{{ $notification->type === 'reminder' ? 'fa-bell text-blue-500' : '' }}{{ $notification->type === 'info' ? 'fa-info-circle text-primary-500' : '' }}{{ $notification->type === 'success' ? 'fa-check-circle text-green-500' : '' }}{{ $notification->type === 'warning' ? 'fa-exclamation text-orange-500' : '' }}"></i>
        </div>
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2">
                <h4 class="font-semibold text-sm">{{ $notification->title }}</h4>
                @unless($notification->is_read)<span class="w-2 h-2 rounded-full bg-primary-500"></span>@endunless
            </div>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $notification->message }}</p>
            <p class="text-xs text-gray-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
        </div>
        <div class="flex items-center gap-1 flex-shrink-0">
            @unless($notification->is_read)
            <form method="POST" action="{{ route('notifications.mark-read', $notification) }}">@csrf
                <button class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition text-gray-400 hover:text-primary-500" title="Mark as read"><i class="fas fa-check text-xs"></i></button>
            </form>
            @endunless
            <form method="POST" action="{{ route('notifications.destroy', $notification) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
                <button class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition text-gray-400 hover:text-red-500" title="Delete"><i class="fas fa-trash text-xs"></i></button>
            </form>
        </div>
    </div>
    @endforeach
    <div>{{ $notifications->links() }}</div>
    @else
    <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
        <i class="fas fa-bell-slash text-5xl text-gray-200 dark:text-gray-600 mb-3"></i>
        <h3 class="font-bold text-gray-400">No Notifications</h3>
        <p class="text-sm text-gray-400 mt-1">You're all caught up!</p>
    </div>
    @endif
</div>
</x-app-layout>
