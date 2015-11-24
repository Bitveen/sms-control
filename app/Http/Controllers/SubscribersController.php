<?php namespace App\Http\Controllers;

use App\Schedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Subscriber;
use Validator;
use Session;


/**
 * Класс-контроллер для управления подписчиками
 *
 * Class SubscribersController
 * @package App\Http\Controllers
 */
class SubscribersController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Список всех подписчиков
     *
     * @return $this
     */
    public function index()
    {
        $subscribers = Subscriber::all();
        return view('subscribers.list')->with('subscribers', $subscribers);
    }

    /**
     * Создание нового подписчика
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName'   => 'required|min:3|max:255',
            'lastName'    => 'required|min:3|max:255',
            'middleName'  => 'required|min:3|max:255',
            'phoneNumber' => 'required|unique:subscribers,phone_number|regex:/^7[0-9]{10}$/'
        ]);

        if ($validator->fails()) {
            Session::flash('subscriberCreateError', 'Возникла ошибка при создании пользователя.');
            return redirect()->back();
        }

        $firstName   = $request->input('firstName');
        $lastName    = $request->input('lastName');
        $middleName  = $request->input('middleName');
        $phoneNumber = $request->input('phoneNumber');

        if (Subscriber::create($firstName, $lastName, $middleName, $phoneNumber)) {
            Session::flash('subscriberCreateSuccess', 'Пользователь успешно создан.');
            return redirect('/subscribers');
        } else {
            Session::flash('subscriberCreateError', 'Возникла ошибка при создании пользователя.');
            return redirect()->back();
        }
    }


    /**
     * Показать форму для создания подписчика
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showForm()
    {
        return view('subscribers.create');
    }


    /**
     * Просмотр одного подписчика, с возможностью редактирования
     *
     * @param $id
     * @return $this
     */
    public function view($id)
    {
        $subscriber = Subscriber::get($id);
        if (!$subscriber) {
            abort(404);
        }
        $breaks = Schedule::getBreaksById($id);


        for ($i = 0; $i < count($breaks); $i++) {
            $breaks[$i]->start_date = Carbon::parse($breaks[$i]->start_date);
            $breaks[$i]->end_date = Carbon::parse($breaks[$i]->end_date);
        }


        return view('subscribers.view')->with('subscriber', $subscriber)->with('breaks', $breaks);
    }


    /**
     * Обновление информации о подписчике
     *
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstName'   => 'required|min:3|max:255',
            'lastName'    => 'required|min:3|max:255',
            'middleName'  => 'required|min:3|max:255',
            'phoneNumber' => 'required|regex:/^7[0-9]{10}$/'
        ]);

        if ($validator->fails()) {
            Session::flash('subscriberUpdateError', 'Ошибка при обновлении информации о пользователе.');
            return redirect()->back();
        }

        $firstName   = $request->input('firstName');
        $lastName    = $request->input('lastName');
        $middleName  = $request->input('middleName');
        $phoneNumber = $request->input('phoneNumber');


        if (!Subscriber::update($id, $firstName, $lastName, $middleName, $phoneNumber)) {
            Session::flash('subscriberUpdateError', 'Ошибка при обновлении информации о пользователе.');
            return redirect()->back();
        }
        Session::flash('subscriberUpdateSuccess', 'Сохранено.');
        return redirect('/subscribers');
    }



}
