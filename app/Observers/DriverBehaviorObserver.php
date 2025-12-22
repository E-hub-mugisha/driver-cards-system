<?php

namespace App\Observers;

use App\Models\DriverBehavior;

class DriverBehaviorObserver
{
    /**
     * Handle the DriverBehavior "created" event.
     */
    public function created(DriverBehavior $behavior): void
    {
        $driver = $behavior->driver;

        // Update driver performance score
        $driver->performance_score += $behavior->score;

        // Prevent negative score if desired
        if ($driver->performance_score < 0) {
            $driver->performance_score = 0;
        }

        $driver->save();
    }

    /**
     * Handle the DriverBehavior "deleted" event.
     */
    public function deleted(DriverBehavior $behavior): void
    {
        $driver = $behavior->driver;

        // Subtract score if behavior is deleted
        $driver->performance_score -= $behavior->score;

        if ($driver->performance_score < 0) {
            $driver->performance_score = 0;
        }

        $driver->save();
    }
}
