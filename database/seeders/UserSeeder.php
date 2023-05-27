<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert(
        // [
        //     'UserID'=>'jeet6662',
        //     'Name'=>'Subhajeet Paul',
        //     'User_Type'=>'Admin',
        //     'Email'=>'',
        //     'Username'=>'root',
        //     'Password'=>Hash::make('root'),
        //     'ImageURl'=>''
        // ],
        [
            'UserID'=>'23FM8956',
            'Name'=>'Subhajeet Paul',
            'User_Type'=>'Fund Manager',
            'Email'=>'',
            'Username'=>'jeet',
            'Password'=>Hash::make('Fgdre#32'),
            'ImageURL'=>''
        ]
    );
    }
}
