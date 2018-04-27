<?php

namespace App\Validators;
//use \Prettus\Validator\Contracts\ValidatorInterface;
//use \Prettus\Validator\LaravelValidator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
class ArticleValidator
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

    public static function verifyCreateArticle($data)
    {
        $rules = [
            'cate_id' => 'required',
            'art_title' => 'required',
            'art_content' => 'required',
        ];
        $msgs = [
            'cate_id.required' => '请选择文章分类',
            'art_title.required'  => '文章标题必须填写',
            'art_content.required' => '文章内容必须填写',

        ];
        $validator = Validator::make($data, $rules, $msgs);
        if (!$validator->passes()) {
            $message = $validator->getMessageBag();
//            $message = $validator->getMessageBag()->first();
            Log::error($message);
            return $message;
        }
        return true;
    }
}
