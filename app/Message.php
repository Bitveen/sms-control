<?php namespace App;



class Message {

    public $id;
    public $received;
    public $phone;
    public $message;
    public $toPhone;
    public $sent;

    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->received = $data['received'];
        $this->phone = $data['phone'];
        $this->message = $data['message'];
        $this->toPhone = $data['to_phone'];
        $this->sent = $data['sent'];
    }

    public static function parse($response)
    {
        $body = mb_convert_encoding($response->body, 'utf-8', 'windows-1251');
        $messages = explode(PHP_EOL, $body);
        $resultMessages = [];
        unset($messages[count($messages) - 1]);
        for ($i = 0; $i < count($messages); $i++) {
            $messages[$i] = explode(', ', $messages[$i]);
            for ($j = 0; $j < count($messages[$i]); $j++) {
                $messageItem = explode(' = ', $messages[$i][$j]);
                $data[$messageItem[0]] = $messageItem[1];
            }
            array_push($resultMessages, new Message($data));
        }
        return $resultMessages;
    }



}