<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks  = [
            [
                'id' => 1,
                'name' => 'privatbank',
                'display_name' => 'ПриватБанк'
            ],
            [
                'id' => 2,
                'name' => 'oschadbank',
                'display_name' => 'Ощадбанк'
            ],
            [
                'id' => 3,
                'name' => 'balance',
                'display_name' => 'Balance'
            ],
        ];



        foreach ($banks as  $bank) {
            DB::table('banks')->insert([
                'id' => $bank['id'],
                'name' => $bank['name'],
                'display_name' => $bank['display_name']
            ]);
        }
    }
}
