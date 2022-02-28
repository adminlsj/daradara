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
        'App\Console\Commands\ResetDayViews',
        'App\Console\Commands\ResetWeekViews',
        'App\Console\Commands\CheckSpankbang',
        'App\Console\Commands\CheckMotherless',

        'App\Console\Commands\UpdateXvideos',
        'App\Console\Commands\UpdateXvideosErrors',
        'App\Console\Commands\UpdateHembed',
        'App\Console\Commands\UpdateVod',
        'App\Console\Commands\UpdateYoujizz',
        'App\Console\Commands\UpdateSpankbang',
        'App\Console\Commands\UpdateSpankbangErrors',

        'App\Console\Commands\UpdateYoujizzDownloads',

        'App\Console\Commands\UploadNhentai',
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
        $schedule->command('hanime1:reset-day-views')->dailyAt('05:00');
        $schedule->command('hanime1:reset-week-views')->weeklyOn(1, '05:00');

        $schedule->command('hanime1:update-hembed')->hourly();
        $schedule->command('hanime1:update-vod')->hourly();
        $schedule->command('hanime1:update-xvideoserrors')->everyThirtyMinutes();
        $schedule->command('hanime1:update-youjizz')->cron('0 */6 * * *');
        $schedule->command('hanime1:update-spankbangerrors')->hourly();

        $schedule->command('hanime1:update-youjizzdownloads')->cron('0 */6 * * *');

        $schedule->command('hanime1:check-spankbang')->hourly();
        $schedule->command('hanime1:check-motherless')->cron('0 */3 * * *');
        $schedule->command('hanime1:update-youjizz')->dailyAt('12:55');

        $schedule->command('hanime1:upload-nhentai')->hourly()->between('6:00', '21:00');
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
