<?php

namespace App;
use App\Role;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    //do this to fix mass assignment issue abd process daTA TO DB
    protected $fillable = [
        'name', 'email', 'password', 'role_id', 'photo_id', 'is_active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){

        return $this->belongsTo('App\Role');
    }

    public function photo(){
        return $this->belongsTo('App\Photo');
    }

    public function SetPasswordAttribute($password){
        if(!empty($password)){
            $this->attributes['password'] = bcrypt($password);
            // $this->attributes['password'] = \Hash::make($password);
        }
    }

    public function isAdmin(){

        // We can use role as a property here because its up . so we use role-> instead of role()
        if($this->role->name == "administrator" && $this->is_active == 1){
            // if($this->role['name'] == "administrator" && $this->is_active == 1){

            return true;
        }

        return false;   

    }

    public function posts(){
         
        return $this->hasMany('App\Post');
    }

}
