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
        $query = "SELECT * FROM breaks WHERE subscriber_id=? AND start_date BETWEEN ? AND (? + INTERVAL 1 DAY)";
        return DB::select($query, [
            $id,
            $date,
            $date
        ]);

    }


    public static function draw($breaks)
    {
        $width = 1013;
        $height = 500;

        $leftLineSize = 5;
        $bottomLineSize = 5;


        $blackColor = 0x000000;
        $whiteColor = 0xFFFFFF;


        $image = ImageCreateTrueColor($width, $height);


        ImageFilledRectangle($image, 0, 0, $width, $height, $whiteColor);
        ImageFilledRectangle($image, 0, 0, $leftLineSize, $height - 15, $blackColor);
        ImageFilledRectangle($image, 0, ($height - 15) - $bottomLineSize, $width, $height - 15, $blackColor);


        $piece = ($width - $leftLineSize) / 24;



        for ($i = 0; $i < count($breaks); $i++) {

            //$hour = Carbon::parse($breaks[$i]->start_date)->hour;


            ImageString($image, 2, 0, $height - 15, $piece, $blackColor);

        }


        header('Content-Type: image/png');
        ImagePNG($image);


    }



}
