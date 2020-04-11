<?php

namespace App\Console\Commands;

use App\Link;
use Illuminate\Console\Command;
use Ixudra\Curl\Facades\Curl;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\DomCrawler\Crawler;

class ParsLink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'parser:links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parsing link company';

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
        $url = env('PARS_LINK');
        $name = env('PARS_NAME');
        $password = env('PARS_PASS');

        $html = Curl::to($url)
            ->withData(['login' => $name, 'password' => $password])
            ->post();

        $crawler = new Crawler(null, $url);
        $crawler->addHtmlContent($html, 'windows-1251');

        $table = $crawler->filter('.lgreytable')->filter('tr')->each(function ($tr) {
            return $tr->filter('td')->each(function ($td) {
                return $td->text();
            });
        });

        array_shift($table);

        $this->line('');
        $this->info('Парсим ссылки на компании');

        $dataSet = [];
        foreach ($table as $key => $item) {
            $item[0] = substr($item[0], 2);
            $item[1] = substr($item[1], 2);
            $url = "?pid=397&module_mode=open&url_fav=1&company_id=$item[0]";

            $dataSet[] = [
                'company_id' => $item[0],
                'name' => $item[1],
                'link' => $url
            ];
            $this->info('Ок :' . $item[1]);
        }
        Link::insert($dataSet);
    }
}



