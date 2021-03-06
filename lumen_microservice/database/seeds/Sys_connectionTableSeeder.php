<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Sys_connectionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sys_connection')->insert([
            [
	        	'sys_key' => 'E541FF22F1F472485DE39DF102F06B7F',
	            'sys_secret' => 'C3461D9EA0450F45EFFF09FAD686EDA4',
	            'sys_access_token' => 'BCE3414EB0DC00D57181F4BDBD49709C',
	        	'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
	        	'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
			]
    	]);
    }
}
