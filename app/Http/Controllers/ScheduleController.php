<?php

namespace App\Http\Controllers;

use App\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use App\Schedule;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $subscribers = Subscriber::all();
        if ($request->getMethod() == 'POST') {
            $dayToShow = Carbon::createFromFormat('d.m.Y', $request->input('dayToShow'))->toDateString();
            return view('schedule', [
                'subscribers' => $subscribers,
                'id' => $request->input('subscriber'),
                'dayToShow' => $dayToShow
            ]);
        } else {
            return view('schedule')->with('subscribers', $subscribers);
        }
    }


    /* Метод отвечающий за отправку изображений клиенту */
    public function draw(Request $request)
    {
        $breaks = Schedule::getBreaksByIdAndDate($request->input('id'),
            $request->input('dayToShow'));
        Schedule::draw($breaks);
    }


}
