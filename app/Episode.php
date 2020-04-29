<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    protected $guarded = [];

    protected $casts = [

    ];

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function path()
    {
        return "course/{$this->course->slug}/episode/{$this->number}";
    }
}
