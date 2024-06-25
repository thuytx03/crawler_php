<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index(){
            $name='thuy';
            getMyNameThuy($name);
         $html=file_get_html('https://vnexpress.net/thoi-su');
         echo $html;
    }
}
