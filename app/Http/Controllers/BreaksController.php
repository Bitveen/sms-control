<?php namespace App\Http\Controllers;

use App\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Schedule;
use Validator;
use Carbon\Carbon;
use Session;

class BreaksController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showForm(Request $request)
    {
        if ($request->user()->role == 'user') {
            return redirect()->back();
        }
        $subscribers = Subscriber::all();
        return view('breaks.create')->with('subscribers', $subscribers);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'startDate'  => 'required',
            'endDate'    => 'required',
            'startTime'  => 'required|regex:/^[0-9]{2}:[0-9]{2}$/',
            'endTime'    => 'required|regex:/^[0-9]{2}:[0-9]{2}$/',
            'subscriber' => 'required'
        ]);

        if ($validator->fails()) {
            Session::flash('breakCreateError', 'Ошибка при добавлении перерыва');
            return redirect()->back();
        }


        $subscriber = $request->input('subscriber');
        $startDate = Carbon::createFromFormat('d.m.Y H:i', $request->input('startDate').' '.trim($request->input('startTime')));
        $endDate = Carbon::createFromFormat('d.m.Y H:i', $request->input('endDate').' '.trim($request->input('endTime')));


        if (Schedule::createBreak($subscriber, $startDate, $endDate)) {
            return redirect('/subscribers/'.$subscriber);
        } else {
            Session::flash('breakCreateError', 'Ошибка при добавлении перерыва');
            return redirect()->back();
        }
    }


    public function view($id, Request $request)
    {
        if ($request->user()->role == 'user') {
            return redirect()->back();
        }
        $breakItem = Schedule::getBreak($id);

        if (!$breakItem->end_date) {
            $breakItem->end_date = Carbon::now('Europe/Moscow');
        } else {
            $breakItem->end_date = Carbon::parse($breakItem->end_date);
        }
        $breakItem->start_date = Carbon::parse($breakItem->start_date);

        return view('breaks.view')->with('breakItem', $breakItem);

    }

    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'startDate'  => 'required',
            'endDate'    => 'required',
            'startTime'  => 'required|regex:/^[0-9]{2}:[0-9]{2}$/',
            'endTime'    => 'required|regex:/^[0-9]{2}:[0-9]{2}$/'
        ]);

        if ($validator->fails()) {
            Session::flash('breakUpdateError', 'Ошибка при обновлении перерыва');
            return redirect()->back();
        }


        $requestedStartDate = $request->input('startDate').' '.trim($request->input('startTime')).':00';
        $requestedEndDate = $request->input('endDate').' '.trim($request->input('endTime')).':00';


        $startDate = Carbon::createFromFormat('d.m.Y H:i:s', $requestedStartDate)->toDateTimeString();
        $endDate = Carbon::createFromFormat('d.m.Y H:i:s', $requestedEndDate)->toDateTimeString();


        if (Schedule::updateBreakById($id, $startDate, $endDate)) {
            Session::flash('breakUpdateSuccess', 'Обновлено');
            return redirect()->back();
        } else {
            Session::flash('breakUpdateError', 'Ошибка при обновлении перерыва');
            return redirect()->back();
        }
    }




}
