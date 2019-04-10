<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    //

  
    protected $uploads = '/images/';

    protected $fillable = ['path'];


    // we get an accessor so we dont have to whrite /images/ in path or src 
    public function getPathAttribute($photo){

        // return uploads and concatinate it with photo
        return $this->uploads . $photo;
    }

    // public function posts(){

    //     return $this->hasMany('App\Photo');
    // }
}
