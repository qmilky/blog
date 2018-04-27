<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;
use Liyu\Signature\Facade\Signature;

class VerifySignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        //暂时关闭签名校验

        Log::info('验签', [$request]);

//        $systemOs = config('app.env');/*development或者production*/
        $systemOs = 'production';

        $verifySign = $request->get('verify_sign', true);

        if (($systemOs == 'development' || $systemOs == 'dev') && $verifySign == 'false') {
            Log::info('不验证签名',[$verifySign,$systemOs]);
            return $next($request);
        }
        Log::info('验证签名',[$verifySign,$systemOs]);

        $appId = 'worker';
//        $appId = $request->get('app_id');

        $secretKey = config('signature.sign_key.' . $appId);

        if (!$secretKey) {
            $resp = [
                'error' => 1,
                'msg' => 'app_id不正确',
            ];

            return response()->json($resp);
        }
        /*生成签名，app端生成*/
        $sign = Signature::signer('hmac')
            ->setAlgo('sha256')
            ->setKey($secretKey)
            ->sign([
                'app_id' =>$appId,
                'app_ver' => 111,
                'device_id' => 111,
                'device_os' => 111,
                'device_ver' => 111,
                'timestamp' => time(),
            ]);
//        $sign = $request->get('sign');  /*获取签名*/
        $data = $request->all();
        Log::info('验签', $data);

        $signData = [
//            'app_id' => $request->get('app_id'),
//            'app_ver' => $request->get('app_ver'),
//            'device_id' => $request->get('device_id'),
//            'device_os' => $request->get('device_os'),
//            'device_ver' => $request->get('device_ver'),
//            'timestamp' => $request->get('timestamp'),
            'app_id' =>$appId,
            'app_ver' => 111,
            'device_id' => 111,
            'device_os' => 111,
            'device_ver' => 111,
            'timestamp' => time(),
        ];
        $pass = Signature::setAlgo('sha256')
            ->setKey($secretKey)
            ->verify($sign, $signData);
        Log::info('验签111', [$pass]);

        if (!$pass) {
            $resp = [
                'error' => 1,
                'msg' => '签名错误',
            ];

            return response()->json($resp);
        }

        return $next($request);
    }
}
