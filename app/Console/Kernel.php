<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Mkhodroo\Voip\Controllers\VoipController;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $data = VoipController::sip_show_peers_status();
            print($data);
        })->timezone('Asia/Tehran')->everyMinute()->between('08:25', '14:00')->days([Schedule::SUNDAY, Schedule::SATURDAY, Schedule::MONDAY, Schedule::THURSDAY, Schedule::WEDNESDAY]);
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
