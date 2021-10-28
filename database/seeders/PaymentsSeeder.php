<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		for ($i = 0; $i < 1000; $i++) {
			DB::table('payments')->insert([
				'user_ref' => random_int(1, 10),
				'sum' => random_int(1, 1000) + (0.25 * random_int(1, 4)),
			]);
		}
    }
}
