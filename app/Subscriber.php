<?php namespace App;

use DB;
use Carbon\Carbon;

/**
 * Класс-модель для управления подписчиками
 *
 * Class Subscriber
 * @package App
 */
class Subscriber {

    /**
     * Создание нового подписчика
     *
     * @param $firstName
     * @param $lastName
     * @param $middleName
     * @param $phoneNumber
     * @return mixed
     */
    public static function create($firstName, $lastName, $middleName, $phoneNumber)
    {
        return DB::table('subscribers')->insert([
            'first_name'   => $firstName,
            'last_name'    => $lastName,
            'middle_name'  => $middleName,
            'phone_number' => $phoneNumber,
            'reg_date'     => Carbon::now('Europe/Moscow')
        ]);
    }


    /**
     * Удаление нового подписчика
     *
     * @param $id
     * @return mixed
     */
    public static function drop($id)
    {
        return DB::table('subscribers')->where('id', '=', $id)->delete();
    }


    /**
     * Получить всех подписчиков
     *
     * @return mixed
     */
    public static function all()
    {
        return DB::table('subscribers')->select('*')->get();
    }


    /**
     * Получить одного подписчика
     *
     * @param $id
     * @return mixed
     */
    public static function get($id)
    {
        return DB::table('subscribers')->where('id', '=', $id)->select('*')->get()[0];
    }


    /**
     * Обновить существующего подписчика
     *
     * @param $id
     * @param $firstName
     * @param $lastName
     * @param $middleName
     * @param $phoneNumber
     * @return mixed
     */
    public static function update($id, $firstName, $lastName, $middleName, $phoneNumber)
    {
        return DB::table('subscribers')->where('id', '=', $id)->update([
            'first_name'   => $firstName,
            'last_name'    => $lastName,
            'middle_name'  => $middleName,
            'phone_number' => $phoneNumber
        ]);
    }

    public static function getByPhoneNumber($phoneNumber)
    {
        return DB::table('subscribers')->where('phone_number', '=', $phoneNumber)->select('*')->get()[0];
    }

}
