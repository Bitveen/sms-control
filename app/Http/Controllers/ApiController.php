<?php namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Laracurl;
use App\Message;

class ApiController extends Controller
{


    public function __construct()
    {
        $this->login = "bitveen";
        $this->password = md5("maksimusv1");
    }

    /* Получение всех сообщений */
    public function messages()
    {
        $response = Laracurl::get('https://smsc.ru/sys/get.php?get_answers=1&login='.$this->login.'&psw='.$this->password.'');
        return response()->json(Message::parse($response));
    }

}
