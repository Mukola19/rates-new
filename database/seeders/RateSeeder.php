<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        function generateDateRange(Carbon $start_date, Carbon $end_date)
        {
            $dates = [];
            for ($date = $start_date->copy(); $date->lte($end_date); $date->addMinutes(5)) {
                $dates[] = $date->format('Y-m-d H:i');
            }

            return $dates;
        }


        $dates = generateDateRange(Carbon::now()->subMonths(2), Carbon::now());

        foreach ($dates as $key => $date) {
            DB::table('rates')->insert([
                'sale' => rand(35, 45) + rand(0, 10) / 10,
                'purchase' => rand(35, 45) + rand(0, 10) / 10,
                'bank_id' => rand(1, 3),
                'currency_id' => rand(1, 2),
                'created_at' => $date,
                'updated_at' => $date,
            ]);
        }
    }
}
