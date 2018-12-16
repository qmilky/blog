@extends('layouts.home')
@section('title')
    {{$cate->cate_keywords}}
@endsection
<link href="{{asset('home/css/style.css')}}" rel="stylesheet">
@section('content')
    <article class="blogs">
        <h1 class="t_nav">
            <span>文章分类:&nbsp{{$cate->cate_name}}</span>
            <a href="/" class="n1">网站首页</a>
            <a href="{{url('lists/'.$cate->id)}}" class="n2">{{$cate->cate_name}}</a>
        </h1>



        <div class="newblog left">

            @foreach($arts as $k=>$v)
                <h2>{{$v->art_title}}</h2>
                <p class="dateview"><span>发布时间：{{$v->art_time}}</span><span>作者：{{$v->art_editor}}</span><span>分类：[<a href="{{url('lists/'.$cate->cate_id)}}">{{$cate->cate_name}}</a>]</span></p>
                <figure><img src="{{$v->art_thumb}}"></figure>
                <ul class="nlist">
                    <p>{{$v->art_description}}</p>
                    <a title="{{$v->art_title}}" href="{{url('info/'.$v->id)}}" target="_blank" class="readmore">阅读全文>></a>
                </ul>
                <div class="line"></div>

            @endforeach


            <div class="blank"></div>
            <div class="ad">
                <img src="{{url('images/ad.png')}}">
            </div>
            <div class="page">

                <ul class="pagination">
                    {{--<li class="disabled"><span>«</span></li> <li class="active"><span>1</span></li><li>--}}
                    {{--<a href="http://blog.hd/admin/article?page=2">2</a></li> --}}
                    {{--<li><a href="http://blog.hd/admin/article?page=2" rel="next">»</a></li>--}}
                    {!! $arts->render() !!}
                </ul>


            </div>
        </div>
        <aside class="right">
            <div class="rnav">
                <ul>
                    @foreach($cate as $k=>$v)
                        <li class="rnav{{$k+1}}"><a href="{{url('lists/'.$v->id)}}" target="_blank">{{$v->cate_name}}====</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="news">
                @parent
            </div>
            <div class="visitors">
                <h3><p>最近访客</p></h3>
                <ul>

                </ul>
            </div>
            <!-- Baidu Button BEGIN -->
            <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
            <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
            <script type="text/javascript" id="bdshell_js"></script>
            <script type="text/javascript">
                document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
            </script>
            <!-- Baidu Button END -->
        </aside>
    </article>
@endsection