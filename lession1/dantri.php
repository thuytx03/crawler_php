<?php 

require_once('./simple_html_dom.php');
$content=file_get_html('https://dantri.com.vn/the-thao.htm');
// $content->find('.article .article-item')->find('.article-content .article-title .dt-text-black-mine',0)->plaintext;
$posts=$content->find('.article .article-item');
if(!empty($posts)){
    foreach($posts as $item){
        // plaintext : lấy ra nội dung text (chỉ lấy text)
        // innertext : lấy ra nội dung của thẻ html (lấy cả html )
        // outertext: lấy cả nội dung và thẻ đang selector 
        $title=$item->find('.article-content .article-title',0)->plaintext ?? '';
        $title_html=$item->find('.article-content .article-title ',0)->innertext ?? '';
        $title_outer=$item->find('.article-content .article-title ',0)->outertext ?? '';
        echo $title .'<br/>';
        // var_dump($title_html);
        // var_dump($title_outer);
        // $link=$item->find('.article-content .article-title a',0)->href;
        // $data_attr=$item->{"data-content-target"};
        // echo $data_attr;
    }
}