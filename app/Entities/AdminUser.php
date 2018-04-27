<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
//use Illuminate\Auth\Authenticatable;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
class AdminUser extends Model  implements AuthenticatableContract,JWTSubject
{
    public $table = 'admin_user';
    public $primaryKey = 'id';
    public $guarded = [];
    public $timestamps = false;



        /*继承接口所需要实现的抽象方法*/
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    public  function getAuthIdentifierName()
    {

    }
    public  function getAuthIdentifier()
    {

    }
    public  function getAuthPassword()
    {
        return $this->password;
    }
    public  function getRememberToken()
    {

    }
    public  function setRememberToken($value)
    {

    }
    public  function getRememberTokenName()
    {

    }
}
