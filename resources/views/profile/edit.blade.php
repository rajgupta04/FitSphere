<x-app-layout>
@section('title', 'My Profile')
@section('subtitle', 'Manage your personal information')

<div class="max-w-4xl mx-auto space-y-6">
    <!-- Profile Header -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="h-32 gradient-primary relative">
            <div class="absolute -bottom-12 left-8">
                <div class="w-24 h-24 rounded-2xl bg-white dark:bg-gray-700 border-4 border-white dark:border-gray-800 shadow-xl flex items-center justify-center text-3xl font-bold text-primary-500">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
            </div>
        </div>
        <div class="pt-16 pb-6 px-8">
            <h2 class="text-2xl font-bold">{{ $user->name }}</h2>
            <p class="text-gray-400 text-sm">{{ $user->email }} · <span class="capitalize">{{ $user->role }}</span></p>
            @if($user->bmi)
            <div class="flex items-center gap-4 mt-3">
                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-primary-100 dark:bg-primary-900/30 text-primary-600">BMI: {{ $user->bmi }}</span>
                <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $user->bmi_category === 'Normal' ? 'bg-green-100 text-green-600' : 'bg-yellow-100 text-yellow-600' }}">{{ $user->bmi_category }}</span>
            </div>
            @endif
        </div>
    </div>

    @if(session('status') === 'profile-updated')
    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-900 rounded-xl p-4 text-green-600 dark:text-green-400 text-sm"><i class="fas fa-check-circle mr-2"></i>Profile updated successfully!</div>
    @endif

    <!-- Edit Form -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 p-6 lg:p-8">
        <h3 class="text-lg font-bold mb-6"><i class="fas fa-user-edit text-primary-500 mr-2"></i>Edit Profile</h3>
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PATCH')
            <div class="grid md:grid-cols-2 gap-5">
                <div><label class="block text-sm font-semibold mb-2">Full Name *</label><input type="text" name="name" value="{{ old('name', $user->name) }}" required class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500">@error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
                <div><label class="block text-sm font-semibold mb-2">Email *</label><input type="email" name="email" value="{{ old('email', $user->email) }}" required class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500">@error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror</div>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div><label class="block text-sm font-semibold mb-2">Height (cm)</label><input type="number" name="height" value="{{ old('height', $user->height) }}" step="0.1" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500"></div>
                <div><label class="block text-sm font-semibold mb-2">Weight (kg)</label><input type="number" name="weight" value="{{ old('weight', $user->weight) }}" step="0.1" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500"></div>
                <div><label class="block text-sm font-semibold mb-2">Age</label><input type="number" name="age" value="{{ old('age', $user->age) }}" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500"></div>
                <div><label class="block text-sm font-semibold mb-2">Gender</label><select name="gender" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500"><option value="">Select</option>@foreach(['male'=>'Male','female'=>'Female','other'=>'Other'] as $v => $l)<option value="{{ $v }}" {{ old('gender', $user->gender) == $v ? 'selected' : '' }}>{{ $l }}</option>@endforeach</select></div>
            </div>
            <div class="grid md:grid-cols-2 gap-5">
                <div><label class="block text-sm font-semibold mb-2">Fitness Goal</label><input type="text" name="fitness_goal" value="{{ old('fitness_goal', $user->fitness_goal) }}" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500" placeholder="e.g., Lose 5kg in 2 months"></div>
                <div><label class="block text-sm font-semibold mb-2">Activity Level</label><select name="activity_level" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary-500">@foreach(['sedentary'=>'Sedentary','light'=>'Light','moderate'=>'Moderate','active'=>'Active','very_active'=>'Very Active'] as $v => $l)<option value="{{ $v }}" {{ old('activity_level', $user->activity_level) == $v ? 'selected' : '' }}>{{ $l }}</option>@endforeach</select></div>
            </div>
            <div><label class="block text-sm font-semibold mb-2">Profile Photo</label><input type="file" name="profile_photo" accept="image/*" class="w-full rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-600 hover:file:bg-primary-100"></div>
            <button type="submit" class="bg-gradient-to-r from-primary-500 to-accent-500 text-white px-8 py-3 rounded-xl font-semibold hover:shadow-lg transition-all hover:-translate-y-0.5"><i class="fas fa-save mr-2"></i>Save Changes</button>
        </form>
    </div>

    <!-- Delete Account -->
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-red-200 dark:border-red-900/30 p-6">
        <h3 class="text-lg font-bold text-red-500 mb-2"><i class="fas fa-exclamation-triangle mr-2"></i>Danger Zone</h3>
        <p class="text-sm text-gray-400 mb-4">Once your account is deleted, all data will be permanently removed.</p>
        <form method="POST" action="{{ route('profile.destroy') }}" onsubmit="return confirm('Are you sure? This cannot be undone!')">
            @csrf @method('DELETE')
            <div class="flex items-center gap-3">
                <input type="password" name="password" placeholder="Enter password to confirm" required class="rounded-xl border-gray-200 dark:border-gray-600 dark:bg-gray-700 text-sm w-64">
                <button type="submit" class="px-5 py-2.5 rounded-xl bg-red-500 text-white text-sm font-semibold hover:bg-red-600 transition">Delete Account</button>
            </div>
        </form>
    </div>
</div>
</x-app-layout>
