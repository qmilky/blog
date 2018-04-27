<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\CateArticle;
use App\Validators\ArticleCateValidator;
use Illuminate\Support\Facades\Validator;
use App\Services\ArticleCateService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class CateArticleController extends Controller
{
    public  function cates(Request $request,CateArticle $cateArticle)
    {

        if($request->method()=='POST'){
            /*表单验证*/
//          $validator = ArticleCateValidator::verifyCreateData();
            $data['cate_pid']           = $request->get('cate_pid');
            $data['cate_name']          = $request->get('cate_name');
            $data['cate_title']         = $request->get('cate_title');
            $data['cate_keywords']      = $request->get('cate_keywords');
            $data['cate_description']   = $request->get('cate_description');
            $data['cate_order']         = $request->get('cate_order');
            $rules = [
                'cate_pid' => 'required',
                'cate_name' => 'required',
                'cate_title' => 'required',
                'cate_keywords' => 'required',
                'cate_description' => 'required',
                'cate_order' => 'required',
            ];
            $msgs = [
                'cate_pid.required' => '请选择文章分类',
                'cate_name.required'  => '请选择分类名称',
                'cate_title.required' => '请填写服务分类标题',
                'cate_keywords.required' => '请填写分类关键字',
                'cate_description.required' => '请填写分类描述',
                'cate_order.required' => '请填写分类排序',
            ];
            $validator = Validator::make($data, $rules, $msgs);
            if (!$validator->passes()) {
                $message = $validator->getMessageBag()->toArray();
//                $message = $validator->getMessageBag()->first();
                Log::error($message);
                return redirect()->back()->withErrors($message)->withInput();
            }
            $res = $cateArticle->create($data);
            if($res){
                return redirect('admin/article/cates/index')->with('msg','分类添加成功');
            }else{
                return redirect()->back()->with('msg','分类添加失败');
            };
        }


        $cateOne = CateArticle::tree();
//        $cateOne = $cateArticle->where('cate_pid',0)->get();
//        dd($cateOne);
        return view('admin.article.cate_add',compact('cateOne'));
    }
    public function catesIndex()
    {
        $cates = CateArticle::tree();
        return  view ('admin.article.cate_index',compact('cates'));
    }
    public  function  delCate($id,CateArticle $articleCate)
    {

        DB::enableQueryLog();
        Log::notice('删除分类',[$id]);
       $res = $articleCate->find($id)->delete();
       $sql =DB::getQueryLog();
       $context=[
           'data'=>$res,
           'method' => __METHOD__,
       ];
       Log::notice('删除分类',$context);

       if($res){
           $data['error']=0;
           $data['msg']='删除成功';
       }else{
           $data['error']=1;
           $data['msg']='删除失败';
       }
            return $data;
    }
}
