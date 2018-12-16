<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
//use Illuminate\Auth\Authenticatable;
//use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
//引入此trait可以实现该接口Illuminate\Contracts\Auth\Authenticatable中的所有方法，无需再在下面的类中重写。
use Illuminate\Auth\Authenticatable;
class AdminUser extends Model  implements AuthenticatableContract,JWTSubject
{
    //重要！！！免去6个繁琐方法的实现，因为该trait中已经实现过了，一般trait才在类内use引入。
    use Authenticatable;
    public $table = 'admin_user';
    public $primaryKey = 'id';
    public $guarded = [];
    public $timestamps = false;



        /*继承接口JWTSubject所需要实现的抽象方法*/
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
    //继承接口AuthenticatableContract所需要实现的所有方法
//    public  function getAuthIdentifierName()
//    {
//
//    }
//    public  function getAuthIdentifier()
//    {
//
//    }
//    public  function getAuthPassword()
//    {
//        return $this->password;
//    }
//    public  function getRememberToken()
//    {
//
//    }
//    public  function setRememberToken($value)
//    {
//
//    }
//    public  function getRememberTokenName()
//    {
//
//    }
}
