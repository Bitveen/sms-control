<?php namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Session;
use Symfony\Component\HttpKernel\Exception\HttpException;


class AuthController extends Controller {

    /**
     * Обработка перехода на корень сайта
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function index()
    {
        if (Auth::check()) {
            return redirect('/schedule');
        } else {
            return redirect('/login');
        }
    }

    /**
     * Показать форму входа на сайт
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function form()
    {
        return view('login');
    }


    /**
     * Авторизация на сайте
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function authenticate(Request $request)
    {
        if (Auth::attempt($request->only('login', 'password'))) {
            return redirect('/schedule');
        } else {
            Session::flash('loginError', 'Неправильно указан логин или пароль.');
            return redirect()->back();
        }

    }


    /**
     * Завершение сессии и выход с сайта
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
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
