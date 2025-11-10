<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Subject;
use App\Models\Theme;
use App\Models\Question;
use App\Models\QuestionOption;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    public function index()
    {
        $quizzes = Quiz::with(['subject', 'theme'])->get();
        return view('quizzes.index', compact('quizzes'));
    }

    public function create()
    {
        $subjects = Subject::all();
        $themes = Theme::all();
        return view('quizzes.create', compact('subjects', 'themes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'theme_id' => 'nullable|exists:themes,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit' => 'nullable|integer|min:1',
        ]);

        Quiz::create($validated);
        return redirect()->route('quizzes.index')->with('success', 'Quiz created successfully.');
    }

    public function show(Quiz $quiz)
    {
        $quiz->load(['subject', 'theme', 'questions.options']);
        return view('quizzes.show', compact('quiz'));
    }

    public function edit(Quiz $quiz)
    {
        $subjects = Subject::all();
        $themes = Theme::all();
        $quiz->load('questions.options');
        return view('quizzes.edit', compact('quiz', 'subjects', 'themes'));
    }

    public function update(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'theme_id' => 'nullable|exists:themes,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'time_limit' => 'nullable|integer|min:1',
        ]);

        $quiz->update($validated);
        return redirect()->route('quizzes.index')->with('success', 'Quiz updated successfully.');
    }

    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return redirect()->route('quizzes.index')->with('success', 'Quiz deleted successfully.');
    }
}
