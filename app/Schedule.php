<?php namespace App;

use DB;
use Carbon\Carbon;


/**
 * Класс-модель для управления графиком
 *
 * Class Schedule
 * @package App
 */
class Schedule {


    /**
     * Метод для получения всех записей о перерывах в указанный день для указанного пользователя
     *
     * @param $id
     * @param $date
     * @return mixed
     */
    public static function getBreaksByIdAndDate($id, $date)
    {
        $query = "SELECT * FROM breaks WHERE subscriber_id=? AND start_date BETWEEN ? AND (? + INTERVAL 1 DAY) ORDER BY start_date";
        return DB::select($query, [
            $id,
            $date,
            $date
        ]);

    }

    /**
     * Получить все перерывы для каждого пользователя в определенный день
     *
     * @param $date
     * @return mixed
     */
    public static function getBreaksByDate($date)
    {
        $query = "SELECT * FROM breaks WHERE start_date BETWEEN ? AND (? + INTERVAL 1 DAY) ORDER BY start_date";
        return DB::select($query, [
            $date,
            $date
        ]);

    }

    /**
     * Обновить дату и время перерыва
     *
     * @param $id
     * @param $startDate
     * @param $endDate
     * @return mixed
     */
    public static function updateBreakById($id, $startDate, $endDate)
    {
        return DB::table('breaks')->where('id', '=', $id)->update([
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }


    public static function getBreaks()
    {
        return DB::table('breaks')->select('*')->orderBy('start_date', 'asc');
    }


    public static function createBreak($subscriber, $startDate, $endDate)
    {
        return DB::table('breaks')->insert([
            'subscriber_id' => $subscriber,
            'start_date' => $startDate,
            'end_date' => $endDate
        ]);
    }

    public static function getBreaksById($id)
    {
        return DB::table('breaks')->where('subscriber_id', '=', $id)->select('*')->get();
    }


    public static function getBreak($id)
    {
        return DB::table('breaks')->join('subscribers', 'subscribers.id', '=', 'breaks.subscriber_id')
            ->select('subscribers.first_name', 'subscribers.last_name', 'subscribers.middle_name', 'breaks.id', 'breaks.start_date', 'breaks.end_date')
            ->where('breaks.id', '=', $id)
            ->get()[0];
    }

}
