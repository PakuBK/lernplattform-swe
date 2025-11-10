<?php

namespace App\Http\Controllers;

use App\Models\Theme;
use App\Models\Subject;
use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = Theme::with('subject')->get();
        return view('themes.index', compact('themes'));
    }

    public function create()
    {
        $subjects = Subject::all();
        return view('themes.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        Theme::create($validated);
        return redirect()->route('themes.index')->with('success', 'Theme created successfully.');
    }

    public function show(Theme $theme)
    {
        $theme->load(['subject', 'materials', 'quizzes']);
        return view('themes.show', compact('theme'));
    }

    public function edit(Theme $theme)
    {
        $subjects = Subject::all();
        return view('themes.edit', compact('theme', 'subjects'));
    }

    public function update(Request $request, Theme $theme)
    {
        $validated = $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $theme->update($validated);
        return redirect()->route('themes.index')->with('success', 'Theme updated successfully.');
    }

    public function destroy(Theme $theme)
    {
        $theme->delete();
        return redirect()->route('themes.index')->with('success', 'Theme deleted successfully.');
    }
}
