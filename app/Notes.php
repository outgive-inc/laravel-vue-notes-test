<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

    protected $fillable = [
        'title', 'content'
    ];

    protected $dates = ['created_at'];

}
