<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', sidebarOpen: false }" :class="{ 'dark': darkMode }">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="FitSphere - Your smart fitness and sports management platform">

        <title>{{ config('app.name', 'FitSphere') }} - @yield('title', 'Dashboard')</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

        <!-- Alpine.js -->
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])


        @stack('styles')
    </head>
    <body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 transition-colors duration-300">

        <!-- Toast Notifications -->
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-[-20px]"
             x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed top-4 right-4 z-[100] bg-gradient-to-r from-emerald-500 to-teal-500 text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3">
            <i class="fas fa-check-circle text-lg"></i>
            <span class="font-medium">{{ session('success') }}</span>
            <button @click="show = false" class="ml-2 hover:text-white/70"><i class="fas fa-times"></i></button>
        </div>
        @endif
        @if(session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
             x-transition class="fixed top-4 right-4 z-[100] bg-gradient-to-r from-red-500 to-rose-500 text-white px-6 py-3 rounded-xl shadow-2xl flex items-center gap-3">
            <i class="fas fa-exclamation-circle text-lg"></i>
            <span class="font-medium">{{ session('error') }}</span>
            <button @click="show = false" class="ml-2 hover:text-white/70"><i class="fas fa-times"></i></button>
        </div>
        @endif

        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
                   class="fixed inset-y-0 left-0 z-50 w-72 bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 transform transition-transform duration-300 ease-in-out lg:translate-x-0 lg:static lg:flex-shrink-0 overflow-y-auto">

                <!-- Logo -->
                <div class="flex items-center gap-3 px-6 py-5 border-b border-gray-200 dark:border-gray-700">
                    <div class="w-10 h-10 rounded-xl gradient-primary flex items-center justify-center shadow-lg shadow-primary-500/30">
                        <i class="fas fa-dumbbell text-white text-lg"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold bg-gradient-to-r from-primary-600 to-accent-500 bg-clip-text text-transparent">FitSphere</h1>
                        <p class="text-[10px] text-gray-400 uppercase tracking-widest">Fitness Management</p>
                    </div>
                </div>

                <!-- User Info -->
                <div class="px-4 py-4 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 dark:bg-gray-700/50">
                        <div class="w-10 h-10 rounded-full gradient-primary flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold truncate">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-gray-400 capitalize">{{ Auth::user()->role }}</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation -->
                <nav class="p-4 flex flex-col space-y-1">
                    <p class="px-4 py-2 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Main Menu</p>

                    <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : 'text-gray-600 dark:text-gray-300' }}">
                        <i class="fas fa-th-large w-5 text-center"></i> Dashboard
                    </a>
                    <a href="{{ route('workouts.index') }}" class="sidebar-link {{ request()->routeIs('workouts.*') ? 'active' : 'text-gray-600 dark:text-gray-300' }}">
                        <i class="fas fa-running w-5 text-center"></i> Workouts
                    </a>
                    <a href="{{ route('fitness.index') }}" class="sidebar-link {{ request()->routeIs('fitness.*') ? 'active' : 'text-gray-600 dark:text-gray-300' }}">
                        <i class="fas fa-heartbeat w-5 text-center"></i> Fitness Tracking
                    </a>
                    <a href="{{ route('diet.index') }}" class="sidebar-link {{ request()->routeIs('diet.*') ? 'active' : 'text-gray-600 dark:text-gray-300' }}">
                        <i class="fas fa-utensils w-5 text-center"></i> Diet & Nutrition
                    </a>
                    <a href="{{ route('events.index') }}" class="sidebar-link {{ request()->routeIs('events.*') ? 'active' : 'text-gray-600 dark:text-gray-300' }}">
                        <i class="fas fa-trophy w-5 text-center"></i> Sports Events
                    </a>

                    <p class="px-4 py-2 mt-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Account</p>

                    <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'active' : 'text-gray-600 dark:text-gray-300' }}">
                        <i class="fas fa-user-circle w-5 text-center"></i> My Profile
                    </a>
                    <a href="{{ route('notifications.index') }}" class="sidebar-link {{ request()->routeIs('notifications.*') ? 'active' : 'text-gray-600 dark:text-gray-300' }}">
                        <i class="fas fa-bell w-5 text-center"></i> Notifications
                        @php $unreadCount = \App\Models\Notification::where('user_id', auth()->id())->where('is_read', false)->count(); @endphp
                        @if($unreadCount > 0)
                        <span class="ml-auto bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ $unreadCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('feedback.index') }}" class="sidebar-link {{ request()->routeIs('feedback.*') ? 'active' : 'text-gray-600 dark:text-gray-300' }}">
                        <i class="fas fa-comment-dots w-5 text-center"></i> Feedback
                    </a>

                    @if(Auth::user()->isAdmin())
                    <p class="px-4 py-2 mt-4 text-[11px] font-bold text-gray-400 uppercase tracking-wider">Admin</p>
                    <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : 'text-gray-600 dark:text-gray-300' }}">
                        <i class="fas fa-shield-alt w-5 text-center"></i> Admin Panel
                    </a>
                    <a href="{{ route('admin.users') }}" class="sidebar-link {{ request()->routeIs('admin.users') ? 'active' : 'text-gray-600 dark:text-gray-300' }}">
                        <i class="fas fa-users-cog w-5 text-center"></i> Manage Users
                    </a>
                    <a href="{{ route('admin.analytics') }}" class="sidebar-link {{ request()->routeIs('admin.analytics') ? 'active' : 'text-gray-600 dark:text-gray-300' }}">
                        <i class="fas fa-chart-bar w-5 text-center"></i> Analytics
                    </a>
                    @endif

                    <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="sidebar-link w-full text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-600">
                                <i class="fas fa-sign-out-alt w-5 text-center"></i> Sign Out
                            </button>
                        </form>
                    </div>
                </nav>
            </aside>

            <!-- Sidebar Overlay (mobile) -->
            <div x-show="sidebarOpen" @click="sidebarOpen = false"
                 class="fixed inset-0 z-40 bg-black/50 backdrop-blur-sm lg:hidden"
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-300"
                 x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"></div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col min-w-0">
                <!-- Top Navbar -->
                <header class="sticky top-0 z-30 bg-white/80 dark:bg-gray-800/80 backdrop-blur-xl border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-center justify-between px-4 lg:px-8 py-3">
                        <div class="flex items-center gap-4">
                            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                                <i class="fas fa-bars text-gray-600 dark:text-gray-300"></i>
                            </button>
                            <div>
                                <h2 class="text-lg font-bold text-gray-800 dark:text-white">@yield('title', 'Dashboard')</h2>
                                <p class="text-xs text-gray-400">@yield('subtitle', 'Welcome back!')</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <!-- Dark Mode Toggle -->
                            <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)"
                                    class="p-2.5 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-300 hover:scale-110">
                                <i :class="darkMode ? 'fas fa-sun text-yellow-400' : 'fas fa-moon text-gray-500'" class="text-sm"></i>
                            </button>
                            <!-- Notifications -->
                            <a href="{{ route('notifications.index') }}" class="relative p-2.5 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-300 hover:scale-110">
                                <i class="fas fa-bell text-sm text-gray-500 dark:text-gray-300"></i>
                                @if(isset($unreadCount) && $unreadCount > 0)
                                <span class="absolute -top-1 -right-1 w-4 h-4 bg-red-500 rounded-full text-[10px] text-white flex items-center justify-center font-bold">{{ $unreadCount }}</span>
                                @endif
                            </a>
                            <!-- Profile -->
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-2 p-1.5 pr-4 rounded-xl bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-all duration-300">
                                <div class="w-8 h-8 rounded-lg gradient-primary flex items-center justify-center text-white text-xs font-bold">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span class="text-sm font-medium hidden sm:block">{{ Auth::user()->name }}</span>
                            </a>
                        </div>
                    </div>
                </header>

                <!-- Page Content -->
                <main class="flex-1 p-4 lg:p-8">
                    {{ $slot }}
                </main>

                <!-- Footer -->
                <footer class="border-t border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 px-8 py-4">
                    <div class="flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-gray-400">
                        <p>&copy; {{ date('Y') }} FitSphere. All rights reserved.</p>
                        <p>Built with <i class="fas fa-heart text-red-400"></i> for fitness enthusiasts</p>
                    </div>
                </footer>
            </div>
        </div>

        @stack('scripts')
    </body>
</html>
