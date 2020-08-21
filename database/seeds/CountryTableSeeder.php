<?php

use Illuminate\Database\Seeder;

class CountryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		\DB::table('countries')->insert(array (
			0 =>
			array (
				'id' => '30',
				'iso' => 'BR',
				'name' => 'Brasil',
				'iso3' => 'BRA',
				'numcode' => '76',
				'phonecode' => '55',
				'status' => 0,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s')
			)
		));
    }
}
