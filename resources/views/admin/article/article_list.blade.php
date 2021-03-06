@extends('layouts.layouts')
@section('title')
    <title>{{config('title.article_index')}}</title>
@endsection
@section('body')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">商品管理</a> &raquo; 添加商品
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
    <div class="search_wrap">


    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->

        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content" id="msg">
                <div class="short_wrap">
                    <div class="alert alert-danger">
                        <ul>
                            @if(session('msg'))
                                <li style="color:red" >{{session('msg')}}</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <form action="{{url('/admin/article/research')}}"  method="get">
                <input name="art_title" value="{{$request->art_title}}" placeholder="请输入文章标题" type="text">
                <select name="cate_id">
                    <option value="">
                        请选择文章分类
                    </option>
                    @foreach($cates as $k=> $cate)
                    <option value="{{$cate->id}}"
                    @if($cate->id==$request->cate_id) selected @endif
                    >
                        {{$cate->cate_names}}
                    </option>
                        @endforeach
                </select>
                <button type="submit">提交</button>
            </form>
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">ID</th>
                        <th>标题</th>
                        <th>点击</th>
                        <th>编辑</th>
                        <th>发布时间</th>
                        <th>文章分类</th>
                        <th>文章状态</th>
                        <th>操作</th>
                    </tr>
                    @foreach($arts as $k=>$v)
                        <tr>
                            <td class="tc">{{$v['id']}}</td>
                            <td>
                                <a href="#">{{$v['art_title']}}</a>
                            </td>
                            <td>{{$v['art_view']}}</td>
                            <td>{{$v['art_editor']}}</td>
                            <td>{{$v['art_time']}}</td>
                            <td>{{$v['cate_name']}}</td>
                            <td>{{$v['status_txt']}}</td>
                            {{--<td>--}}
                                {{--@foreach($v->art_links as $m=>$n)--}}
                                    {{--<a href="{{$n['url']}}">{{$n['name']}};</a>--}}
                                    {{--@endforeach--}}
                            {{--</td>--}}
                            <td>
                                {{--admin/article/{article}/edit--}}
                                <a href="{{url('admin/article/'.$v['id'].'/edit')}}">修改</a>

                                <a href ="{{url('admin/article/status?status='.$v['status'].'&art_id='.$v['id'])}}">
                                    @if($v['status']==1)
                                        禁用
                                        @elseif($v['status']==0)
                                        启用
                                        @endif
                                </a>
                                <a href="javascript:;" onclick="delArt({{$v['id']}})">删除</a>

                            </td>
                        </tr>
                    @endforeach

                </table>
                {{--<style>--}}
                {{--table{table-layout: fixed;word-break: break-all; word-wrap: break-word; //表格固定布局}--}}

                {{--.award-name{-o-text-overflow:ellipsis;text-overflow:ellipsis;overflow:hidden;white-space:nowrap;width:100%; //超出部分显示省略号}--}}

                {{--</style>--}}





                {{--分页--}}
                {{--<div class="page_list">--}}
                <?php
                $v = empty($input) ? '' : $input;
                ?>
                {{--{!! $users->appends(['keywords'=>$v])->render() !!}--}}
                {{--</div>--}}



                <div class="page_list">

                    {{--appends(['keyword1'=>'a','keyword2'=>'aaa@q163.com','num'=>2])--}}
{{--                    {!! $arts->render() !!}--}}
                </div>

                <style>
                    .page_list ul li span{
                        padding:6px 12px;
                    }
                </style>
            </div>
        </div>

    <!--搜索结果页面 列表 结束-->

    <script>

        function delArt(id) {
            //询问框
            layer.confirm('您确认删除吗？', {
                btn: ['确认','取消'] //按钮
            }, function(){
//                如果用户发出删除请求，应该使用ajax向服务器发送删除请求
//                $.get("请求服务器的路径","携带的参数", 获取执行成功后的额返回数据);
                //admin/user/1
                {{--$.post("{{url('admin/article')}}/"+id,{"_method":"delete","_token":"{{csrf_token()}}"},function(data){--}}
                $.post("{{url('/admin/article/del')}}",{"_token":"{{csrf_token()}}","id":id},function(data){
                    //alert(data);
//                    data是json格式的字符串，在js中如何将一个json字符串变成json对象
                    //var res =  JSON.parse(data);
//                    删除成功
                    if(data.error == 0){
                        //console.log("错误号"+res.error);
                        //console.log("错误信息"+res.msg);
                        layer.msg(data.msg, {icon: 6});
//                       location.href = location.href;
                        var t=setTimeout("location.href = location.href;",2000);
                    }else{
                        layer.msg(data.msg, {icon: 5});

                        var t=setTimeout("location.href = location.href;",2000);
                        //location.href = location.href;
                    }


                });


            }, function(){

            });
        }


$('#msg').fadeOut(2000);


    </script>
@endsection