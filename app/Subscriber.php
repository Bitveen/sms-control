<?php namespace App;

use DB;
use Carbon\Carbon;

class Subscriber {

    public static function create($firstName, $lastName, $middleName, $phoneNumber)
    {
        return DB::table('subscribers')->insert([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'middle_name' => $middleName,
            'phone_number' => $phoneNumber,
            'reg_date' => Carbon::now('Europe/Moscow')
        ]);
    }

    public static function update()
    {

    }
    public static function drop()
    {

    }

    public static function all()
    {
        return DB::table('subscribers')->select('*')->get();
    }


}
