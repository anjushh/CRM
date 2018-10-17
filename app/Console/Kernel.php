<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        //$schedule->call(function () {
        //     DB::table('msg_reminders')->;
        // })->daily();
        // $schedule->command('your:command')->daily()->at('12:00')->when(function () use ($dateInDatabase) {
        //  return (
        //             $dateInDatabase == Carbon::today() ||
        //             $dateInDatabase == Carbon::yesterday() ||
        //             $dateInDatabase == Carbon::subDays(2)
        //         );
        //     });
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
