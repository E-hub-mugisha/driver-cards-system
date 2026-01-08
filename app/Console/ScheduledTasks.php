<?php

use Illuminate\Console\Scheduling\Schedule;

return function (Schedule $schedule) {
    // Run payroll generation on the 1st of every month at 01:00
    $schedule->command('payroll:generate')->monthlyOn(1, '01:00')->withoutOverlapping();
};
