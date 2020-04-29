<?php

namespace App\Providers;

use App\Comment;
use App\Payment;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Validator::extend('recaptcha', function ($attribute, $value, $parameters, $validator){
            $client = new GuzzleHttp\Client();
            $response = $client->request('POST', 'https://www.google.com/recaptcha/api/siteverify', [
                'secret' => config('services.recaptcha.secret'),
                'response' => $value,
                'remoteip' => request()->ip()
            ]);
            $response = json_decode($response->getBody());
            return $response->success;
        });
        view()->composer('Admin.section.header' , function($view) {
            $commentUnsuccessfulCount = Comment::whereApproved(0)->count();
            $commentSuccessCount = Comment::whereApproved(1)->count();

            $paymentUnsuccessfulCount = Payment::wherePayment(0)->count();
            $paymentSuccessCount = Payment::wherePayment(1)->count();
            $view->with([
                'commentUnsuccessfulCount' => $commentUnsuccessfulCount,
                'commentSuccessfulCount' => $commentSuccessCount,
                'paymentSuccessCount' => $paymentSuccessCount,
                'paymentUnsuccessfulCount' => $paymentUnsuccessfulCount,
            ]);
        });
    }
}
