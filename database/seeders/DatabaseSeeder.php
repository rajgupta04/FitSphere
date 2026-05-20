<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Workout;
use App\Models\Exercise;
use App\Models\FitnessLog;
use App\Models\DietLog;
use App\Models\Meal;
use App\Models\SportsEvent;
use App\Models\EventRegistration;
use App\Models\Notification;
use App\Models\Feedback;
use App\Models\ProgressReport;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@fitsphere.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'height' => 178,
            'weight' => 75,
            'age' => 30,
            'gender' => 'male',
            'fitness_goal' => 'Stay fit and healthy',
            'activity_level' => 'active',
        ]);

        // Create Regular User
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'user@fitsphere.com',
            'password' => Hash::make('password'),
            'role' => 'user',
            'height' => 175,
            'weight' => 80,
            'age' => 28,
            'gender' => 'male',
            'fitness_goal' => 'Lose weight and build muscle',
            'activity_level' => 'moderate',
        ]);

        // More test users
        $users = [];
        $names = ['Sarah Johnson', 'Mike Chen', 'Emily Davis', 'Alex Wilson', 'Lisa Brown'];
        foreach ($names as $i => $name) {
            $users[] = User::create([
                'name' => $name,
                'email' => strtolower(str_replace(' ', '.', $name)) . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'height' => rand(155, 190),
                'weight' => rand(50, 95),
                'age' => rand(20, 45),
                'gender' => $i % 2 == 0 ? 'female' : 'male',
                'fitness_goal' => ['Lose weight', 'Build muscle', 'Stay active', 'Run marathon', 'General fitness'][$i],
                'activity_level' => ['light', 'active', 'moderate', 'very_active', 'sedentary'][$i],
            ]);
        }

        // Create workouts for main user
        $workoutData = [
            ['name' => 'Morning Run', 'category' => 'cardio', 'duration_minutes' => 30, 'calories_burned' => 350, 'intensity' => 'moderate'],
            ['name' => 'HIIT Training', 'category' => 'cardio', 'duration_minutes' => 25, 'calories_burned' => 400, 'intensity' => 'high'],
            ['name' => 'Chest & Triceps', 'category' => 'strength', 'duration_minutes' => 45, 'calories_burned' => 280, 'intensity' => 'high'],
            ['name' => 'Yoga Flow', 'category' => 'yoga', 'duration_minutes' => 60, 'calories_burned' => 180, 'intensity' => 'low'],
            ['name' => 'Basketball Game', 'category' => 'sports', 'duration_minutes' => 90, 'calories_burned' => 600, 'intensity' => 'high'],
            ['name' => 'Back & Biceps', 'category' => 'strength', 'duration_minutes' => 50, 'calories_burned' => 300, 'intensity' => 'moderate'],
            ['name' => 'Evening Walk', 'category' => 'cardio', 'duration_minutes' => 40, 'calories_burned' => 150, 'intensity' => 'low'],
            ['name' => 'Leg Day', 'category' => 'strength', 'duration_minutes' => 55, 'calories_burned' => 350, 'intensity' => 'high'],
            ['name' => 'Swimming', 'category' => 'cardio', 'duration_minutes' => 45, 'calories_burned' => 450, 'intensity' => 'moderate'],
            ['name' => 'Power Yoga', 'category' => 'yoga', 'duration_minutes' => 45, 'calories_burned' => 220, 'intensity' => 'moderate'],
        ];

        foreach ($workoutData as $i => $data) {
            $workout = Workout::create(array_merge($data, [
                'user_id' => $user->id,
                'workout_date' => Carbon::today()->subDays($i),
                'completed' => $i < 7,
                'description' => 'Regular workout session',
            ]));

            // Add exercises
            $exerciseNames = [
                'cardio' => ['Treadmill', 'Jump Rope', 'Burpees', 'Mountain Climbers'],
                'strength' => ['Bench Press', 'Deadlift', 'Squats', 'Pull-ups'],
                'yoga' => ['Sun Salutation', 'Warrior Pose', 'Downward Dog', 'Plank'],
                'sports' => ['Dribbling', 'Shooting', 'Passing', 'Defense'],
            ];

            $names = $exerciseNames[$data['category']];
            foreach (array_slice($names, 0, rand(2, 4)) as $exName) {
                Exercise::create([
                    'workout_id' => $workout->id,
                    'name' => $exName,
                    'sets' => rand(3, 5),
                    'reps' => rand(8, 15),
                    'weight' => $data['category'] === 'strength' ? rand(20, 80) : null,
                    'duration_seconds' => rand(30, 120),
                    'rest_seconds' => rand(30, 90),
                ]);
            }
        }

        // Fitness logs for the last 30 days
        for ($i = 0; $i < 30; $i++) {
            FitnessLog::create([
                'user_id' => $user->id,
                'log_date' => Carbon::today()->subDays($i),
                'steps' => rand(3000, 15000),
                'water_intake_ml' => rand(1000, 3500),
                'calories_consumed' => rand(1500, 2800),
                'calories_burned' => rand(200, 800),
                'sleep_hours' => rand(5, 9) + (rand(0, 1) * 0.5),
                'weight' => 80 - ($i * 0.05) + (rand(-5, 5) / 10),
                'heart_rate' => rand(60, 85),
                'mood' => ['great', 'good', 'neutral', 'good', 'great'][rand(0, 4)],
            ]);
        }

        // Diet logs
        $foods = [
            ['name' => 'Oatmeal with Berries', 'type' => 'breakfast', 'cal' => 350, 'p' => 12, 'c' => 55, 'f' => 8],
            ['name' => 'Greek Yogurt', 'type' => 'breakfast', 'cal' => 150, 'p' => 15, 'c' => 12, 'f' => 4],
            ['name' => 'Grilled Chicken Salad', 'type' => 'lunch', 'cal' => 450, 'p' => 35, 'c' => 20, 'f' => 18],
            ['name' => 'Brown Rice Bowl', 'type' => 'lunch', 'cal' => 520, 'p' => 25, 'c' => 65, 'f' => 12],
            ['name' => 'Salmon & Veggies', 'type' => 'dinner', 'cal' => 480, 'p' => 38, 'c' => 15, 'f' => 22],
            ['name' => 'Protein Shake', 'type' => 'snack', 'cal' => 200, 'p' => 30, 'c' => 10, 'f' => 3],
            ['name' => 'Mixed Nuts', 'type' => 'snack', 'cal' => 180, 'p' => 6, 'c' => 8, 'f' => 16],
            ['name' => 'Egg White Omelet', 'type' => 'breakfast', 'cal' => 250, 'p' => 22, 'c' => 5, 'f' => 10],
        ];

        for ($i = 0; $i < 14; $i++) {
            foreach (array_rand($foods, rand(3, 5)) as $idx) {
                $food = $foods[$idx];
                DietLog::create([
                    'user_id' => $user->id,
                    'log_date' => Carbon::today()->subDays($i),
                    'meal_type' => $food['type'],
                    'food_name' => $food['name'],
                    'calories' => $food['cal'],
                    'protein_g' => $food['p'],
                    'carbs_g' => $food['c'],
                    'fat_g' => $food['f'],
                    'fiber_g' => rand(2, 8),
                ]);
            }
        }

        // Meals (suggestions)
        $mealSuggestions = [
            ['name' => 'Avocado Toast', 'description' => 'Whole grain toast with avocado and eggs', 'meal_type' => 'breakfast', 'calories' => 380, 'protein_g' => 15, 'carbs_g' => 35, 'fat_g' => 22, 'fiber_g' => 8, 'is_healthy' => true],
            ['name' => 'Quinoa Bowl', 'description' => 'Quinoa with roasted vegetables and tahini', 'meal_type' => 'lunch', 'calories' => 420, 'protein_g' => 18, 'carbs_g' => 55, 'fat_g' => 14, 'fiber_g' => 10, 'is_healthy' => true],
            ['name' => 'Grilled Fish Tacos', 'description' => 'Light fish tacos with cabbage slaw', 'meal_type' => 'dinner', 'calories' => 380, 'protein_g' => 28, 'carbs_g' => 32, 'fat_g' => 15, 'fiber_g' => 5, 'is_healthy' => true],
            ['name' => 'Smoothie Bowl', 'description' => 'Acai smoothie bowl with granola and fruit', 'meal_type' => 'breakfast', 'calories' => 320, 'protein_g' => 10, 'carbs_g' => 52, 'fat_g' => 8, 'fiber_g' => 7, 'is_healthy' => true],
            ['name' => 'Turkey Wrap', 'description' => 'Whole wheat wrap with turkey and veggies', 'meal_type' => 'lunch', 'calories' => 350, 'protein_g' => 28, 'carbs_g' => 30, 'fat_g' => 12, 'fiber_g' => 6, 'is_healthy' => true],
            ['name' => 'Stir-fry Tofu', 'description' => 'Tofu stir-fry with mixed vegetables', 'meal_type' => 'dinner', 'calories' => 300, 'protein_g' => 20, 'carbs_g' => 25, 'fat_g' => 14, 'fiber_g' => 8, 'is_healthy' => true],
        ];

        foreach ($mealSuggestions as $meal) {
            Meal::create($meal);
        }

        // Sports Events
        $eventData = [
            ['title' => 'Community Basketball Tournament', 'sport_type' => 'Basketball', 'days' => 7, 'max' => 24, 'location' => 'City Sports Arena'],
            ['title' => 'Morning Yoga in the Park', 'sport_type' => 'Yoga', 'days' => 3, 'max' => 30, 'location' => 'Central Park'],
            ['title' => '5K Charity Run', 'sport_type' => 'Running', 'days' => 14, 'max' => 100, 'location' => 'Riverside Track'],
            ['title' => 'Swimming Competition', 'sport_type' => 'Swimming', 'days' => 21, 'max' => 40, 'location' => 'Olympic Pool Center'],
            ['title' => 'Cricket Weekend Match', 'sport_type' => 'Cricket', 'days' => 5, 'max' => 22, 'location' => 'Sports Ground'],
            ['title' => 'Table Tennis Open', 'sport_type' => 'Table Tennis', 'days' => 10, 'max' => 16, 'location' => 'Indoor Sports Hall'],
        ];

        foreach ($eventData as $data) {
            $event = SportsEvent::create([
                'title' => $data['title'],
                'description' => 'Join us for an exciting ' . strtolower($data['sport_type']) . ' event!',
                'sport_type' => $data['sport_type'],
                'event_date' => Carbon::today()->addDays($data['days']),
                'start_time' => '09:00',
                'end_time' => '17:00',
                'location' => $data['location'],
                'max_participants' => $data['max'],
                'status' => 'upcoming',
                'created_by' => $admin->id,
            ]);

            // Register some users
            foreach (array_slice($users, 0, rand(1, 3)) as $u) {
                EventRegistration::create([
                    'user_id' => $u->id,
                    'sports_event_id' => $event->id,
                    'status' => 'registered',
                ]);
            }
        }

        // Notifications
        $notifData = [
            ['title' => 'Welcome to FitSphere!', 'message' => 'Start your fitness journey today. Set up your profile and create your first workout!', 'type' => 'info'],
            ['title' => 'Workout Reminder', 'message' => 'Don\'t forget your morning workout routine!', 'type' => 'reminder'],
            ['title' => 'Achievement Unlocked!', 'message' => 'You completed 7 workouts this week! Keep it up!', 'type' => 'achievement'],
            ['title' => 'New Event Available', 'message' => 'Community Basketball Tournament is now open for registration.', 'type' => 'info'],
            ['title' => 'Weekly Progress', 'message' => 'Check out your weekly fitness report in the analytics section.', 'type' => 'info'],
        ];

        foreach ($notifData as $i => $notif) {
            Notification::create(array_merge($notif, [
                'user_id' => $user->id,
                'is_read' => $i > 2,
            ]));
        }

        // Feedback
        Feedback::create([
            'user_id' => $user->id,
            'subject' => 'Great App!',
            'message' => 'Really enjoying the fitness tracking features. Would love to see more workout templates.',
            'rating' => 5,
            'type' => 'general',
            'status' => 'reviewed',
        ]);

        // Progress Reports
        for ($w = 1; $w <= 4; $w++) {
            ProgressReport::create([
                'user_id' => $user->id,
                'report_date' => Carbon::today()->subWeeks(4 - $w),
                'week_number' => $w,
                'total_workouts' => rand(3, 7),
                'total_calories_burned' => rand(1500, 3500),
                'total_steps' => rand(35000, 80000),
                'avg_sleep_hours' => rand(6, 8) + (rand(0, 1) * 0.5),
                'weight_start' => 82 - ($w * 0.5),
                'weight_end' => 81.5 - ($w * 0.5),
                'fitness_score' => min(50 + ($w * 10), 100),
            ]);
        }
    }
}
