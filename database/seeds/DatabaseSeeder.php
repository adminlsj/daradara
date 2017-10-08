<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	protected $toTruncate_array = ['avatars', 'comments', 'order_imgs', 'trans', 'orders', 'users'];

    protected $toTruncate_string = 'avatars, comments, order_imgs, trans, orders, users';

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
    	
        $this->call(UsersTableSeeder::class);
        $this->call(OrdersTableSeeder::class);
        $this->call(OrderImgsTableSeeder::class);
        $this->call(CommentsTableSeeder::class);
    }
}
