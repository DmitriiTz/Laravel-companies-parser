<?php

namespace App\Console\Commands;

use App\Address;
use App\Company;
use App\Contact;
use App\Link;
use Illuminate\Console\Command;
use Ixudra\Curl\Facades\Curl;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\DomCrawler\Crawler;

class ParsCompany extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser:companies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsing companies company';

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
        $links = Link::all();

        $this->line('');
        $this->info('Парсим ссылки на компании');
        $this->info('');
        foreach ($links as $company_id => $link) {
            $this->info('');
            $this->info('ID Link: '.$link->id);

            $company_dataSet = [];
            $address_dataSet = [];
            $contact_dataSet = [];

            $url = env('PARS_HOST') . $link->link;
            $name = env('PARS_NAME');
            $password = env('PARS_PASS');

            $html = Curl::to($url)
                ->withData(['login' => $name, 'password' => $password])
                ->post();

            $crawler = new Crawler(null, $url);
            $crawler->addHtmlContent($html, 'windows-1251');

            $data['Company'] = $this->filters($crawler, 2, false, true);
            $data['Address'] = $this->filters($crawler, 3, true);
            $data['Contact'] = $this->filters($crawler, 4, true);

            foreach ($data as $key => $relation) {
                $this->info('Name Relation: '.$key);
                if ($key === 'Company') {
                    $model = new Company();
                    array_unshift($relation, $link->id);
                    $columns = $model->getFillable();
                    $company_dataSet[] = array_combine($columns, $relation);
                }
                if ($key === 'Address') {
                    foreach ($relation as $item) {
                        $model = new Address();
                        $item[0] = $link->id;
                        $columns = $model->getFillable();
                        $address_dataSet[] = array_combine($columns, $item);
                    }
                }
                if ($key === 'Contact') {
                    foreach ($relation as $item) {
                        $model = new Contact();
                        array_pop($item);
                        $item[0] = $link->id;
                        $columns = $model->getFillable();
                        $contact_dataSet[] = array_combine($columns, $item);
                    }
                }
            }
            Company::insert($company_dataSet);
            Address::insert($address_dataSet);
            Contact::insert($contact_dataSet);
        }
        $this->line('');
    }

    private function filters($crawler, $eq, $shifty = false, $column = false)
    {
        $data = $crawler->filter('.centermid')->eq($eq)->filter('tr')->each(function ($tr) {
            return $tr->filter('td')->each(function ($td, $i) {
                return $this->checks($td);
            });
        });

        if ($shifty === true) {
            array_shift($data);
            array_pop($data);
        }

        if ($column === true) {
            $data = array_column($data, 1);
        }
        $data = array_slice($data, 0, 17);
        return $data;
    }

    private function checks($td)
    {
        if ($td->filter('option[selected]')->text() !== null) {
            return $td->filter('option[selected]')->text();
        }
        if ($td->filter('input')->attr('value') !== null) {
            if ($td->filter('input')->attr('type') !== 'hidden') {
                return $td->filter('input')->attr('value');
            }
        }
        if (strlen($td->text()) >= 225) {
            return ' ';
        }
        return $td->text();

    }
}



