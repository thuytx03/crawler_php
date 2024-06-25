<?php

namespace App\Console\Commands\Crawler;

use Illuminate\Console\Command;

class CrawlerDataCommand extends Command
{

    protected $signature = 'crawler:init';
    protected $description = 'Crawler';

    public function handle()
    {
        $this->init();
    }
    protected function init()
    {
        $this->crawlerCategory();
        $this->crawlerTop10NetTruyen();
    }
    protected function crawlerCategory()
    {
        $linkContent = 'https://truyenfull.vn';

        $this->info("---Category");
        $this->warn("--Link: " . $linkContent);

        $html = file_get_html($linkContent);
        $content = $html->find('#list-index > div.col-md-4.col-truyen-side > div > div.list.list-truyen.list-cat.col-xs-12 > div.row > div>a');
        $categories = [];
        foreach ($content as $link) {
            $nameCategory = trim($link->plaintext ?? '');
            $linkCategory = $link->href ?? '';
            $categories[] = [
                'name' => $nameCategory,
                'linkCategory' => $linkCategory,
            ];
            $this->info("--Name: " . $nameCategory);
            $this->info("--Link: " . $linkCategory);
        }

        // dd($categories);die;
    }

    protected function crawlerTop10NetTruyen()
    {
        $linkContent = 'https://nettruyenviet.com/';

        $this->info("---Top 10 NetTruyen---");
        $this->warn("--Link: " . $linkContent);

        $html = file_get_html($linkContent);
        $content = $html->find('#topMonth > ul > li');
        $categories = [];

        foreach ($content as $link) {
            $nameComic = trim($link->find('div > h3 > a', 0)->plaintext ?? '');
            $linkComic = $link->find('div > h3 > a', 0)->href ?? '';

            $categories[] = [
                'name' => $nameComic,
                'linkCategory' => $linkComic,
            ];

            $this->warn("--Name: " . $nameComic);
            $this->warn("--Link: " . $linkComic);
        }

        // dd($categories);
    }
}
