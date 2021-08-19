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
        'App\Console\Commands\UpdateData',
        'App\Console\Commands\UpdateSpankbang',
        'App\Console\Commands\UpdateSpankbangBackup',
        'App\Console\Commands\UpdateSpankbangErrors',
        'App\Console\Commands\UpdateYoujizz',
        'App\Console\Commands\UpdateXvideos',
        'App\Console\Commands\UploadRule34',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('hanime1:update-data')->dailyAt('05:00');
        $schedule->command('hanime1:update-xvideos')->hourly();
        $schedule->command('hanime1:update-spankbang')->cron('0 */3 * * *')->between('2:00', '22:00');
        $schedule->command('hanime1:update-spankbangbackup')->hourly();
        $schedule->command('hanime1:update-spankbangerrors')->hourly();
        $schedule->command('hanime1:update-youjizz')->cron('0 */4 * * *');
        $schedule->command('hanime1:upload-rule34')->hourly()->between('6:00', '21:00');
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

    /**
     * Get the timezone that should be used by default for scheduled events.
     *
     * @return \DateTimeZone|string|null
     */
    protected function scheduleTimezone()
    {
        return 'Asia/Taipei';
    }
}
