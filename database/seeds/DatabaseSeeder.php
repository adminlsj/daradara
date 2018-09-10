<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	protected $toTruncate_array = ['comments', 'company_imgs', 'companies', 'saved_jobs', 'jobs'];

    protected $toTruncate_string = 'comments, company_imgs, companies, saved_jobs, jobs';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('TRUNCATE '.$this->toTruncate_string.' ;');
        foreach ($this->toTruncate_array as $table) {
            DB::statement('ALTER SEQUENCE '.$table.'_id_seq RESTART WITH 1;');
        }
    	
        $this->call(CompaniesTableSeeder::class);
        $this->call(JobsTableSeeder::class);
    }
}
