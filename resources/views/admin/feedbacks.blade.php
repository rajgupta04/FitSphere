<x-app-layout>
@section('title', 'Manage Feedback')
@section('subtitle', 'Review and respond to user feedback')

<div class="space-y-4">
    <h3 class="text-lg font-bold"><i class="fas fa-comment-dots text-primary-500 mr-2"></i>All Feedback</h3>

    @foreach($feedbacks as $fb)
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-5">
        <div class="flex items-start justify-between mb-3">
            <div>
                <h4 class="font-bold">{{ $fb->subject }}</h4>
                <div class="flex items-center gap-2 mt-1 text-xs text-gray-400">
                    <span>By {{ $fb->user->name }}</span>
                    <span>·</span>
                    <span>{{ $fb->created_at->format('M d, Y') }}</span>
                    <span class="px-2 py-0.5 rounded-full bg-primary-100 dark:bg-primary-900/30 text-primary-600 capitalize font-medium">{{ $fb->type }}</span>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <div class="flex gap-0.5">@for($i=1;$i<=5;$i++)<i class="fas fa-star text-xs {{ $i <= $fb->rating ? 'text-yellow-400' : 'text-gray-300' }}"></i>@endfor</div>
                <form method="POST" action="{{ route('admin.feedbacks.update-status', $fb) }}" class="inline">@csrf @method('PATCH')
                    <select name="status" onchange="this.form.submit()" class="text-xs rounded-lg border-gray-200 dark:border-gray-600 dark:bg-gray-700 py-1 px-2 {{ $fb->status === 'resolved' ? 'text-green-600 bg-green-50' : ($fb->status === 'reviewed' ? 'text-blue-600 bg-blue-50' : 'text-yellow-600 bg-yellow-50') }}">
                        <option value="pending" {{ $fb->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="reviewed" {{ $fb->status === 'reviewed' ? 'selected' : '' }}>Reviewed</option>
                        <option value="resolved" {{ $fb->status === 'resolved' ? 'selected' : '' }}>Resolved</option>
                    </select>
                </form>
            </div>
        </div>
        <p class="text-sm text-gray-600 dark:text-gray-300">{{ $fb->message }}</p>
    </div>
    @endforeach
    <div>{{ $feedbacks->links() }}</div>
</div>
</x-app-layout>
