<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>@yield('title')</title>
    <meta name="keywords" content="@yield('keywords')" />
    <meta name="description" content="寻梦主题的个人博客模板，优雅、稳重、大气,低调。" />
    <link href="{{asset('home/css/base.css')}}" rel="stylesheet">
    {{--此处包含class=avatar的样式--}}
    <link href="{{asset('home/css/index.css')}}" rel="stylesheet">



    <!--[if lt IE 9]>
    <script src="{{asset('home/js/modernizr.js')}}"></script>
    <![endif]-->
</head>
<body>
<header>

    <div id=""><a href="/"></a></div>
    {{--    <img src="{{config('webconfig.web_title')}}" alt="">--}}
    {{--//此处为导航栏，分类在此处--}}
    <nav class="topnav" id="topnav">
        @foreach($cates as $c)
        <a href="{{url('home/cate/lists?id='.$c->id)}}">{{$c->cate_name}}</a>

{{--            <a href="{{$v->nav_url}}"><span>{{$v->nav_name}}</span><span class="en">{{$v->nav_alias}}</span></a>--}}
        @endforeach
    </nav>
</header>
@section('content')


    <h3>
        <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
        @foreach($news as $k=>$v)
            <li><a href="{{url('info/'.$v->id)}}" title="{{$v->art_title}}" target="_blank">{{$v->art_title}}</a></li>
        @endforeach
    </ul>
    <h3 class="ph">
        <p>点击<span>排行</span></p>
    </h3>
    <ul class="paih">
        @foreach($hots as $k=>$v)
            <li><a href="{{url('info/'.$v->id)}}" title="{{$v->art_title}}" target="_blank">{{$v->art_title}}</a></li>
        @endforeach
    </ul>


@show
<footer>
    <p>{!! config('webconfig.copyright') !!}{{config('webconfig.web_count')}}</p>
    <a href="http://www.miitbeian.gov.cn">京ICP备18015331号</a>
</footer>

<script type='text/javascript'>
    (function(m, ei, q, i, a, j, s) {
        m[i] = m[i] || function() {
            (m[i].a = m[i].a || []).push(arguments)
        };
        j = ei.createElement(q),
            s = ei.getElementsByTagName(q)[0];
        j.async = true;
        j.charset = 'UTF-8';
        j.src = 'https://static.meiqia.com/dist/meiqia.js?_=t';
        s.parentNode.insertBefore(j, s);
    })(window, document, 'script', '_MEIQIA');
    _MEIQIA('entId', 65288);
</script>
<!-- JiaThis Button BEGIN -->
{{--<script type="text/javascript" src="http://v3.jiathis.com/code/jiathis_r.js?move=0" charset="utf-8"></script>--}}
<!-- JiaThis Button END -->
</body>
</html>
