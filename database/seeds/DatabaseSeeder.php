<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'login' => 'admin',
            'password' => bcrypt('secret'),
            'role' => 'admin'
        ]);

        DB::table('users')->insert([
            'login' => 'secretary',
            'password' => bcrypt('secret'),
            'role' => 'user'
        ]);


        // DB::table('subscribers')->insert([
        //     'first_name' => 'Иван',
        //     'last_name' => 'Иванов',
        //     'middle_name' => 'Иванович',
        //     'phone_number' => '7823434234',
        //     'reg_date' => Carbon\Carbon::now()
        // ]);


    }
}
