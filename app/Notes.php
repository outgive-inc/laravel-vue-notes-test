<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notes extends Model
{
    public function user(){
        return $this->belongsTo('App\User');
    }

   /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'content'
    ];

    protected $dates = ['created_at'];


}
