<?php

namespace App\Http\Controllers;

use App\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScheduleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $subscribers = Subscriber::all();
        return view('schedule')->with('subscribers', $subscribers);
    }

    public function draw(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $subscriber = $request->input('subscriber');


        //нарисовать картинку


    }


}
