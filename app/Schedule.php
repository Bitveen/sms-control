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


    public static function drawOneSubscriber($breaks)
    {
        $width = 1032;
        $height = 100;
        $bottomLineSize = 5;

        $image = imagecreatetruecolor($width, $height);


        // Цвета
        $blackColor = imagecolorallocate($image, 0, 0, 0);
        $whiteColor = imagecolorallocate($image, 255, 255, 255);
        $greenColor = imagecolorallocate($image, 0, 255, 0);

        // Фон и нижняя линия
        imagefilledrectangle($image, 0, 0, $width, $height, $whiteColor);
        imagefilledrectangle($image, 0, ($height - 15) - $bottomLineSize, $width, $height - 15, $blackColor);



        $blockSize = $width / 24;


        // Временная шкала
        for ($i = 0; $i < 24; $i++) {
            if ($i < 10) {
                imagestring($image, 2, ($blockSize * $i), ($height - 15), '0'.$i.':00', $blackColor);
            } else {
                imagestring($image, 2, ($blockSize * $i), ($height - 15), $i.':00', $blackColor);
            }
        }


        // Строим линию временную
        for ($i = 0; $i < count($breaks); $i++) {
            $hoursCount = Carbon::parse($breaks[$i]->start_date)->hour;
            $endHour = Carbon::parse($breaks[$i]->end_date)->hour;
            $lineSize = $endHour - $hoursCount;

            //imagestring($image, 2, $blockSize * $hoursCount, 0, $endHour, $blackColor);
            imagefilledrectangle($image, $blockSize * $hoursCount, 0, $blockSize * $hoursCount + ($lineSize * $blockSize), 79, $greenColor);
        }



        header('Content-Type: image/png');
        imagepng($image);
        imagedestroy($image);

    }



}
