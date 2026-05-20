<x-app-layout>
@section('title', 'Feedback')
@section('subtitle', 'Share your thoughts with us')

<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h3 class="text-lg font-bold">My Feedback</h3>
        <a href="{{ route('feedback.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-primary-500 to-accent-500 text-white px-5 py-2.5 rounded-xl font-semibold text-sm hover:shadow-lg transition"><i class="fas fa-plus"></i> New Feedback</a>
    </div>

    @if($feedbacks->count())
    @foreach($feedbacks as $fb)
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5">
        <div class="flex items-start justify-between mb-3">
            <div>
                <h4 class="font-bold">{{ $fb->subject }}</h4>
                <div class="flex items-center gap-2 mt-1">
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-primary-100 dark:bg-primary-900/30 text-primary-600 capitalize">{{ $fb->type }}</span>
                    <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $fb->status === 'resolved' ? 'bg-green-100 text-green-600' : ($fb->status === 'reviewed' ? 'bg-blue-100 text-blue-600' : 'bg-yellow-100 text-yellow-600') }} capitalize">{{ $fb->status }}</span>
                </div>
            </div>
            <div class="flex gap-0.5">@for($i = 1; $i <= 5; $i++)<i class="fas fa-star text-sm {{ $i <= $fb->rating ? 'text-yellow-400' : 'text-gray-200 dark:text-gray-600' }}"></i>@endfor</div>
        </div>
        <p class="text-sm text-gray-600 dark:text-gray-300">{{ $fb->message }}</p>
        <p class="text-xs text-gray-400 mt-3">{{ $fb->created_at->format('M d, Y h:i A') }}</p>
    </div>
    @endforeach
    <div>{{ $feedbacks->links() }}</div>
    @else
    <div class="text-center py-16 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700">
        <i class="fas fa-comment-dots text-5xl text-gray-200 dark:text-gray-600 mb-3"></i>
        <h3 class="font-bold text-gray-400">No Feedback Yet</h3>
        <p class="text-sm text-gray-400 mt-1">Share your thoughts to help us improve!</p>
    </div>
    @endif
</div>
</x-app-layout>
