<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Article;
use App\Entities\CateArticle;

class CommonController extends Controller
{
    public function __construct()
    {

        //        1 导航栏目  数量7  $navs
//        $navs = Nav::take(7)->get();
        $cates = CateArticle::where('cate_pid',0)->get();
        //        4 最新文章 数量8 $news
        $news = Article::orderBy('art_time','desc')->where('status',1)->take(8)->get();

//        5 单击排行  数量5 $hots
        $hots = Article::orderBy('art_view','desc')->where('status',1)->take(5)->get();

        //
//        view()->share('navs', $navs);
        view()->share('news', $news);
        view()->share('hots', $hots);
        view()->share('cates', $cates);
    }
}
