<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\CateArticle;
use App\Entities\Article;
use App\Validators\ArticleValidator;
class ArticleController extends Controller
{
    public  function articleAdd(Request $request,CateArticle $cateArticle)
    {
        if($request->method()=='POST'){
           $data = $request->except(['_token','file_upload']);
            /*表单验证*/

          $validator = ArticleValidator::verifyCreateArticle($data);
//          dd($validator);
          if($validator !== true){   /*此处必须是不全等于，！=是不行的*/
//              throw new \Exception($validator);
              return redirect('admin/article/create')
                  ->withErrors($validator)
                  ->withInput();
          };
           $res = app(Article::class)->create($data);
           if($res){
               return redirect('admin/article/list')->with('msg','文章添加成功');
           }else{
               return redirect('admin/article/')->with('msg','文章添加失败')->withInput();
           }
        }
        $cates=  CateArticle::tree();
        return view('admin.article.article_add',compact('cates'));
    }
    public  function  articleList()
    {
        //关联查询所有的用with（）；若只是已知一个查多个则直接用关联方法
      $arts = app(Article::class)->with([
          'cates'=>function($query){
          return $query->select('cate_id','cate_name');
          }
      ])->paginate(5);
        return  view('admin.article.article_list',compact('arts'));
    }


    public function vue()
    {
        return view('admin.vue.vue');
    } 
    public function axios(Request $request)
    {
       $data =  $request->all();
       return $this->response(0,'请求成功',$data);
    }
}
