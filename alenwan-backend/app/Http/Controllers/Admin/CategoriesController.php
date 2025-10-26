<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::withCount(['movies'])->orderBy('sort_order');

        if ($request->has('search') && $request->search) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->has('type') && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        if ($request->has('status') && $request->status !== 'all') {
            $query->where('is_active', $request->status === 'active');
        }

        $categories = $query->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        Category::create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'boolean',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $category->image_path;
        if ($request->hasFile('image')) {
            if ($category->image_path) {
                Storage::disk('public')->delete($category->image_path);
            }
            $imagePath = $request->file('image')->store('categories', 'public');
        }

        $category->update([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'sort_order' => $request->sort_order ?? 0,
            'is_active' => $request->has('is_active'),
            'image_path' => $imagePath,
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);

        if ($category->image_path) {
            Storage::disk('public')->delete($category->image_path);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }
}
