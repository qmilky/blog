<?php

namespace App\Http\Controllers\NemoxSms;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Nexmo\Client;
use Yunpian\Sdk\YunpianClient;
class SmsController extends Controller
{
   public  function sendsms()
   {
       $nemox_key = config('nexmo.nemox_key');
       $nemox_secret = config('nexmo.nemox_secret');
       $basic  = new \Nexmo\Client\Credentials\Basic($nemox_key, $nemox_secret);
       $client = new \Nexmo\Client($basic);
       $message  =  $client -> message()-> send([
           'to'=>8615210643471,
           'from' => 'nexmo',
           'brand' => 'A text message sent using the Nexmo SMS API'
       ]);

       if($message){
           echo '发送成功，请稍等！！！';
           dd($message);
       }
   }
   public  function  ypSendsms()
   {
       $apikey = config('yp.yp_apikey');
       $clnt  =  YunpianClient :: create($apikey);
       $param  = [ YunpianClient::MOBILE  => '15210643471',YunpianClient::TEXT  =>  '您的验证码是8965 ' ];
        $r  =  $clnt -> sms()-> single_send($param);
        dd($r);
       if($r -> isSucc()){
        dd($r-> data());
       }
   }
}
