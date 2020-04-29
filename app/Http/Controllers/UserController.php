<?php

namespace App\Http\Controllers;

use App\ActivationCode;
use Carbon\Carbon;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function activation($token){
        $activationCode = ActivationCode::whereCode($token)->first();
        if(!$activationCode){
            dd('not Exit');
        }

        if ($activationCode->expire > Carbon::now()){
            dd('expire');
        }
        if($activationCode->used == true){
            dd('used');
        }
        $activationCode->update([
            'used'=>true
        ]);
        $activationCode->user->update([
            'active'=>1
        ]);
        auth()->loginUsingId($activationCode->user->id);

        return redirect('/');
    }
}
