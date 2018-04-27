<?php

namespace App\Validators;
//use \Prettus\Validator\Contracts\ValidatorInterface;
//use \Prettus\Validator\LaravelValidator;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;

class ArticleCateValidator
//class ArticleCateValidator extends LaravelValidator
{
//    protected   $rules = [
//        ValidatorInterface::RULE_CREATE => [
//
//        ],
//        ValidatorInterface::RULE_UPDATE => [],
//    ];
//
//    protected  $messages = [
//        ValidatorInterface::RULE_CREATE => [
//
//        ],
//        ValidatorInterface::RULE_UPDATE => [],
//    ];

    public static function verifyCreateData($data)
    {
        $rules = [
            'customer_id' => 'required',
            'product_id' => 'required',
            'service_content_id' => 'required',
            'service_mode_id' => 'required',
            'level_id' => 'required',
        ];
        $msgs = [
            'customer_id.required' => '请选择客户',
            'product_id.required'  => '请选择产品',
            'service_content_id.required' => '请选择服务内容',
            'service_mode_id.required' => '请选择服务模式',
            'level_id.required' => '请选择级别',
        ];
        $validator = Validator::make($data, $rules, $msgs);
        if (!$validator->passes()) {
            $message = $validator->getMessageBag()->first();
            Log::error($message);
            return $message;
        }
        return true;
    }
}
