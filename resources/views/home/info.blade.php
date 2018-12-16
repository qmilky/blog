@extends('layouts.home')
@section('title')
    {{$art->art_title}}
@endsection
@section('content')
    <link href="{{asset('home/css/new.css')}}" rel="stylesheet">
    <article class="blogs">
        <h1 class="t_nav">
    <span>您当前的位置：<a href="">首页</a>
        @if(isset($catetwo))
      <a href="/news/s/">{{$catetwo}}</a>&nbsp;&gt;
        @endif
      &nbsp;<a href="/news/s/">{{$cateone['cate_name']}}</a>
    </span>
            <a href="/" class="n1">网站首页</a>
            {{--<a href="/news/s/" class="n2">{{$cates[0]->one}}</a>&nbsp;&gt;--}}
            {{--&nbsp;<a href="/news/s/" class="n3">{{$cates[0]->two}}</a>--}}

        </h1>
        <div class="index_about">



            <h2 class="c_titile">{{$art->art_title}}</h2>
            <p class="box_c"><span class="d_time">发布时间：{{$art->art_time}}</span><span>编辑：{{$art->art_editor}}</span><span>查看次数：{{$art->art_view}}</span></p>
            <ul class="infos">
                {!! $art->art_content !!}
            </ul>
            <div class="keybq">
                <p><span>关键字词</span>：{{$art->art_tag}}</p>

            </div>
            <div class="ad"> </div>
            <div class="nextinfo">
                @if(empty($pre))
                    <p>没有上一篇了</p>
                @else
                    <p>上一篇：<a href="{{url('info/'.$pre->id)}}">{{$pre->art_title}}</a></p>
                @endif
                @if(empty($next))
                    <p>没有下一篇了</p>
                @else
                    <p>下一篇：<a href="{{url('info/'.$next->id)}}">{{$next->art_title}}</a></p>
                @endif

            </div>
            <div class="otherlink">
                <h2>相关文章</h2>
                <ul>
                    @foreach($simple as $v)
                        <li><a href="{{url('info/'.$v->id)}}" title="{{$v->art_title}}">{{$v->art_title}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
        <aside class="right">
            <!-- Baidu Button BEGIN -->
            <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
            <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script>
            <script type="text/javascript" id="bdshell_js"></script>
            <script type="text/javascript">
                document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
            </script>
            <!-- Baidu Button END -->
            <div class="blank"></div>
            <div class="news">
                <h3>
                    <p>栏目<span>最新</span></p>
                </h3>
                <ul class="rank">
                    <li><a href="/" title="Column 三栏布局 个人网站模板" target="_blank">Column 三栏布局 个人网站模板</a></li>
                    <li><a href="/" title="with love for you 个人网站模板" target="_blank">with love for you 个人网站模板</a></li>
                    <li><a href="/" title="免费收录网站搜索引擎登录口大全" target="_blank">免费收录网站搜索引擎登录口大全</a></li>
                    <li><a href="/" title="做网站到底需要什么?" target="_blank">做网站到底需要什么?</a></li>
                    <li><a href="/" title="企业做网站具体流程步骤" target="_blank">企业做网站具体流程步骤</a></li>
                    <li><a href="/" title="建站流程篇——教你如何快速学会做网站" target="_blank">建站流程篇——教你如何快速学会做网站</a></li>
                    <li><a href="/" title="box-shadow 阴影右下脚折边效果" target="_blank">box-shadow 阴影右下脚折边效果</a></li>
                    <li><a href="/" title="打雷时室内、户外应该需要注意什么" target="_blank">打雷时室内、户外应该需要注意什么</a></li>
                </ul>
                <h3 class="ph">
                    <p>点击<span>排行</span></p>
                </h3>
                <ul class="paih">
                    <li><a href="/" title="Column 三栏布局 个人网站模板" target="_blank">Column 三栏布局 个人网站模板</a></li>
                    <li><a href="/" title="withlove for you 个人网站模板" target="_blank">with love for you 个人网站模板</a></li>
                    <li><a href="/" title="免费收录网站搜索引擎登录口大全" target="_blank">免费收录网站搜索引擎登录口大全</a></li>
                    <li><a href="/" title="做网站到底需要什么?" target="_blank">做网站到底需要什么?</a></li>
                    <li><a href="/" title="企业做网站具体流程步骤" target="_blank">企业做网站具体流程步骤</a></li>
                </ul>
            </div>
            <div class="visitors">
                <h3>
                    <p>最近访客</p>
                </h3>
                <ul>
                </ul>
            </div>
        </aside>
    </article>
@endsection