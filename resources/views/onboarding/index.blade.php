<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'FitSphere') }} - Onboarding</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-gray-100 min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 relative">

    <!-- Background decoration -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-primary-500/10 rounded-full blur-[100px]"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-accent-500/10 rounded-full blur-[120px]"></div>
    </div>

    <div class="w-full max-w-2xl relative z-10" x-data="{ step: 1, totalSteps: 4, formData: { fitness_goal: '', activity_level: '', gender: '', age: '', height: '', weight: '' } }">
        
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center gap-3">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center shadow-xl shadow-primary-500/30">
                    <i class="fas fa-dumbbell text-white text-xl"></i>
                </div>
                <span class="text-2xl font-extrabold bg-gradient-to-r from-primary-600 to-accent-500 bg-clip-text text-transparent">FitSphere</span>
            </div>
            <p class="text-gray-500 dark:text-gray-400 mt-2 font-medium">Let's customize your experience</p>
        </div>

        <!-- Progress Bar -->
        <div class="mb-8">
            <div class="flex justify-between text-xs font-semibold text-gray-400 mb-2">
                <span :class="{ 'text-primary-500': step >= 1 }">Goal</span>
                <span :class="{ 'text-primary-500': step >= 2 }">Activity</span>
                <span :class="{ 'text-primary-500': step >= 3 }">About You</span>
                <span :class="{ 'text-primary-500': step >= 4 }">Metrics</span>
            </div>
            <div class="h-2 w-full bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                <div class="h-full bg-gradient-to-r from-primary-500 to-accent-500 transition-all duration-500" :style="`width: ${(step / totalSteps) * 100}%`"></div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-xl shadow-gray-200/50 dark:shadow-none border border-gray-100 dark:border-gray-700 p-8">
            <form method="POST" action="{{ route('onboarding.store') }}" id="onboardingForm">
                @csrf

                <!-- Step 1: Goal -->
                <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0">
                    <h2 class="text-2xl font-bold mb-6 text-center">What is your primary goal?</h2>
                    <input type="hidden" name="fitness_goal" x-model="formData.fitness_goal" required>
                    <div class="space-y-3">
                        <template x-for="goal in [
                            {id: 'lose', label: 'Lose Weight', icon: 'fa-arrow-down text-blue-500'},
                            {id: 'maintain', label: 'Maintain Weight', icon: 'fa-equals text-green-500'},
                            {id: 'gain', label: 'Gain Weight', icon: 'fa-arrow-up text-orange-500'},
                            {id: 'muscle', label: 'Build Muscle', icon: 'fa-dumbbell text-purple-500'}
                        ]">
                            <button type="button" @click="formData.fitness_goal = goal.label; setTimeout(() => step++, 300)"
                                :class="formData.fitness_goal === goal.label ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-gray-200 dark:border-gray-700 hover:border-primary-300'"
                                class="w-full flex items-center gap-4 p-4 rounded-xl border-2 transition-all text-left">
                                <div class="w-10 h-10 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center"><i class="fas" :class="goal.icon"></i></div>
                                <span class="font-semibold text-lg" x-text="goal.label"></span>
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Step 2: Activity Level -->
                <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
                    <h2 class="text-2xl font-bold mb-6 text-center">What is your baseline activity level?</h2>
                    <input type="hidden" name="activity_level" x-model="formData.activity_level" required>
                    <div class="space-y-3">
                        <template x-for="act in [
                            {id: 'sedentary', label: 'Not Very Active', desc: 'Spend most of the day sitting (e.g., desk job)'},
                            {id: 'light', label: 'Lightly Active', desc: 'Spend a good part of the day on your feet (e.g., teacher)'},
                            {id: 'active', label: 'Active', desc: 'Spend a good part of the day doing some physical activity (e.g., food server)'},
                            {id: 'very_active', label: 'Very Active', desc: 'Spend most of the day doing heavy physical activity (e.g., bike messenger)'}
                        ]">
                            <button type="button" @click="formData.activity_level = act.id; setTimeout(() => step++, 300)"
                                :class="formData.activity_level === act.id ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-gray-200 dark:border-gray-700 hover:border-primary-300'"
                                class="w-full text-left p-4 rounded-xl border-2 transition-all">
                                <h3 class="font-bold text-lg" x-text="act.label"></h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" x-text="act.desc"></p>
                            </button>
                        </template>
                    </div>
                    <div class="mt-6 flex justify-start">
                        <button type="button" @click="step--" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 font-medium"><i class="fas fa-arrow-left mr-2"></i> Back</button>
                    </div>
                </div>

                <!-- Step 3: Personal Info -->
                <div x-show="step === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
                    <h2 class="text-2xl font-bold mb-6 text-center">Tell us a bit about yourself</h2>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold mb-3">Gender</label>
                            <div class="grid grid-cols-3 gap-3">
                                <template x-for="g in [{id: 'male', label: 'Male'}, {id: 'female', label: 'Female'}, {id: 'other', label: 'Other'}]">
                                    <label :class="formData.gender === g.id ? 'border-primary-500 bg-primary-50 dark:bg-primary-900/20' : 'border-gray-200 dark:border-gray-700'" class="cursor-pointer border-2 rounded-xl p-3 text-center transition-all">
                                        <input type="radio" name="gender" x-model="formData.gender" :value="g.id" class="hidden">
                                        <span class="font-semibold" x-text="g.label"></span>
                                    </label>
                                </template>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Age</label>
                            <input type="number" name="age" x-model="formData.age" min="10" max="120" placeholder="e.g., 28" class="w-full text-lg p-4 rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between items-center">
                        <button type="button" @click="step--" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 font-medium"><i class="fas fa-arrow-left mr-2"></i> Back</button>
                        <button type="button" @click="if(formData.gender && formData.age) step++;" :disabled="!formData.gender || !formData.age" :class="(!formData.gender || !formData.age) ? 'opacity-50 cursor-not-allowed' : 'hover:shadow-lg hover:-translate-y-0.5'" class="bg-gradient-to-r from-primary-500 to-accent-500 text-white px-8 py-3 rounded-xl font-bold transition-all">Next <i class="fas fa-arrow-right ml-2"></i></button>
                    </div>
                </div>

                <!-- Step 4: Metrics -->
                <div x-show="step === 4" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-8" x-transition:enter-end="opacity-100 translate-x-0" style="display: none;">
                    <h2 class="text-2xl font-bold mb-6 text-center">Your starting metrics</h2>
                    
                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-semibold mb-2">Height (cm)</label>
                            <div class="relative">
                                <input type="number" name="height" x-model="formData.height" min="50" max="300" step="0.1" placeholder="e.g., 175" class="w-full text-lg p-4 pr-16 rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 focus:ring-primary-500 focus:border-primary-500">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 font-semibold">cm</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold mb-2">Current Weight (kg)</label>
                            <div class="relative">
                                <input type="number" name="weight" x-model="formData.weight" min="20" max="400" step="0.1" placeholder="e.g., 70" class="w-full text-lg p-4 pr-16 rounded-xl border-gray-200 dark:border-gray-700 dark:bg-gray-800 focus:ring-primary-500 focus:border-primary-500">
                                <span class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 font-semibold">kg</span>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 flex justify-between items-center">
                        <button type="button" @click="step--" class="text-gray-500 hover:text-gray-700 dark:hover:text-gray-300 font-medium"><i class="fas fa-arrow-left mr-2"></i> Back</button>
                        <button type="submit" :disabled="!formData.height || !formData.weight" :class="(!formData.height || !formData.weight) ? 'opacity-50 cursor-not-allowed' : 'hover:shadow-lg hover:shadow-primary-500/30 hover:-translate-y-0.5'" class="bg-gradient-to-r from-green-500 to-emerald-500 text-white px-8 py-3 rounded-xl font-bold transition-all"><i class="fas fa-flag-checkered mr-2"></i> Complete Profile</button>
                    </div>
                </div>

                @if($errors->any())
                <div class="mt-4 p-4 bg-red-50 text-red-500 rounded-xl text-sm">
                    <ul>@foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach</ul>
                </div>
                @endif
            </form>
        </div>
    </div>

</body>
</html>
