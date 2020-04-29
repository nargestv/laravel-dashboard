<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Validator;

/*Route::get('/', function () {
    $redis = Redis::connection();
    Redis::incr('visit');
   return Redis::get('visit');
   //  return view('home');
    //$user = \App\User::find(2);
  //  event(new \App\Events\ArticleEvent($user));
   // return view('Home.index');
});*/

Route::get('/', 'HomeController@index')->name('home');
Route::get('/articles', 'ArticleController@index');
Route::get('/courses', 'CourseController@index');
Route::get('/article/{articleSlug}', 'ArticleController@single');
Route::get('/course/{courseSlug}', 'CoursesController@single');
Route::post('/comment', 'HomeController@comment');

Route::get('/user/active/email/{token}', 'UserController@activation')->name('activation.account');

Route::group(['namespace' => 'Admin','middleware'=>['auth:web'],'prefix' => 'admin'/*, 'as' => 'admin.'*/], function () {

    Route::get('/panel', 'PanelController@index')->name('index');
    Route::post('/panel/upload-image', 'PanelController@uploadImageSubject');
    Route::resource('articles' , 'ArticleController');
    Route::resource('courses' , 'CoursesController');
    // Comment Section
    Route::get('comments/unsuccessful', 'CommentController@unsuccessful');
    Route::resource('comments', 'CommentController');
    // Payment Section
    Route::get('payments/unsuccessful' , 'PaymentController@unsuccessful');
    Route::resource('payments' , 'PaymentController');

    Route::resource('episodes' , 'EpisodeController');
    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');

    Route::group(['prefix'=>'users'], function (){
        Route::get('/', 'UserController@index');
        Route::resource('level', 'LevelManageController', ['parameters'=> ['level'=>'user']]);
        Route::delete('/{user}/destroy', 'UserController@destroy')->name('users.destroy');
    });
});

Route::group(['namespace'=>'Auth'], function () {
    // Authentication Routes...
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    //login and register with google
    Route::get('login/google', 'LoginController@redirectToProvider');
    Route::get('login/google/callback', 'LoginController@handleProviderCallback');

    Route::get('logout', 'LoginController@logout')->name('logout');
    // Registration Routes...
    Route::get('register', 'RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'RegisterController@register');
    // ResetPassword Routes...
    Route::get('password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', 'ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', 'ResetPasswordController@reset')->name('password.update');

});
Route::get('/getData', function () {
    validator::make(request()->all(),[
        'g-recaptcha-response'=>'required'
    ]);
    if (\validator()->failed()){
        return 'fail';
    }
    return request('message');
});
Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
//Route::get('/getPhoto', 'PhotoController@index');
/*Route::get('/register', function () {
   // alert()->success('Success Message', 'Optional Title');
    //  alert('<a href="#">Click me</a>')->html()->persistent("No, thanks");
  //  return redirect('/');
});*/
