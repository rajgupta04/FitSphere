<x-guest-layout>
    @section('title', 'Create Account')

    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold">Join FitSphere 🚀</h2>
        <p class="text-sm text-gray-400 mt-1">Create your account and start tracking</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-semibold mb-2">Full Name</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-user text-sm"></i></span>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                    class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500 text-sm"
                    placeholder="John Doe">
            </div>
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold mb-2">Email Address</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-envelope text-sm"></i></span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500 text-sm"
                    placeholder="you@example.com">
            </div>
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold mb-2">Password</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-lock text-sm"></i></span>
                <input id="password" type="password" name="password" required
                    class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500 text-sm"
                    placeholder="••••••••">
            </div>
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold mb-2">Confirm Password</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-shield-alt text-sm"></i></span>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500 text-sm"
                    placeholder="••••••••">
            </div>
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-primary-500 to-accent-500 text-white py-3 rounded-xl font-semibold text-sm hover:shadow-lg hover:shadow-primary-500/25 transition-all duration-300 hover:-translate-y-0.5">
            <i class="fas fa-user-plus mr-2"></i> Create Account
        </button>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-400">Already have an account? <a href="{{ route('login') }}" class="text-primary-500 hover:text-primary-600 font-semibold">Sign in</a></p>
    </div>
</x-guest-layout>
