<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('teacher')->get();
        return view('subjects.index', compact('subjects'));
    }

    public function create()
    {
        $teachers = User::where('role', 'teacher')->get();
        return view('subjects.create', compact('teachers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        Subject::create($validated);
        return redirect()->route('subjects.index')->with('success', 'Subject created successfully.');
    }

    public function show(Subject $subject)
    {
        $subject->load(['themes.materials', 'quizzes', 'teacher']);
        return view('subjects.show', compact('subject'));
    }

    public function edit(Subject $subject)
    {
        $teachers = User::where('role', 'teacher')->get();
        return view('subjects.edit', compact('subject', 'teachers'));
    }

    public function update(Request $request, Subject $subject)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'teacher_id' => 'nullable|exists:users,id',
        ]);

        $subject->update($validated);
        return redirect()->route('subjects.index')->with('success', 'Subject updated successfully.');
    }

    public function destroy(Subject $subject)
    {
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Subject deleted successfully.');
    }
}
