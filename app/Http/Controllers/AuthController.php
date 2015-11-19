<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthController extends Controller {

    public function index()
    {
        if (Auth::check()) {
            return redirect('/schedule');
        } else {
            return redirect('/login');
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
            Session::flash('loginError', 'Неправильно указан логин или пароль.');
            return redirect()->back();
        }

    }

    public function logout()
    {
        try {
            if (!Auth::check()) {
                abort(404);
            }
            Auth::logout();
            return redirect('/login');
        } catch (HttpException $e) {
            return view('404');
        }



    }




}
