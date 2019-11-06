<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class WelcomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        $storage = Redis::connection();
        $popular = $storage->zrevrange('articleViews', 0, -1);

        foreach ($popular as $value) {
            $id = str_replace('article:', '', $value);
            echo 'Article ' . $id . ' is popular' . '<br>';
        }
    }
}
