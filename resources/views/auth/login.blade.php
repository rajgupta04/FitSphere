<x-guest-layout>
    @section('title', 'Sign In')

    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold">Welcome Back! 👋</h2>
        <p class="text-sm text-gray-400 mt-1">Sign in to continue your fitness journey</p>
    </div>

    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-4 text-sm text-green-600 bg-green-50 dark:bg-green-900/20 p-3 rounded-xl">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-semibold mb-2">Email Address</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-envelope text-sm"></i></span>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500 focus:border-primary-500 text-sm"
                    placeholder="you@example.com">
            </div>
            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold mb-2">Password</label>
            <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-lock text-sm"></i></span>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full pl-10 pr-4 py-3 rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500 focus:border-primary-500 text-sm"
                    placeholder="••••••••">
            </div>
            @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded border-gray-300 text-primary-500 focus:ring-primary-500">
                <span class="text-sm text-gray-500">Remember me</span>
            </label>
            @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-sm text-primary-500 hover:text-primary-600 font-medium">Forgot password?</a>
            @endif
        </div>

        <button type="submit" class="w-full bg-gradient-to-r from-primary-500 to-accent-500 text-white py-3 rounded-xl font-semibold text-sm hover:shadow-lg hover:shadow-primary-500/25 transition-all duration-300 hover:-translate-y-0.5">
            <i class="fas fa-sign-in-alt mr-2"></i> Sign In
        </button>
    </form>

    <div class="mt-6 text-center">
        <p class="text-sm text-gray-400">Don't have an account? <a href="{{ route('register') }}" class="text-primary-500 hover:text-primary-600 font-semibold">Create one</a></p>
    </div>

    <!-- Demo credentials -->
    <div class="mt-4 p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50 text-xs text-gray-400">
        <p class="font-semibold text-gray-500 mb-1">Demo Accounts:</p>
        <p>Admin: admin@fitsphere.com / password</p>
        <p>User: user@fitsphere.com / password</p>
    </div>
</x-guest-layout>
