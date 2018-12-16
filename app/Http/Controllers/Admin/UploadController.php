<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadController extends Controller
{
    public function upload(Request $request)
    {
//        获取客户端传过来的文件
        $file = $request->file('file_upload');
//        dd($file);
        $file = $file[0];
//        $file = $request->all();

        if ($file->isValid()) {
            //        获取文件上传对象的后缀名
            $ext = $file->getClientOriginalExtension();


            //生成一个唯一的文件名，保证所有的文件不重名
            $newfile = time() . rand(1000, 9999) . uniqid() . '.' . $ext;


            //设置上传文件的目录
//            $dirpath = public_path() . '/uploads/';


            //将文件移动到本地服务器的指定的位置，并以新文件名命名
//            $file->move(移动到的目录, 新文件名);
//            $file->move($dirpath, $newfile);


            //将文件移动到七牛云，并以新文件名命名
            \Storage::disk('qiniu')->writeStream('uploads/'.$newfile, fopen($file->getRealPath(), 'r'));


            //将文件移动到阿里OSS
//            OSS::upload($newfile,$file->getRealPath());


            //将上传的图片名称返回到前台，目的是前台显示图片
            return $newfile;
        }
    }
}
