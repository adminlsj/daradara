<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class ClearLaravelLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'logs:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all laravel logs';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $files = Arr::where(Storage::disk('log')->files(), function($filename) {
            return Str::endsWith($filename,'.log');
        });


        $count = count($files);

        if(Storage::disk('log')->delete($files)) {
            Log::info(sprintf('Deleted %s %s!', $count, Str::plural('file', $count)));
        } else {
            Log::info('Error in deleting log files!');
        }
    }
}
