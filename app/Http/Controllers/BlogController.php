<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class BlogController extends Controller
{
    public $id;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showArticles($id)
    {
        $this->id = $id;
        $storage = Redis::connection();
        if ($storage->zscore('articleViews', 'article: ' . $id)) {
            $storage->pipeline(function ($pipe) {
                $pipe->zincrby('articleViews', 1, 'article: '. $this->id);
                $pipe->incr('article:' . $this->id . ':views');
            });
        } else {
            $views = $storage->incr('article:' . $this->id . ':views');
            $storage->zincrby('articleViews', $views, 'article: '. $this->id);
        }

        $views = $storage->get('article:' . $id . ':views');

        return 'This is an article with id: ' . $id . ' it has ' . $views . ' views';
    }
}
