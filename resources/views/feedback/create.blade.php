<x-app-layout>
@section('title', 'Submit Feedback')
<div class="max-w-2xl mx-auto">
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 lg:p-8">
        <div class="flex items-center gap-3 mb-6">
            <div class="w-12 h-12 rounded-xl bg-gradient-to-r from-primary-500 to-accent-500 flex items-center justify-center"><i class="fas fa-comment-dots text-white text-lg"></i></div>
            <div><h3 class="text-xl font-bold">Submit Feedback</h3><p class="text-sm text-gray-400">We value your input!</p></div>
        </div>
        <form method="POST" action="{{ route('feedback.store') }}" class="space-y-5">
            @csrf
            <div class="grid md:grid-cols-2 gap-5">
                <div><label class="block text-sm font-semibold mb-2">Subject *</label><input type="text" name="subject" value="{{ old('subject') }}" required class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500">@error('subject')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-semibold mb-2">Type *</label><select name="type" required class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500"><option value="general">General</option><option value="suggestion">Suggestion</option><option value="bug">Bug Report</option><option value="feature">Feature Request</option></select></div>
            </div>
            <div><label class="block text-sm font-semibold mb-2">Message *</label><textarea name="message" rows="4" required class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500" placeholder="Tell us what you think...">{{ old('message') }}</textarea>@error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
            <div>
                <label class="block text-sm font-semibold mb-2">Rating *</label>
                <div class="flex gap-2" x-data="{ rating: {{ old('rating', 5) }} }">
                    @for($i = 1; $i <= 5; $i++)
                    <button type="button" @click="rating = {{ $i }}" :class="rating >= {{ $i }} ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'" class="text-3xl hover:scale-110 transition-transform"><i class="fas fa-star"></i></button>
                    @endfor
                    <input type="hidden" name="rating" :value="rating">
                </div>
            </div>
            <div class="flex items-center gap-3 pt-4">
                <button type="submit" class="flex-1 bg-gradient-to-r from-primary-500 to-accent-500 text-white py-3 rounded-xl font-semibold hover:shadow-lg transition-all"><i class="fas fa-paper-plane mr-2"></i>Submit Feedback</button>
                <a href="{{ route('feedback.index') }}" class="px-6 py-3 rounded-xl border border-gray-200 dark:border-gray-600 transition text-sm font-medium">Cancel</a>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
