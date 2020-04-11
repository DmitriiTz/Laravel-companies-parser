<?php

namespace App\Console\Commands;

use App\ActiveEmail;
use Illuminate\Console\Command;

class sendMails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sending mails to company';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $emails = ActiveEmail::where('sended', 0)->get();
        //$emails = ['email' => 'd.cibulsky@oyster-telecom.ru']
;        $data['pathToImage'] = storage_path('app/izv.jpg');
        foreach ($emails as $key => $email) {
            \Mail::send('email_izv', $data, function ($message) use ($email) {
                $message->from('info@oy2b.ru', 'Info department');
                $message->to($email->email)->subject('Извещение от 26.03.2020');
            });
            if (\Mail::failures()) {
                $this->info('не отправлено: ' . $email->email);
            } else {
                ActiveEmail::whereId($email->id)->update(['sended' => 1]);
                $this->info('Отправлено: ' . $email->email . ' ID: ' . $email->id);
            }
        }
    }
}



