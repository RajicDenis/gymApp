<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TimelapseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('timelapse')->insert([
        	'time' => Carbon::now()->format('Y-m-d'),
        	'created_at' => Carbon::now()->format('Y-m-d'),
        	'updated_at' => Carbon::now()->format('Y-m-d')
        ]);
    }
}
