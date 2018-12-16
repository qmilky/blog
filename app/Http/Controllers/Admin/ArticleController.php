<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\WebSocket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\CateArticle;
use App\Entities\Article;
use App\Validators\ArticleValidator;
use App\Events\TestEvent;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;
use DB;
class ArticleController extends Controller
{
    public  function articleAdd(Request $request,CateArticle $cateArticle)
    {
        if($request->method()=='POST'){
           $data = $request->except(['_token','file_upload']);
            /*表单验证*/
//            dd($data);
          $validator = ArticleValidator::verifyCreateArticle($data);
//          dd($validator);
          if($validator !== true){   /*此处必须是不全等于，！=是不行的*/
//              throw new \Exception($validator);
              return redirect('admin/article/create')
                  ->withErrors($validator)
                  ->withInput();
          };
          $data['art_time']=date('Y-m-d H:i:s',time());
           $res = app(Article::class)->create($data);
           if($res){
               $list_key = 'LIST:ARTICLE';
               //每篇文章信息
               $hash_key = 'HASH:ARTICLE';
               Redis::del($list_key);
               Redis::del($hash_key.'*');
               return redirect('admin/article/list')->with('msg','文章添加成功');
           }else{
               return redirect('admin/article/')->with('msg','文章添加失败')->withInput();
           }
        }
        $cates=  CateArticle::tree();

        return view('admin.article.article_add',compact('cates'));
    }
    public  function  articleList(Request $request)
    {

        /*
         * redis 的使用，提高查询速度；
         * 使用队列和hash两种方式模拟关系型数据存储及获取
         * 队列用来存储的文章的id
         * hash用来存储文章。
         * 判断当前所需的文字列表数据是否存在redis中，存在则使用redis中的数据，不存在则查询数据库将查询结果存入redis，下次访问直接从redis中读取
         * */
        //所有文章id
        $list_key = 'LIST:ARTICLE';
        //每篇文章信息
        $hash_key = 'HASH:ARTICLE';
//        Redis::del($list_key);   //测试用
//        Redis::del($hash_key.'*');
        if(!Redis::exists($list_key)){
            //若要执行分页该如何操作？？？，若要用laravel自带的分页，存入hash的数据必须是集合，但hash中无法存储集合。
            $article = Article::with([
                'cates'=>function($query){
                    return $query->select('id','cate_name');
                }
            ])->get();
             $article->each(function($v){
               $v->transform();
            });
            $articles = $article->toArray();
//           $articles = Article::get()->toArray();
                foreach($articles as $k=>$v){
                    $articles[$k]['cate_name']=$v['cates']['cate_name'];
                    unset($articles[$k]['cates']);
                }
            $art_ids = array_column($articles,'id');
                Redis::rpush($list_key,$art_ids);
                //遍历将文章信息写入hash表
                foreach($art_ids as $k=>$v){
                    //hmset()中值value即$articles[$k]只能是一维数组，不能是二维。value值类型也不能为集合collection否则报错ERR wrong number of arguments for 'hmset' command。
                    Redis::hmset($hash_key.$v,$articles[$k]);
                }
        }
        // 从Redis中获取需要的文字信息
        $arts= [];
        //redis 中获取所有文章的id；
        $artids = Redis::lrange($list_key,0,-1);
        foreach($artids as $m=>$n){
            $arts[] = Redis::hgetall($hash_key.$n) ;
        };
      //相关文章的处理。
//      $arts->each(function($v){
//          $v->art_links = explode(';',$v->art_link);
//          $arr=[];
//           foreach($v->art_links as $m=>$n){
//               //list()函数，相当于下面的赋值，[$m]必须加。
//               list($arr[$m]['url'],$arr[$m]['name'])=explode('@@',$n);
////               $arr[$m]['url']=$a[0];
////               $arr[$m]['name']=$a[1];
//           }
//          $v->art_links = $arr;
//      });
//        dd($arts);
        //选择分类参数：
        $cates = CateArticle::tree();
//        view()->share('cates', $cates);
        return  view('admin.article.article_list',compact('arts','request','cates'));
    }
    //文章状态修改
    public function articleStatus(Request $request)
    {
        try{
            $status = $request->get('status');
            $id = $request->get('art_id');
            if($status==1){
                $sta=0;
                $text='禁用';
            };
            if($status==0){
                $sta=1;
                $text='启用';
            }

            $res = Article::where('id',$id)->update(['status'=>$sta]);

            Log::info('文章状态修改结果',[$res]);
            if($res){
                $list_key = 'LIST:ARTICLE';
                //每篇文章信息
                $hash_key = 'HASH:ARTICLE';
                Redis::del($list_key);
                Redis::del($hash_key.'*');
                $msg='文章已经'.$text.'成功';
                return redirect('admin/article/list')->with('msg',$msg);
            }

        }catch (\Exception $e){
            Log::error('文章修改异常',[$e]);
            return back()->with('msg','文章修改异常');
        }

    }

