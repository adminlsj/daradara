<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
<<<<<<< HEAD
	protected $toTruncate_array = ['comments', 'company_imgs', 'companies', 'saved_jobs', 'jobs'];

    protected $toTruncate_string = 'comments, company_imgs, companies, saved_jobs, jobs';

    /**
     * Run the database seeds.
=======
    /**
     * Seed the application's database.
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
     *
     * @return void
     */
    public function run()
    {
<<<<<<< HEAD
    	DB::statement('TRUNCATE '.$this->toTruncate_string.' ;');
        foreach ($this->toTruncate_array as $table) {
            DB::statement('ALTER SEQUENCE '.$table.'_id_seq RESTART WITH 1;');
        }
    	
        $this->call(CompaniesTableSeeder::class);
        $this->call(JobsTableSeeder::class);
=======
        // $this->call(UsersTableSeeder::class);
>>>>>>> 66270956aa8ff1aadc870cf50685126f1bc1e11c
    }
}
