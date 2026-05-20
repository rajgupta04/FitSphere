<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="FitSphere - Your smart fitness and sports management platform. Track workouts, nutrition, and achieve your goals.">
    <title>FitSphere – Fitness & Sports Management System</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .gradient-text { background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 40%, #d946ef 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text; }
        .glass-card { background: rgba(255, 255, 255, 0.08); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.12); }
        .hero-gradient { background: linear-gradient(135deg, #0f0c29 0%, #1a1145 30%, #302b63 60%, #24243e 100%); }
        .float-animation { animation: float 6s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-20px); } }
        .glow { box-shadow: 0 0 40px rgba(99, 102, 241, 0.3); }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 transition-colors duration-300">

    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 bg-white/80 dark:bg-gray-900/80 backdrop-blur-xl border-b border-gray-200/50 dark:border-gray-700/50" x-data="{ mobileOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center shadow-lg shadow-primary-500/30">
                        <i class="fas fa-dumbbell text-white text-sm"></i>
                    </div>
                    <span class="text-xl font-extrabold gradient-text">FitSphere</span>
                </div>
                <div class="hidden md:flex items-center gap-8">
                    <a href="#features" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition">Features</a>
                    <a href="#stats" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition">Stats</a>
                    <a href="#testimonials" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary-600 dark:hover:text-primary-400 transition">Testimonials</a>
                </div>
                <div class="flex items-center gap-3">
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <i :class="darkMode ? 'fas fa-sun text-yellow-400' : 'fas fa-moon text-gray-500'" class="text-sm"></i>
                    </button>
                    @auth
                    <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-primary-500 to-accent-500 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:shadow-lg hover:shadow-primary-500/25 transition-all duration-300 hover:-translate-y-0.5">Dashboard</a>
                    @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary-600 transition">Sign In</a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-primary-500 to-accent-500 text-white px-5 py-2 rounded-xl text-sm font-semibold hover:shadow-lg hover:shadow-primary-500/25 transition-all duration-300 hover:-translate-y-0.5">Get Started</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient min-h-screen flex items-center relative overflow-hidden pt-16">
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-1/4 w-72 h-72 bg-primary-500/20 rounded-full blur-[100px]"></div>
            <div class="absolute bottom-1/4 right-1/4 w-96 h-96 bg-accent-500/15 rounded-full blur-[120px]"></div>
            <div class="absolute top-1/2 left-1/2 w-48 h-48 bg-blue-500/10 rounded-full blur-[80px]"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-white space-y-8 animate-fade-in">
                    <div class="inline-flex items-center gap-2 bg-white/10 backdrop-blur px-4 py-2 rounded-full text-sm border border-white/10">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        <span>Smart Fitness Platform</span>
                    </div>
                    <h1 class="text-4xl md:text-6xl lg:text-7xl font-black leading-tight">
                        Transform Your <br>
                        <span class="bg-gradient-to-r from-primary-400 via-accent-400 to-pink-400 bg-clip-text text-transparent">Fitness Journey</span>
                    </h1>
                    <p class="text-lg text-gray-300 max-w-lg leading-relaxed">
                        Track workouts, monitor nutrition, join sports events, and unlock your full potential with FitSphere's intelligent fitness management system.
                    </p>
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('register') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-primary-500 to-accent-500 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:shadow-2xl hover:shadow-primary-500/30 transition-all duration-300 hover:-translate-y-1">
                            Start Free <i class="fas fa-arrow-right"></i>
                        </a>
                        <a href="#features" class="inline-flex items-center gap-2 bg-white/10 backdrop-blur text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-white/20 transition-all duration-300 border border-white/10">
                            <i class="fas fa-play-circle"></i> Learn More
                        </a>
                    </div>
                    <div class="flex items-center gap-8 pt-4">
                        <div><p class="text-3xl font-black">10K+</p><p class="text-xs text-gray-400">Active Users</p></div>
                        <div class="w-px h-10 bg-white/20"></div>
                        <div><p class="text-3xl font-black">50K+</p><p class="text-xs text-gray-400">Workouts Logged</p></div>
                        <div class="w-px h-10 bg-white/20"></div>
                        <div><p class="text-3xl font-black">95%</p><p class="text-xs text-gray-400">Satisfaction</p></div>
                    </div>
                </div>
                <div class="hidden lg:flex justify-center">
                    <div class="relative float-animation">
                        <div class="w-80 h-80 rounded-3xl bg-gradient-to-br from-primary-500/30 to-accent-500/30 backdrop-blur-xl border border-white/10 p-8 flex flex-col items-center justify-center gap-6 glow">
                            <i class="fas fa-heartbeat text-6xl text-white/80"></i>
                            <div class="text-center text-white">
                                <p class="text-5xl font-black">85</p>
                                <p class="text-sm text-white/60 mt-1">Fitness Score</p>
                            </div>
                            <div class="flex gap-4">
                                <div class="text-center"><p class="text-lg font-bold text-white">12K</p><p class="text-[10px] text-white/50">Steps</p></div>
                                <div class="text-center"><p class="text-lg font-bold text-white">650</p><p class="text-[10px] text-white/50">Cal</p></div>
                                <div class="text-center"><p class="text-lg font-bold text-white">7.5h</p><p class="text-[10px] text-white/50">Sleep</p></div>
                            </div>
                        </div>
                        <div class="absolute -top-6 -right-6 w-20 h-20 rounded-2xl glass-card flex items-center justify-center animate-bounce-soft" style="animation-delay: 0.5s">
                            <i class="fas fa-fire text-3xl text-orange-400"></i>
                        </div>
                        <div class="absolute -bottom-4 -left-8 w-24 h-16 rounded-xl glass-card flex items-center justify-center gap-2 animate-bounce-soft" style="animation-delay: 1s">
                            <i class="fas fa-trophy text-yellow-400"></i>
                            <span class="text-white text-xs font-bold">Level Up!</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 bg-white dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-flex items-center gap-2 bg-primary-100 dark:bg-primary-900/30 text-primary-600 dark:text-primary-400 px-4 py-1.5 rounded-full text-sm font-semibold mb-4">
                    <i class="fas fa-star"></i> Features
                </span>
                <h2 class="text-3xl md:text-5xl font-black text-gray-900 dark:text-white">Everything You Need to <span class="gradient-text">Stay Fit</span></h2>
                <p class="mt-4 text-lg text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">Comprehensive tools designed to help you track, improve, and celebrate your fitness journey.</p>
            </div>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @php
                $features = [
                    ['icon' => 'fa-dumbbell', 'color' => 'from-blue-500 to-cyan-500', 'bg' => 'bg-blue-50 dark:bg-blue-900/20', 'title' => 'Workout Management', 'desc' => 'Create and track custom workout plans with categorized exercises, duration tracking, and progress monitoring.'],
                    ['icon' => 'fa-heartbeat', 'color' => 'from-red-500 to-pink-500', 'bg' => 'bg-red-50 dark:bg-red-900/20', 'title' => 'Fitness Tracking', 'desc' => 'Monitor daily steps, water intake, sleep patterns, heart rate, and overall health metrics.'],
                    ['icon' => 'fa-utensils', 'color' => 'from-green-500 to-emerald-500', 'bg' => 'bg-green-50 dark:bg-green-900/20', 'title' => 'Diet & Nutrition', 'desc' => 'Log meals, track macronutrients, and get healthy food suggestions with calorie counting.'],
                    ['icon' => 'fa-trophy', 'color' => 'from-yellow-500 to-orange-500', 'bg' => 'bg-yellow-50 dark:bg-yellow-900/20', 'title' => 'Sports Events', 'desc' => 'Create and join sports events, manage teams, and compete with the community.'],
                    ['icon' => 'fa-chart-line', 'color' => 'from-purple-500 to-violet-500', 'bg' => 'bg-purple-50 dark:bg-purple-900/20', 'title' => 'Analytics & Reports', 'desc' => 'Beautiful charts and insights showing your progress trends and fitness achievements.'],
                    ['icon' => 'fa-shield-alt', 'color' => 'from-indigo-500 to-blue-500', 'bg' => 'bg-indigo-50 dark:bg-indigo-900/20', 'title' => 'Secure & Private', 'desc' => 'Enterprise-grade security with role-based access, encryption, and data protection.'],
                ];
                @endphp

                @foreach($features as $feature)
                <div class="group p-6 rounded-2xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 hover:shadow-2xl hover:-translate-y-2 transition-all duration-500">
                    <div class="w-14 h-14 rounded-2xl bg-gradient-to-br {{ $feature['color'] }} flex items-center justify-center mb-5 group-hover:scale-110 transition-transform duration-300 shadow-lg">
                        <i class="fas {{ $feature['icon'] }} text-white text-xl"></i>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-2">{{ $feature['title'] }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">{{ $feature['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="py-24 bg-gradient-to-r from-primary-600 via-purple-600 to-accent-600 relative overflow-hidden">
        <div class="absolute inset-0"><div class="absolute top-0 left-0 w-full h-full bg-[url('data:image/svg+xml,...')] opacity-5"></div></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                $stats = [
                    ['num' => '10K+', 'label' => 'Active Users', 'icon' => 'fa-users'],
                    ['num' => '50K+', 'label' => 'Workouts Tracked', 'icon' => 'fa-dumbbell'],
                    ['num' => '200+', 'label' => 'Sports Events', 'icon' => 'fa-trophy'],
                    ['num' => '4.9★', 'label' => 'User Rating', 'icon' => 'fa-star'],
                ];
                @endphp
                @foreach($stats as $stat)
                <div class="text-center text-white">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-white/10 backdrop-blur flex items-center justify-center">
                        <i class="fas {{ $stat['icon'] }} text-2xl"></i>
                    </div>
                    <p class="text-4xl md:text-5xl font-black">{{ $stat['num'] }}</p>
                    <p class="text-sm text-white/70 mt-2">{{ $stat['label'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section id="testimonials" class="py-24 bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="inline-flex items-center gap-2 bg-green-100 dark:bg-green-900/30 text-green-600 dark:text-green-400 px-4 py-1.5 rounded-full text-sm font-semibold mb-4">
                    <i class="fas fa-quote-left"></i> Testimonials
                </span>
                <h2 class="text-3xl md:text-5xl font-black text-gray-900 dark:text-white">What Our <span class="gradient-text">Users Say</span></h2>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                @php
                $testimonials = [
                    ['name' => 'Sarah Johnson', 'role' => 'Yoga Enthusiast', 'text' => 'FitSphere transformed how I track my yoga sessions. The nutrition tracking is incredible, and I love the progress analytics!', 'rating' => 5],
                    ['name' => 'Mike Chen', 'role' => 'CrossFit Athlete', 'text' => 'Best fitness app I\'ve used. The workout management is super detailed, and the sports event feature is perfect for our community.', 'rating' => 5],
                    ['name' => 'Emily Davis', 'role' => 'Marathon Runner', 'text' => 'I\'ve tried many fitness apps, but FitSphere\'s dashboard and analytics are on another level. Beautifully designed and functional.', 'rating' => 5],
                ];
                @endphp
                @foreach($testimonials as $t)
                <div class="p-6 rounded-2xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-all duration-300">
                    <div class="flex gap-1 text-yellow-400 mb-4">
                        @for($i = 0; $i < $t['rating']; $i++) <i class="fas fa-star text-sm"></i> @endfor
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 text-sm leading-relaxed mb-6">"{{ $t['text'] }}"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center text-white font-bold text-sm">
                            {{ strtoupper(substr($t['name'], 0, 1)) }}
                        </div>
                        <div>
                            <p class="font-semibold text-sm text-gray-900 dark:text-white">{{ $t['name'] }}</p>
                            <p class="text-xs text-gray-400">{{ $t['role'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-24 bg-white dark:bg-gray-800">
        <div class="max-w-4xl mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-5xl font-black text-gray-900 dark:text-white mb-6">Ready to Start Your <span class="gradient-text">Fitness Journey?</span></h2>
            <p class="text-lg text-gray-500 dark:text-gray-400 mb-10 max-w-2xl mx-auto">Join thousands of users who are already transforming their health with FitSphere.</p>
            <a href="{{ route('register') }}" class="inline-flex items-center gap-3 bg-gradient-to-r from-primary-500 to-accent-500 text-white px-10 py-5 rounded-2xl font-bold text-lg hover:shadow-2xl hover:shadow-primary-500/30 transition-all duration-300 hover:-translate-y-1">
                Get Started for Free <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 dark:bg-gray-950 text-gray-400 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-12">
                <div>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center">
                            <i class="fas fa-dumbbell text-white text-sm"></i>
                        </div>
                        <span class="text-xl font-extrabold text-white">FitSphere</span>
                    </div>
                    <p class="text-sm leading-relaxed">Your complete fitness & sports management platform for a healthier lifestyle.</p>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Platform</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#features" class="hover:text-white transition">Features</a></li>
                        <li><a href="#" class="hover:text-white transition">Pricing</a></li>
                        <li><a href="#" class="hover:text-white transition">Mobile App</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Support</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-white transition">Help Center</a></li>
                        <li><a href="#" class="hover:text-white transition">Contact</a></li>
                        <li><a href="#" class="hover:text-white transition">Privacy</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-white mb-4">Connect</h4>
                    <div class="flex gap-3">
                        <a href="#" class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center hover:bg-primary-500 transition"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center hover:bg-primary-500 transition"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center hover:bg-primary-500 transition"><i class="fab fa-github"></i></a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>&copy; {{ date('Y') }} FitSphere. All rights reserved. Built with <i class="fas fa-heart text-red-400"></i> for fitness enthusiasts.</p>
            </div>
        </div>
    </footer>

</body>
</html>
