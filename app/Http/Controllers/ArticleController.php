<?php

namespace App\Http\Controllers;

use App\Article;
use App\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class ArticleController extends Controller
{
    public function single(Article $article){
        Redis::incr("views.$article->id}.articles");
        $comments = $article->comments()->where('approved',1)->
        where('parent_id',0)->latest()->with('comments')->get();

        return view('Home.article' , compact('article','comments'));
    }
}
