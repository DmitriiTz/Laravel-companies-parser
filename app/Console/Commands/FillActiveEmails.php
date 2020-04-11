<?php

namespace App\Console\Commands;

use App\ActiveEmail;
use Illuminate\Console\Command;
use ValidateRequests;

class FillActiveEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fill:emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fill active emails';

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

        $dbname = 'laraTransfer';

        $Connect = mysqli_connect(env('DB_HOST'), env('DB_USERNAME'), env('DB_PASSWORD'));
        mysqli_query($Connect,"TRUNCATE $dbname.active_emails;");
        $CompaniesQuery=mysqli_query($Connect,"SELECT * FROM $dbname.companies WHERE status='Подключен' AND sender<>'Y' AND agent_buisnes<>'Y';");
        $CompaniesQueryCount=mysqli_num_rows($CompaniesQuery);
        if ($CompaniesQueryCount!=0) {
            echo "Companies: $CompaniesQueryCount \n";
            while ($CompanyData=mysqli_fetch_assoc($CompaniesQuery)) {
                $ID=$CompanyData['id'];
                $email_bill = $CompanyData['email_bill'];
                if (filter_var($email_bill, FILTER_VALIDATE_EMAIL)){
                    mysqli_query($Connect,"INSERT INTO $dbname.active_emails (type,email,sended) VALUES ('','$email_bill','0');");
                }
                $email = $CompanyData['email'];
                if (filter_var($email, FILTER_VALIDATE_EMAIL)){
                    mysqli_query($Connect,"INSERT INTO $dbname.active_emails (type,email,sended) VALUES ('','$email','0');");
                }

                $ContactsQuery=mysqli_query($Connect,"SELECT * FROM $dbname.contacts WHERE company_id='$ID' AND (email LIKE '%@%') AND send='Да';");
                $ContactsQueryCount=mysqli_num_rows($ContactsQuery);
                if ($ContactsQueryCount!=0) {
                    while ($ContactData=mysqli_fetch_assoc($ContactsQuery)) {
                        $type=$ContactData['division'];
                        $email=$ContactData['email'];
                        if (filter_var($email, FILTER_VALIDATE_EMAIL)){
                            mysqli_query($Connect,"INSERT INTO $dbname.active_emails (type,email,sended) VALUES ('$type','$email','0');");
                        }
                    }
                }
            }
        }

        $emails = ActiveEmail::get();

        foreach ($emails as $key => $email){
            $count = ActiveEmail::whereEmail($email->email)->count();
            if($count > 1){
                ActiveEmail::whereEmail($email->email)->offset(1)->limit(9999999)->delete();
                $this->info('Удалено: '. $count);
            }
        }
    }
}



