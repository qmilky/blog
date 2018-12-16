<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Article;
use App\Entities\CateArticle;
use DB;

class IndexController extends CommonController
{
    //前台首页
    public function index(Request $request)
    {
        //使用队列和hash两种方式模拟关系型数据存储及获取

        //队列用来存储存放的文章的id
//        $goodsShow = Goods::where('cate_id','=',$cate_id)
//            ->where(function($query){
//                $query->where('status','<','61')
//                    ->orWhere(function($query){
//                        $query->where('status', '91');
//                    });
//            })->first();

        //hash用来存储文章。
        $art_title = $request->get('art_title');

        //        2 图片文章  数量6 $pics
        $pics = Article::where('status',1)
            ->where(function($query)use($art_title){
                if(isset($art_title)){
                    $query->where('art_title','like','%'.$art_title.'%');
                }
            })
            ->take(5)->paginate(5);   //分页显示
        //        3 图文列表  数量5 $lists 可分页
        $lists = Article::where('status',1)
            //多条件查询。
            ->where(function($query)use($art_title){
                if(isset($art_title)){
                    $query->where('art_title','like','%'.$art_title.'%');
                }
            })
            ->paginate(5);
//        dd($lists);
        return view('home.index',compact('pics','lists','request'));
    }
    public function info($id)
    {
        $art = Article::find($id);
        //        访问量+1
        DB::table('article')->increment('art_view');
        $cateone = app(Article::class)->where('status',1)->find($id)->cates;//关联查询；
        if($cateone->cate_pid!=0){
            $catetwo = app(CateArticle::class)->find($cateone->cate_pid)->cate_name;
        }
        // 上一篇文章
        $pre =   Article::orderBy('id','desc')->where('id','<',$id)->where('status',1)->first();
        // 下一篇
        $next =  Article::orderBy('id','asc')->where('id','>',$id)->where('status',1)->first();


//      相关文章
        $simple = Article::where(['cate_id'=>$art->cate_id,'status'=>1])->take(4)->get();
        $data=[
            'art'=>$art,
            'pre'=>$pre,
            'next'=>$next,
            'simple'=>$simple,
            'cateone'=>$cateone
        ];
        //若分类只有一级无二级则走次处；
        if(isset($catetwo)){
            $data['catetwo']=$catetwo;
        }

        return view('home.info',$data);
    }

    public function lists($id)
    {
        //根据分类id获取当前分类信息
        $cate = CateArticle::find($id);

        //根据分类id获取分类下的文章
        $arts = Article::where(['cate_id'=>$id,'status'=>1])->paginate(2);

//        获取当前分类下的二级类

        $cate_two = CateArticle::where(['id'=>$id])->take(4)->get();

        return view('home.cate_lists',compact('cate','arts','cate_two'));
    }



    // 导航栏中，根据父分类找出所有子分类下的所有文章
    public function subArticle(Request $request)
    {
        try{
            $id = $request->get('id');
            $cate = CateArticle::where('id',$id)->first()->toArray();
            $sub_cates = CateArticle::where('cate_pid',$id)->get()->toArray();
            //获取数组中某一列的值；
            $cate_id = [$cate['id']];
            $sub_ids = array_column($sub_cates,'id');
            //将子分类和二级分类id合并为一个新数组id；
            $sum_ids = array_merge($cate_id,$sub_ids);
            $arts = Article::whereIn('cate_id',$sum_ids)->where('status',1)->paginate(5);
            $data['arts']=$arts;
            $data['cate']=$cate;
//            dd($data);
            return view('home.sub_articles',$data);
        }catch(\Exception $e){
            Log::error('获取子分类文章失败',[$e]);
        }

    }




}
