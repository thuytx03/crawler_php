<?php

namespace App\Console\Commands\Crawler;

use Illuminate\Console\Command;

class CrawlerComicCommand extends Command
{

    protected $signature = 'comic:init';
    protected $description = 'Comic Crawler Initial';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->init();
    }

    protected function init()
    {
        $this->getDetailComicBySlug();
    }

    protected function getDetailComicBySlug()
    {
        $linkContent = 'https://nettruyenviet.com/truyen-tranh/toan-dan-chuyen-chuc-ngu-long-su-la-chuc-nghiep-yeu-nhat';
        $html = file_get_html($linkContent);
        $content = $html->find('#item-detail');
        $comic = [];
        foreach ($content as $key => $item) {
            $nameComic = $item->find('h1', 0)->plaintext ?? '';
            $imgElement = $item->find('div.detail-info > div > div.col-xs-4.col-image > img', 0) ?? '';

            if ($imgElement && is_object($imgElement)) {
                // $this->warn("--Image Element HTML: " . $imgElement->outertext);
                $avatarComicSrc = $imgElement->getAttribute('data-cfsrc') ?? '';
                $avatarComicAlt = $imgElement->alt ?? '';
            }
            $authorComic = trim($item->find('div.detail-info > div > div.col-xs-8.col-info > ul > li.author.row > p.col-xs-8', 0)->plaintext) ?? '';
            $statusComic = trim($item->find('div.detail-info > div > div.col-xs-8.col-info > ul > li.status.row > p.col-xs-8', 0)->plaintext) ?? '';
            $descriptionComic = $item->find('div.detail-content > div > div:nth-child(1)', 0)->plaintext ?? '';

            // Lấy danh sách thể loại
            $categoryElements = $item->find('div.detail-info > div > div.col-xs-8.col-info > ul > li.kind.row > p.col-xs-8 > a');
            $categories = [];
            foreach ($categoryElements as $cate) {
                $categoryName = trim($cate->plaintext) ?? '';
                $categoryHref = $cate->href ?? '';
                $categories[] = [
                    'name' => $categoryName,
                    'link' => $categoryHref
                ];
            }

            //Lấy list chapter
            $rowChapterElements=$item->find('#nt_listchapter > nav > ul > li');


            $chapters=[];
            foreach($rowChapterElements as $chapter){
                $chapterElements=$chapter->find('div.col-xs-5.chapter > a',0);
                $timeChapterElemt=$chapter->find('div.col-xs-4.no-wrap.small.text-center',0);
                $chapters[] = [
                    'id'=>$chapterElements->getAttribute('data-id') ?? '',
                    'name' => trim($chapterElements->plaintext) ?? '',
                    'link' => $chapterElements->href ?? '',
                    'time'=>$timeChapterElemt->plaintext ?? '',
                ];
            }
            $this->warn("--Tên: " . $nameComic);
            $this->warn("--URL Ảnh: " . $avatarComicSrc);
            $this->warn("--Ảnh Alt: " . $avatarComicAlt);
            $this->warn("--Tác giả: " . $authorComic);
            $this->warn("--Tình trạng: " . $statusComic);

            // $this->warn("--Mô tả: " . $descriptionComic);

            // In ra thể loại cùng với href
            foreach ($categories as $category) {
                $this->warn("--Thể loại: " . $category['name'] . " (Link: " . $category['link'] . ")");
            }
            $comic[] = [
                'name' => $nameComic,
                'avatar_url' => $avatarComicSrc,
                'avatar_alt' => $avatarComicAlt,
                'author' => $authorComic,
                'status' => $statusComic,
                'categories' => $categories,
                'chapters'=> $chapters,
                'description' => $descriptionComic
            ];
            dd($comic);
        }
    }
}
