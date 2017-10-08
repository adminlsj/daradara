<?php

use Illuminate\Database\Seeder;

class OrderImgsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	factory(App\OrderImg::class, 16)->create();
    	$orderImgs = App\OrderImg::all();
    	$index = 1;
    	foreach ($orderImgs as $key => $img) {
    		if ($key % 2 == 0) {
    			$img->order_id = $index;
    		} elseif ($key % 2 != 0) {
    			$img->order_id = $index;
    			$index++;
    		}
    		$img->filename = App\Order::$orderImgs[$key];
        	$img->save();
        }

    }
}
