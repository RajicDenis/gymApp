<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TrainersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trainers')->insert([
        	'name' => 'Alex',
        	'email' => 'alex@gmail.com',
        	'created_at' => Carbon::now()->format('Y-m-d'),
        	'updated_at' => Carbon::now()->format('Y-m-d')
        ]);

        DB::table('trainers')->insert([
        	'name' => 'Jack',
        	'email' => 'jack@gmail.com',
        	'created_at' => Carbon::now()->format('Y-m-d'),
        	'updated_at' => Carbon::now()->format('Y-m-d')
        ]);
    }
}
