<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    Route::get('api/content', ['middleware' => 'laravel.jwt', 'uses' => 'ContentController@content']);
  //  return $request->user();
    Route::post('register', 'AuthController@register');
    Route::post('login', 'AuthController@login');
    Route::get('logout', 'AuthController@logout');
    Route::get('user', 'AuthController@getAuthUser');
});*/
Route::group(['prefix'=>'v1', 'namespace'=>'Api\v1'], function (){
    Route::get('articles', 'ArticleController@articles');
    Route::post('comment' , 'ArticleController@comment');
    Route::post('login' , 'UserController@login');
    Route::middleware('auth:api')->group(function(){
        Route::get('/user', function (Request $request) {
            return auth()->user();
        });
    });
});
Route::post('register', 'AuthController@register');
Route::post('login', 'AuthController@login');
Route::get('logout', 'AuthController@logout');
Route::get('user', 'AuthController@getAuthUser');
