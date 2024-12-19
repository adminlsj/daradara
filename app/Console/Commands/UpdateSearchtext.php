<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Anime;

class UpdateSearchtext extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daradara:update-searchtext';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update search text';

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
        // Update anime search text
        $animes = Anime::all();
        foreach ($animes as $anime) {
            $searchtext = $anime->title_zht.'|'.$anime->title_zhs.'|'.$anime->title_jp.'|'.$anime->title_en.'|'.$anime->title_ro.'|'.$anime->season.'|'.$anime->category.'|'.$anime->source.'|'.$anime->animation_studio.'|'.$anime->author.'|'.$anime->director;

            $anime->searchtext = mb_strtolower(preg_replace('/\s+/', '', $searchtext), 'UTF-8');
            $anime->save();
        }

        // Update staff search text
        $staffs = Staff::all();
        foreach ($staffs as $staff) {
            $searchtext = $staff->name_zht.'|'.$staff->name_zhs.'|'.$staff->name_jp.'|'.$staff->name_en;
            $staff->searchtext = mb_strtolower(preg_replace('/\s+/', '', $searchtext), 'UTF-8');
            $staff->save();
        }

        // Update character search text
        $characters = Character::all();
        foreach ($characters as $character) {
            $searchtext = $character->name_zht.'|'.$character->name_zhs.'|'.$character->name_jp.'|'.$character->name_en;
            $character->searchtext = mb_strtolower(preg_replace('/\s+/', '', $searchtext), 'UTF-8');
            $character->save();
        }

        // Update company search text
        $companies = Company::all();
        foreach ($companies as $company) {
            $searchtext = $company->name_zht.'|'.$company->name_zhs.'|'.$company->name_jp.'|'.$company->name_en;
            $company->searchtext = mb_strtolower(preg_replace('/\s+/', '', $searchtext), 'UTF-8');
            $company->save();
        }
    }
}
