@extends('layouts.home')
@section('title','blog首页')
@section('keywords','blog')
@section('content')
    {{--//引入css样式，否则分页样式出不来--}}
    <link href="{{asset('home/css/style.css')}}" rel="stylesheet">
    <div class="banner">
        <section class="box">
            <ul class="texts">
                <p>有些人没有见过汪洋，以为江河最为壮美；</p>
                <p>而有些人通过一片落叶，却能看到整个秋天。</p>
                <p>行万里路，才能见天地之广阔！</p>
            </ul>
            <div class="avatar"><a href="#"><span>Qym-Blog</span></a> </div>
        </section>
    </div>
    <div class="template">
        <div class="box">
           <form action="{{url('/')}}" method="get">
               <span class="input-group-addon">
                   <i class="fa fa-search"></i>
                   <input type="text" value="{{$request->art_title}}" placeholder="请输入文章标题" name="art_title"/>
               </span>
               <button type="submit">查询</button>
           </form>
            <ul>
                @foreach($pics as $v)
                    <li><a href="{{url('info/'.$v->id)}}"  target="_blank"><img src="{{$v->art_thumb}}"></a><span>{{$v->art_title}}</span></li>
                @endforeach
            </ul>
        </div>
    </div>
    <article>
        <h2 class="title_tj">
            <p>文章<span>推荐</span></p>
        </h2>
        <div class="bloglist left">

            @foreach($lists as $k=>$v)

                <h3>{{$v->art_title}}</h3>
                <figure><img src="{{$v->art_thumb}}"></figure>
                <ul>
                    <p>{{$v->art_description}}</p>
                    <a title="{{$v->art_title}}" href="{{url('info/'.$v->id)}}" target="_blank" class="readmore">阅读全文>></a>
                </ul>
                <p class="dateview"><span>&nbsp;{{$v->art_time}}</span><span>作者：{{$v->art_editor}}</span><span>文章分类：[<a href="{{url('lists/'.$v->cate_id)}}">文章分类</a>]</span></p>
{{--                <p class="dateview"><span>{{date('Y-m-d H:i:s',$v->art_time)}}</span><span>作者：{{$v->art_editor}}</span><span>文章分类：[<a href="{{url('lists/'.$v->cate_id)}}">文章分类</a>]</span></p>--}}

            @endforeach
                <div class="blank"></div>
                <div class="ad">
{{--                    <img src="{{url('images/ad.png')}}">--}}
                </div>
                <div class="page">
                    <ul class="pagination">
                        {{--<li class="disabled"><span>«</span></li> <li class="active"><span>1</span></li><li>--}}
                        {{--<a href="http://blog.hd/admin/article?page=2">2</a></li> --}}
                        {{--<li><a href="http://blog.hd/admin/article?page=2" rel="next">»</a></li>--}}
                        {{--//此处appends()中是除了$atrs外无额外参数的分页--}}
                        {{--                    {!! $arts->appends(['cate'=>$cate,'id'=>$cate['id']])->render() !!}--}}
                        {{--{{dd($lists)}}--}}
                        {{$lists->appends(['pics'=>$pics])->links()}}
                    </ul>
                </div>
        </div>

        <aside class="right">
            <div class="weather">
                <iframe width="250" scrolling="no" height="60" frameborder="0" allowtransparency="true" src="http://i.tianqi.com/index.php?c=code&id=12&icon=1&num=1"></iframe>
            </div>
            <div class="news">
                @parent
                <h3 class="links">
                    <p>友情<span>链接</span></p>
                </h3>
                <ul class="website">
                    <li><a href="http://www.spicezee.com/chaxun/beijing/">中国社保网</a></li>
                    <li><a href="http://laravelacademy.org/tags/laravel">Laravel学院</a></li>
                    <li><a href="https://cs.laravel-china.org/">laravel速查表</a></li>
                    <li><a href="http://php.net/manual">php手册</a></li>
                    <li><a href="http://jqweui.com/">jQuery WeUI</a></li>
                    <li><a href="https://laravel-china.org/docs">PHP/laravel社区文档</a></li>
                    <li><a href="http://php.net/docs.php">PHP函数查询</a></li>
                    <li><a href="https://www.dnspod.cn/Login">DNSPOD域名解析</a></li>
                    <li><a href="https://github.com/search?l=JavaScript&q=stars%3A%3E2000&type=Repositories">github</a></li>
                    <li><a href="http://www.markdown.cn/">Markdown</a></li>
                </ul>
                {{--<ul class="website">--}}
                    {{--@foreach($links as $v)--}}
                        {{--<li><a href="{{$v->link_url}}">{{$v->link_name}}</a></li>--}}
                    {{--@endforeach--}}
                {{--</ul>--}}
            </div>
            {{--<!-- Baidu Button BEGIN -->--}}
            {{--<div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>--}}
            {{--<script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script> --}}
            {{--<script type="text/javascript" id="bdshell_js"></script> --}}
            {{--<script type="text/javascript">--}}
            {{--document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)--}}
            {{--</script> --}}
            {{--<!-- Baidu Button END -->   --}}
        </aside>
    </article>
@endsection

