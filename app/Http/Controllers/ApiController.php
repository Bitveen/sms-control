<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Schedule;
use Carbon\Carbon;
use App\Subscriber;

/**
 * Класс-контроллер для AJAX-запросов
 *
 * Class ApiController
 * @package App\Http\Controllers
 */
class ApiController extends Controller {

    /**
     * Получить все перерывы для определенного подписчика или для всех сразу
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBreaks(Request $request)
    {
        $dayToShow = Carbon::createFromFormat('d.m.Y', $request->input('dayToShow'))->toDateString();
        if ($request->has('subscriber')) {
            $subscriber = $request->input('subscriber');
            return response()->json(Schedule::getBreaksByIdAndDate($subscriber, $dayToShow));
        } else {
            return response()->json(Schedule::getBreaksByDate($dayToShow));
        }
    }


    /**
     * Обновить определенный перерыв
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateBreak($id, Request $request)
    {
        $startDate = Carbon::createFromFormat('d.m.Y H:i', $request->input('startDate'));

        if (trim($request->input('endDate')) == '-') {
            $endDate = 'NULL';
        } else {
            $endDate = Carbon::createFromFormat('d.m.Y H:i', $request->input('endDate'));
        }


        if (Schedule::updateBreakById($id, $startDate, $endDate)) {
            return response()->json([
                'start_date' => $startDate,
                'end_date' => $endDate
            ]);
        } else {
            return response()->json(['status' => 'error'], 500);
        }

    }


    /**
     * Удаление подписчика. Используется с AJAX
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function dropSubscriber(Request $request)
    {
        if (!$request->has('id')) {
            return response()->json(['status' => 'id_not_provided'], 500);
        }
        $id = $request->input('id');

        if (Subscriber::drop($id)) {
            Session::flash('subscriberDropSuccess', 'Подписчик успешно удален.');
            return response()->json(['status' => 'dropped']);
        } else {
            return response()->json(['status' => 'drop_error'], 500);
        }
    }


    public function dropBreak($id)
    {
        if (Schedule::dropBreak($id)) {
            return response()->json(['status' => 'success'], 200);
        } else {
            return response()->json(['status' => 'error'], 500);
        }
    }

    public function parseMessage(Request $request)
    {



    }


}
