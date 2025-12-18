<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BehaviorCategory;
use App\Models\BehaviorType;
use App\Models\Driver;
use Illuminate\Http\Request;

class AdminBehaviorController extends Controller
{
    public function index()
    {
        $categories = BehaviorCategory::with('behaviorTypes.driverBehaviors')->get();
        return view('admin.behaviors.index', compact('categories'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'behavior_category_id' => 'required|exists:behavior_categories,id',
            'name' => 'required|string|max:255',
            'category' => 'required|in:positive,negative',
            'severity' => 'required|in:low,medium,high',
            'default_score' => 'required|integer',
        ]);


        BehaviorType::create($request->all());
        return back()->with('success', 'Behavior added successfully');
    }


    public function update(Request $request, BehaviorType $behavior)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:positive,negative',
            'severity' => 'required|in:low,medium,high',
            'default_score' => 'required|integer',
        ]);


        $behavior->update($request->all());
        return back()->with('success', 'Behavior updated successfully');
    }


    public function destroy(BehaviorType $behavior)
    {
        $behavior->delete();
        return back()->with('success', 'Behavior deleted');
    }

    public function driverBehavior(BehaviorType $behavior)
    {
        $drivers = $behavior->driverBehaviors()
            ->with('driver')
            ->latest()
            ->paginate(20);

        return view('admin.behaviors.drivers', compact('behavior', 'drivers'));
    }
}
