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
        'App\Console\Commands\UpdateVideos',
        'App\Console\Commands\UpdateData',
        'App\Console\Commands\UpdateSpankbang',
        'App\Console\Commands\UpdateYoujizz',
        'App\Console\Commands\UpdateSlutload',
        'App\Console\Commands\UploadVideos',
        'App\Console\Commands\UploadYongjiu',
        'App\Console\Commands\UploadAgefans'
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('laughseejapan:update-videos')->dailyAt('16:30');
        $schedule->command('laughseejapan:update-data')->dailyAt('05:00');
        $schedule->command('laughseejapan:update-spankbang')->cron('0 */3 * * *');
        $schedule->command('laughseejapan:update-youjizz')->cron('0 */6 * * *');
        $schedule->command('laughseejapan:update-slutload')->everyThirtyMinutes();
        $schedule->command('laughseejapan:upload-videos')->hourly()->unlessBetween('2:00', '9:00');
        $schedule->command('laughseejapan:upload-yongjiu')->everyThirtyMinutes()->unlessBetween('3:00', '8:00');
        $schedule->command('laughseejapan:upload-agefans')->everyMinute()->unlessBetween('3:00', '8:00');
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
