<?php

namespace App\Http\Controllers;

use App\Models\Material;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    public function index()
    {
        $materials = Material::with('theme.subject')->get();
        return view('materials.index', compact('materials'));
    }

    public function create()
    {
        $themes = Theme::with('subject')->get();
        return view('materials.create', compact('themes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'theme_id' => 'required|exists:themes,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('file')) {
            $path = $request->file('file')->store('materials', 'public');
            $validated['file_path'] = $path;
        }

        unset($validated['file']);
        Material::create($validated);

        return redirect()->route('materials.index')->with('success', 'Material created successfully.');
    }

    public function show(Material $material)
    {
        $material->load('theme.subject');
        return view('materials.show', compact('material'));
    }

    public function edit(Material $material)
    {
        $themes = Theme::with('subject')->get();
        return view('materials.edit', compact('material', 'themes'));
    }

    public function update(Request $request, Material $material)
    {
        $validated = $request->validate([
            'theme_id' => 'required|exists:themes,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        if ($request->hasFile('file')) {
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $path = $request->file('file')->store('materials', 'public');
            $validated['file_path'] = $path;
        }

        unset($validated['file']);
        $material->update($validated);

        return redirect()->route('materials.index')->with('success', 'Material updated successfully.');
    }

    public function destroy(Material $material)
    {
        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }
        $material->delete();
        return redirect()->route('materials.index')->with('success', 'Material deleted successfully.');
    }
}
