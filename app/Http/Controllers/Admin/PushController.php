<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use JPush\Client;
class PushController extends Controller
{
    public function push(Request $request,Response $response)
    {
        $data= config('push.develop.users.jiguang');
        $appKey = $data['gt_appkey'];
        $masterSecret = $data['gt_mastersecret'];
        if($request->method()=='POST'){
//        $client = app('Client');
            $authorization = 'Basic ' . Base64_encode($appKey . ':' .$masterSecret);
            $client = new Client($appKey,$masterSecret);
            $push = $client->push();
//            $cid = 'abcddfg';
            $platform = array('ios', 'android');
            $alert = 'Hello JPush';
            $tag = array('tag1', 'tag2');
//            $regId = array('rid1', 'rid2');
            $ios_notification = array(
                'sound' => 'hello jpush',
                'badge' => 2,
                'content-available' => true,
                'category' => 'jiguang',
                'extras' => array(
                    'key' => 'value',
                    'jiguang'
                ),
            );

            $android_notification = array(
                'title' => 'hello jpush',
                'build_id' => 2,
                'extras' => array(
                    'key' => 'value',
                    'jiguang'
                ),
            );
            $content = 'Hello World';
            $message = array(
                'title' => 'hello jpush',
                'content_type' => 'text',
                'extras' => array(
                    'key' => 'value',
                    'jiguang'
                ),
            );

            $options = array(
                'sendno' => 100,
                'time_to_live' => 100,
                'override_msg_id' => 100,
                'big_push_duration' => 100
            );

//            $url = "https://api.jpush.cn/v3/push";
//            $base64=base64_encode("$appKey:$masterSecret");
//            $headers=array("Authorization:Basic $base64","Content-Type:application/json");
//            header('Content-type: application/json');
//            header('Authorization: '.'Basic '.$base64);
//
//            $ch = curl_init($url);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
//            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
//            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
//
//            $result = curl_exec($ch);

//            curl_close($ch);
//            dd($result) ;
//            $header=array("Authorization:Basic $base64","Content-Type:application/json");
//            return $request->header('Authorization','Basic '.$base64);
            //此处是在响应头里面加键值对
//            $response->header('Content-Type','application/json');
//
//            $ch = curl_init();
//            curl_setopt($ch, CURLOPT_URL,$url);
//            curl_setopt($ch, CURLOPT_HEADER, 0);
//            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);            //要求结果为字符串且输出到屏幕上
//            curl_setopt($ch, CURLOPT_POST, 1);                      //post提交方式
//            curl_setopt($ch, CURLOPT_HTTPHEADER,$header);           // 增加 HTTP Header（头）里的字段
////            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);        // 终止从服务端进行验证
////            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
//            $data = curl_exec($ch);
//            curl_close($ch);
            $respons = $push
//            ->setCid($cid)
            ->setPlatform($platform)
            ->setNotificationAlert('hello 粉红大猪头')
            ->addAllAudience();
//            ->addRegistrationId($regId)
//            ->iosNotification($alert, $ios_notification)
//            ->androidNotification($alert, $android_notification)
//            ->message($content, $message)
//            ->options($options);
//            ->send();
//            dd($respons);

            try {

               $result =  $respons->send();
//               dd($result);
                if($result['http_code']==200){
                    echo  '推送成功，请注意查收';
                }
            } catch (\JPush\Exceptions\JPushException $e) {
                // try something else here
//                dd(222);
                print $e;
            }
        }

        return view('admin.push.pushadd');


    }
}
