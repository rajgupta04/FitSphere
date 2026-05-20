<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $feedbacks = Feedback::where('user_id', $request->user()->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('feedback.index', compact('feedbacks'));
    }

    public function create()
    {
        return view('feedback.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'type' => 'required|in:general,suggestion,bug,feature',
        ]);
        $validated['user_id'] = $request->user()->id;
        Feedback::create($validated);
        return redirect()->route('feedback.index')->with('success', 'Thank you for your feedback!');
    }
}