    //文章编辑
    public function  articleEdit($id, Request $request)
    {
        if($request->method()=='POST'){
            try{

                $data['cate_id']            = $request->get('cate_id');
                $data['art_title']          = $request->get('art_title');
                $data['art_editor']         = $request->get('art_editor');
                $data['art_thumb']          = $request->get('art_thumb');
                $data['art_tag']            = $request->get('art_tag');
                $data['art_description']    = $request->get('art_description');
                $data['art_content']        = $request->get('art_content');
                $data['art_link']        = $request->get('art_link');
                /*表单验证*/
//            dd($data);
                $validator = ArticleValidator::verifyCreateArticle($data);
//          dd($validator);
                if($validator !== true){   /*此处必须是不全等于，！=是不行的*/
//              throw new \Exception($validator);
                    return back()
                        ->withErrors($validator)
                        ->withInput();
                };
                //文章修改时间
                $data['edit_time']=date('Y-m-d H:i:s',time());

                $res = Article::where('id',$id)->update($data);

                if($res){
                    //此步是为了同步redis和mysql中的数据。
                    $list_key = 'LIST:ARTICLE';
                    $hash_key = 'HASH:ARTICLE';
                    Redis::del($list_key);
                    Redis::del($hash_key.'*');
                    return redirect('admin/article/list')->with('msg','文章修改成功');
                }else{
                    return back()->with('msg','文章修改失败')->withInput();
                }

            }catch(\Exception $e){
                Log::error('修改文章失败',[$e]);
            }
        }
        $cates=  CateArticle::tree();
       $art =  Article::where('id',$id)->first();

        return view('admin.article.article_edit',compact('art','cates'));

    }
   

//相关文章
public function artsLink()
{
    $arts = app(Article::class)->get();

        $arts->each(function($v){
            if(isset($v->art_link)){
                $v->art_links = explode(';',$v->art_link);
                $arr=[];
                foreach($v->art_links as $m=>$n){
                    //list()函数，相当于下面的赋值，[$m]必须加。
                   if(strpos($n,'@@')!==false){  //此处判断$n中是否包含‘@@’字符，若包含则执行下面的代码，防止报错。
                       list($arr[$m]['url'],$arr[$m]['name'])=explode('@@',$n);
                   }
//               $arr[$m]['url']=$a[0];
//               $arr[$m]['name']=$a[1];
                }
                $v->art_links = $arr;
            }

        });
//    dd($arts);
    return  view('admin.article.arts_link',compact('arts'));
}

//文章列表搜索
public function searchArticles(Request $request)
{
    $art_title = $request->get('art_title');
    $cate_id = $request->get('cate_id');
    DB::enableQueryLog();
    // 无法实现：
//    if(!empty($cate_id)) {
//        $article = Article::with([
//            'cates' => function ($query) use ($cate_id) {
//                return $query->where('id',$cate_id)
//                    ->orwhere(['cate_pid' => $cate_id])
//                    ->select('id', 'cate_name');
//            }
//        ])
////        ->where('art_title','like','%'.$art_title.'%')
//            ->get();
//    }
    $cate_ids=[]; //避免只有文章标题时，$cate_ids未定义报错。
    if(!empty($cate_id)){
        $cate_ids = CateArticle::where('cate_pid' ,$cate_id)->get()->toArray();
        $cate_ids = array_column($cate_ids,'id');
        $cate_ids = array_merge($cate_ids,[$cate_id]);  //将一级分类合并入数组。
    }
    //多条件关联查询
        $article = Article::with(['cates'=>function($query){
            return $query->select('id','cate_name');  //此处仅为分类名的关联查询
        }])
        ->where(function($query)use($art_title,$cate_ids,$cate_id){
                if(!empty($art_title)){
                     $query->where('art_title','like','%'.$art_title.'%');
                }
                if(!empty($cate_ids)) {
                    $query->whereIn('cate_id', $cate_ids);
                }
            })->get();
    $sql = DB::getQueryLog();
    Log::info('关联查询sql',[$sql]);
    $article->each(function($v){
        $v->transform();
    });
    $arts = $article->toArray();
    foreach($arts as $k=>$v){
        $arts[$k]['cate_name']=$v['cates']['cate_name'];
        unset($arts[$k]['cates']);
    }
    $cates = CateArticle::tree();
    return  view('admin.article.article_list',compact('arts','request','cates'));
}

//文章删除
public function artDel(Request $request)
{
    $id = $request->get('id');

    DB::enableQueryLog();
    $res = app(Article::class)->find($id)->delete();
    $sql = DB::getQueryLog();
    Log::info('删除文章',[$sql]);
    if($res){
        $data=[
          'error'=>0,
          'msg' =>'删除成功'
        ];
        return $data;
    }
    $datas=[
        'error'=>1,
        'msg' =>'删除失败'
    ];
    return $datas;
}

//测试===================
    public function vue()
    {
        return view('admin.vue.vue');
    } 
    public function axios(Request $request)
    {
       $data =  $request->all();
//       dd($data);
       return $this->response(0,'请求成功',$data);
    }

    //测试通过队列发送长链接
    public  function  jobSwoole(Request $request)
    {
        $data = $request->get('message');
        //添加到时间监听event Listeners
        event(new TestEvent($data));
//        $job = (new WebSocket($data))->onQueue(config('queue.queue_default'));
//        $res = dispatch($job);
//        if($res){
//            return back();
//        };
        //重要！！！！！！
        return back();

    }
//    public  function eventListener()
//    {
//
//    }
}
