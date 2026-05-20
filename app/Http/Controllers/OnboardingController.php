<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function index()
    {
        if (auth()->user()->is_onboarded) {
            return redirect()->route('dashboard');
        }
        return view('onboarding.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fitness_goal' => 'required|string',
            'activity_level' => 'required|string|in:sedentary,light,moderate,active,very_active',
            'gender' => 'required|string|in:male,female,other',
            'age' => 'required|integer|min:10|max:120',
            'height' => 'required|numeric|min:50|max:300',
            'weight' => 'required|numeric|min:20|max:400',
        ]);

        $user = auth()->user();
        $user->update($validated + ['is_onboarded' => true]);

        return redirect()->route('dashboard')->with('success', 'Welcome to FitSphere! Your profile has been set up.');
    }
}
