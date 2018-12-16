<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


/**
 * @SWG\Swagger(
 *
 *     produces={"application/json"},
 *     @SWG\Info(
 *         version="0.0.1",
 *         title="博客之家",
 *         description="公共参数 <br> app_id = shifu <br>app_ver = v1 <br> device_id <br>device_os <br> device_ver <br>sign <br>timestamps",
 *         @SWG\Contact(name="qiyamin@xiaobaiyoupin.com", url="http://www.bai.com/")
 *     ),
 *     @SWG\Definition(
 *         definition="Error",
 *         required={"error", "msg"},
 *         @SWG\Property(
 *             property="error",
 *             type="integer",
 *             format="int32"
 *         ),
 *         @SWG\Property(
 *             property="msg",
 *             type="string"
 *         ),
 *         @SWG\Property(
 *             property="data",
 *             type="object"
 *         ),
 *     ),
 *      @SWG\Parameter(
 *         type="string",
 *         in="query",
 *         name="verify_sign",
 *         type="string",
 *         description="是否验证签名",
 *         default="false",
 *         required=true,
 *     ),
 *     @SWG\SecurityScheme(
 *       securityDefinition="jwt",
 *       type="apiKey",
 *       in="header",
 *       name="Authorization"
 *     )
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function response($error, $msg, $data = null)
    {
        $output = [
            'error' => $error,
            'msg'   => $msg,
            
        ];
        if (!is_null($data)) {
            $output['data'] = $data;
        }
        return response()->json($output);
    }
    public function ex_response($ex, $code, $msg)
    {
        $code = $ex->getCode() ? $ex->getCode() : $code;
        $msg = $ex->getMessage() ? $ex->getMessage() : $msg;

        $output = [
            'error' => $code,
            'msg'   => $msg,
        ];

        return response()->json($output);
    }



}
