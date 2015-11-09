<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;

class AuthController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            redirect('/schedule');
        } else {
            redirect('/login');
        }
    }

    public function form()
    {
        return view('login');
    }

    public function authenticate(Request $request)
    {
        if (Auth::attempt($request->only('login', 'password'))) {
            return redirect('/schedule');
        } else {
            Session::flash('loginError', 'Не правильно указан логин или пароль.');
            return redirect()->back();
        }



    }




}
