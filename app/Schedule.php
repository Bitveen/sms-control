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




}
