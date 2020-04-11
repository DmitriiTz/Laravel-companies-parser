<?php

namespace App\Http\Controllers;

use App\ActiveEmail;
use Mail;

class EmailController extends Controller
{
    public function sendEmail()
    {
        $emails = ActiveEmail::get();

        $data['pathToImage'] = storage_path('app/it.JPG');
        foreach ($emails as $email) {
            Mail::send('email', $data, function ($message) use ($email) {
                $message->from('sale@oy2b.ru', 'Sales department');
                $message->to($email->email)->subject('Услуга «Удаленный доступ» для ваших сотрудников');
            });
            if (Mail::failures()) {
                throw new Exception('Не удалось отправить ' . $email->id);
            } else {
                ActiveEmail::whereID($email->id)->update(['sended' => 1]);
            }
        }
    }
}
