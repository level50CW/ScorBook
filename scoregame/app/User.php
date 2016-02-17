<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $timestamps = false;
    protected $primaryKey = 'iduser';
    protected $fillable = [
        'Firstname', 'Lastname', 'Email', 'Password', 'role', 'code', 'remember_token'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'Password',
    ];

    public function getAuthPassword()
    {
        return $this->Password;
    }

//    public function getAuthIdentifierName()
//    {
//        return 'Email';
//    }

//    public function getAuthIdentifier()
//    {
//        return $this->Email;
//    }




//    public function getAuthPassword()
//    {
//        return Hash::make($this->Password);
//    }

    public function team()
    {
        return $this->hasOne('Models\Team','idteam','Teams_idteam');
    }
}
