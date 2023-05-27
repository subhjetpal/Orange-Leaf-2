<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchemeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('schemes')->insert(
            // [
            //     'SchemeID'=>'23EGD8564',
            //     'Scheme_Name'=>'Wealth Creation',
            //     'Scheme_Type'=>'Equity-Gold-Debt',
            //     'Capital'=>'80000',
            // ],
            [
                'SchemeID'=>'23TRA7546',
                'Scheme_Name'=>'Income Generate',
                'Scheme_Type'=>'Trading',
                'Capital'=>'20000',
            ]
        );
    }
}
