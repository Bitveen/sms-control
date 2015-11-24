<?php namespace App\Http\Controllers;

use App\Subscriber;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


/**
 * Класс-контроллер для управления графиком
 *
 * Class ScheduleController
 * @package App\Http\Controllers
 */
class ScheduleController extends Controller {

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Собственно, график
     *
     * @return $this
     */
    public function index()
    {
        $subscribers = Subscriber::all();
        return view('schedule')->with('subscribers', $subscribers);
    }

    public function parseMessage(Request $request) {}


}
