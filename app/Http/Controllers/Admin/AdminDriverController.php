<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BehaviorType;
use App\Models\Driver;
use App\Models\DriverBehavior;
use Illuminate\Http\Request;

class AdminDriverController extends Controller
{
    public function indexBehavior(Driver $driver)
    {
        $behaviors = $driver->behaviors()
            ->with('behaviorType.behaviorCategory')
            ->paginate(20);

        return view('admin.drivers.behaviors', compact('driver', 'behaviors'));
    }
    public function storeBehavior(Request $request, Driver $driver)
    {
        $request->validate([
            'behavior_type_id' => 'required|exists:behavior_types,id',
            'severity' => 'required|in:low,medium,high',
            'score' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        $behavior = BehaviorType::findOrFail($request->behavior_type_id);

        $score = $request->score ?? $behavior->default_score;

        DriverBehavior::create([
            'driver_id' => $driver->id,
            'behavior_type_id' => $request->behavior_type_id,
            'severity' => $request->severity,
            'score' => $score,
            'description' => $request->description,
            'reported_by' => auth()->id(),
        ]);

        return back()->with('success', 'Behavior reported successfully');
    }
}
