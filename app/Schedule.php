<?php namespace App;

use DB;
use Carbon\Carbon;

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

    public static function getBreaksByDate($date)
    {
        $query = "SELECT * FROM breaks WHERE start_date BETWEEN ? AND (? + INTERVAL 1 DAY) ORDER BY start_date";
        return DB::select($query, [
            $date,
            $date
        ]);

    }




}
