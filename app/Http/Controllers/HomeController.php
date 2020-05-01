<?php

namespace App\Http\Controllers;

use App\Article;
use App\Comment;
use App\Course;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     * @throws \Exception
     */
    public function index()
    {
        $locale = app()->getLocale();

        if(cache()->has('articles')) {
            $articles = cache('articles.'.$locale);
        } else {
            $articles = Article::whereLang($locale)->latest()->take(8)->get();
            cache(["articles.$locale"  => $articles] , Carbon::now()->addMinutes(10));
        }

        if(cache()->has('courses'.$locale)) {
            $courses = cache('courses'.$locale);
        } else {
            $courses = Course::latest()->take(4)->get();
            cache(['courses' => $courses] , Carbon::now()->addMinutes(10));
        }
        return view('Home.index' , compact('articles' , 'courses'));
    }

    public function comment(Request $request){
        $this->validate($request,[
            'comment'=> 'required|min:5'
        ]);

      /*  Comment::create(array_merge([auth()->user()->id(),$request->all()));*/
        auth()->user()->comments()->create($request->all());
        return back();
    }
}
