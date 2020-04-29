<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class ActivationCode extends Model
{
    protected $fillable =['user_id','code','used', 'expire'];

    public function scopeCreateCode($query, $user){
        $code = $this->code();
        return $query->create([
            'user_id'=>$user->id,
            'expire' => Carbon::now()->addMinutes(15),
            'code'=> $code,
        ]);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    private function code(){
        do{
            $code = Str::random(60);
            $checkCode = static::whereCode($code)->get();
        }while(!$checkCode->isEmpty());

        return $code;
    }
}
