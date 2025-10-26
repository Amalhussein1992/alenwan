<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LanguagesController extends Controller
{
    public function index(Request $request)
    {
        $query = Language::withCount(['movies'])->orderBy('name');

        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('code', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('is_active', $request->status === 'active');
        }

        $languages = $query->paginate(15);

        return view('admin.languages.index', compact('languages'));
    }

    public function create()
    {
        return view('admin.languages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:languages,code',
            'is_active' => 'boolean',
            'flag' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        $flagPath = null;
        if ($request->hasFile('flag')) {
            $flagPath = $request->file('flag')->store('languages/flags', 'public');
        }

        Language::create([
            'name' => $request->name,
            'code' => $request->code,
            'is_active' => $request->has('is_active'),
            'flag_path' => $flagPath,
        ]);

        return redirect()->route('admin.languages.index')
            ->with('success', 'Language created successfully!');
    }

    public function edit($id)
    {
        $language = Language::findOrFail($id);
        return view('admin.languages.edit', compact('language'));
    }

    public function update(Request $request, $id)
    {
        $language = Language::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:languages,code,' . $id,
            'is_active' => 'boolean',
            'flag' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
        ]);

        $flagPath = $language->flag_path;
        if ($request->hasFile('flag')) {
            if ($language->flag_path) {
                Storage::disk('public')->delete($language->flag_path);
            }
            $flagPath = $request->file('flag')->store('languages/flags', 'public');
        }

        $language->update([
            'name' => $request->name,
            'code' => $request->code,
            'is_active' => $request->has('is_active'),
            'flag_path' => $flagPath,
        ]);

        return redirect()->route('admin.languages.index')
            ->with('success', 'Language updated successfully!');
    }

    public function destroy($id)
    {
        $language = Language::findOrFail($id);

        if ($language->flag_path) {
            Storage::disk('public')->delete($language->flag_path);
        }

        $language->delete();

        return redirect()->route('admin.languages.index')
            ->with('success', 'Language deleted successfully!');
    }
}
