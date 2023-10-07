<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies  = [
            [
                'id' => 1,
                'name' => 'Долар США',
                'code' => 'USD',
                'symbol' => '$'
            ],
            [
                'id' => 2,
                'name' => 'Євро',
                'code' => 'EUR',
                'symbol' => '€'
            ],
          
        ];



        foreach ($currencies as $currency) {
            DB::table('currencies')->insert([
                'id' => $currency['id'],
                'name' => $currency['name'],
                'code' => $currency['code'],
                'symbol' => $currency['symbol']
            ]);
        }
    }
}
