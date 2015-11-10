<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subscriber;
use Session;

class SubscribersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $subscribers = Subscriber::all();
        return view('subscribers.list')->with('subscribers', $subscribers);
    }

    public function create(Request $request)
    {
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $middleName = $request->input('middleName');
        $phoneNumber = $request->input('phoneNumber');

        if (Subscriber::create($firstName, $lastName, $middleName, $phoneNumber)) {
            Session::flash('subscriberCreateSuccess', 'Пользователь успешно создан.');
            return redirect('/subscribers');
        } else {
            Session::flash('subscriberCreateError', 'Возникла ошибка при создании пользователя.');
            return redirect()->back();
        }



    }

    public function showForm()
    {
        return view('subscribers.create');
    }

    public function view($id)
    {
        $subscriber = Subscriber::get($id);
        return view('subscribers.view')->with('subscriber', $subscriber);
    }

    public function update($id, Request $request)
    {
        $firstName = $request->input('firstName');
        $lastName = $request->input('lastName');
        $middleName = $request->input('middleName');
        $phoneNumber = $request->input('phoneNumber');

        if (!Subscriber::update($id, $firstName, $lastName, $middleName, $phoneNumber)) {
            Session::flash('subscriberUpdateError', 'Ошибка при обновлении информации о пользователе.');
            return redirect()->back();
        }
        Session::flash('subscriberUpdateSuccess', 'Сохранено.');
        return redirect('/subscribers');
    }





}
