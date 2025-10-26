<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class SubscriptionPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $plans = SubscriptionPlan::orderBy('price')->get();

        // Calculate statistics
        $stats = [
            'active_plans' => SubscriptionPlan::where('is_active', true)->count(),
            'total_plans' => SubscriptionPlan::count(),
        ];

        return view('admin.subscription-plans.index', compact('plans', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subscription-plans.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'max_devices' => 'nullable|integer|min:1',
            'features' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        // Convert features from textarea (one per line) to array
        if (isset($validated['features'])) {
            $validated['features'] = array_filter(array_map('trim', explode("\n", $validated['features'])));
        }

        // Handle checkbox for is_active
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        SubscriptionPlan::create($validated);

        return redirect()->route('admin.subscription-plans.index')->with('success', 'Subscription plan created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        return view('admin.subscription-plans.show', compact('plan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        return view('admin.subscription-plans.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'max_devices' => 'nullable|integer|min:1',
            'features' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        // Convert features from textarea (one per line) to array
        if (isset($validated['features'])) {
            $validated['features'] = array_filter(array_map('trim', explode("\n", $validated['features'])));
        }

        // Handle checkbox for is_active
        $validated['is_active'] = $request->has('is_active') ? 1 : 0;

        $plan->update($validated);

        return redirect()->route('admin.subscription-plans.index')->with('success', 'Subscription plan updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $plan = SubscriptionPlan::findOrFail($id);
        $plan->delete();

        return redirect()->route('admin.subscription-plans.index')->with('success', 'Subscription plan deleted successfully!');
    }
}
