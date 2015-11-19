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


    public function getBreaks(Request $request)
    {
        if ($request->has('subscriber')) {
            $dayToShow = Carbon::createFromFormat('d.m.Y', $request->input('dayToShow'))->toDateString();
            return response()
                ->json(Schedule::getBreaksByIdAndDate($request->input('subscriber'), $dayToShow));
        } else {
            return response()->json(['status' => 'all']);
        }

    }




}
