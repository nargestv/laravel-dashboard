<?php

namespace App\Http\Controllers\Admin;

use App\Article;
use Illuminate\Http\Request;
use App\Http\Requests\ArticleRequest;

class ArticleController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articles = Article::latest()->paginate(20);

        return view('Admin.articles.all' , compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Admin.articles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ArticleRequest $request)
    {
        auth()->loginUsingId(1);
        $input = $request->all();
        $images = ($request->file('images'));
      //  dd(json_decode($request->file('images')));
        /*
            dd($input['title']);
             $imagesUrl = $this->uploadImages($request->file('images'));
             //  auth()->user()->article()->create(array_merge($request->all() , [ 'images' => $imagesUrl]));
             auth()->user()->article()->create([
                 $key =>$value,
             ]);

        for($i=0; $i<= count($input['title']); $i++) {
            if(empty($input['title'][$i]) || !($input['title'][$i])) continue;
            $imagesUrl = $this->uploadImages($request->file('images'));
            $imagesUrl = $this->uploadImages($input[$i]['images']);
            $data = [
                'user_id' => auth()->loginUsingId(1)->id,
                'title' => $input['title'][$i],
                'description' => $input['description'][$i],
             //  'body' => $input['body'][$i],
                'tags' => $input['tags'][$i],
                'images' => $imagesUrl,
            ];

            article::create($data);
        } */
        auth()->loginUsingId(1);
        $imagesUrl = $this->uploadImages($request->file('images'));
        auth()->user()->article()->create(array_merge($request->all() , ['images' => $imagesUrl,'user_id'=> auth()->loginUsingId(1)->id]));
        return redirect(route('articles.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Article $article)
    {
        return view('Admin.articles.edit' , compact('article'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ArticleRequest|Request $request
     * @param  \App\Article $article
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(ArticleRequest $request, Article $article)
    {
        $file = $request->file('images');
        $inputs = $request->all();

        if($file) {
            $inputs['images'] = $this->uploadImages($request->file('images'));
        } else {
            $inputs['images'] = $article->images;
            $inputs['images']['thumb'] = $inputs['imagesThumb'];

        }

        unset($inputs['imagesThumb']);
        $article->update($inputs);

        return redirect(route('articles.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Article  $article
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return redirect(route('articles.index'));
    }
}
