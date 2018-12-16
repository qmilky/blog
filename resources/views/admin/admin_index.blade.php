@extends('layouts.layouts')
@section('title')
    <title>{{config('admin_index')}}</title>
@endsection

@section('body')
    <!--头部 开始-->
    <div class="top_box">
        <div class="top_left">
            <div class="logo">后台管理模板</div>
            <ul>
                <li><a href="#" class="active">首页</a></li>
                <li><a href="#">管理页</a></li>
            </ul>
        </div>
        <div class="top_right">
            <ul>
                <li>管理员：admin</li>
                <li><a href="pass.html" target="main">修改密码</a></li>
                <li><a href="{{url('admin/logout')}}">退出</a></li>
            </ul>
        </div>
    </div>
    <!--头部 结束-->

    <!--左侧导航 开始-->
    <div class="menu_box">
        <ul>
            <li>
                <h3><i class="fa fa-fw fa-clipboard"></i>用户模块</h3>
                <ul class="sub_menu">
                    <li><a href="{{url('admin/user/create')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>添加用户</a></li>
                    <li><a href="{{url('admin/user/lists')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>用户列表</a></li>

                </ul>
            </li>
            <li>
                <h3><i class="fa fa-fw fa-clipboard"></i>分类模块</h3>
                <ul class="sub_menu">
                    <li><a href="{{url('admin/article/cates/create')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>添加分类</a></li>
                    <li><a href="{{url('admin/article/cates/index')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>分类列表</a></li>

                </ul>
            </li>
            <li>
                <h3><i class="fa fa-fw fa-cog"></i>文章模块</h3>
                <ul class="sub_menu">
                    <li><a href="{{url('admin/article/create')}}" target="main"><i class="fa fa-fw fa-cubes"></i>添加文章</a></li>
                    <li><a href="{{url('admin/article/list')}}" target="main"><i class="fa fa-fw fa-database"></i>文章列表</a></li>
                    <li><a href="{{url('admin/article/link/list')}}" target="main"><i class="fa fa-fw fa-database"></i>相关文章</a></li>
                </ul>
            </li>
            <li>
                <h3><i class="fa fa-fw fa-cog"></i>角色模块</h3>
                <ul class="sub_menu">
                    <li><a href="{{url('admin/role/create')}}" target="main"><i class="fa fa-fw fa-cubes"></i>添加角色</a></li>
                    <li><a href="{{url('admin/role/list')}}" target="main"><i class="fa fa-fw fa-database"></i>角色列表</a></li>
                </ul>
            </li>
            <li>
                <h3><i class="fa fa-fw fa-cog"></i>权限模块</h3>
                <ul class="sub_menu">
                    <li><a href="{{url('admin/permission/create')}}" target="main"><i class="fa fa-fw fa-cubes"></i>添加权限</a></li>
                    <li><a href="{{url('admin/permission/list')}}" target="main"><i class="fa fa-fw fa-database"></i>权限列表</a></li>
                </ul>
            </li>
            <li>
                <h3><i class="fa fa-fw fa-cog"></i>友情链接模块</h3>
                <ul class="sub_menu">
                    <li><a href="{{url('admin/link/create')}}" target="main"><i class="fa fa-fw fa-cubes"></i>添加友情链接</a></li>
                    <li><a href="{{url('admin/link')}}" target="main"><i class="fa fa-fw fa-database"></i>友情链接列表</a></li>
                </ul>
            </li>
            <li>
                <h3><i class="fa fa-fw fa-cog"></i>网站配置模块</h3>
                <ul class="sub_menu">
                    <li><a href="{{url('admin/config/create')}}" target="main"><i class="fa fa-fw fa-cubes"></i>添加网站配置</a></li>
                    <li><a href="{{url('admin/config')}}" target="main"><i class="fa fa-fw fa-database"></i>网站配置列表</a></li>
                </ul>
            </li>
            <li>
                <h3><i class="fa fa-fw fa-thumb-tack"></i>工具导航</h3>
                <ul class="sub_menu">
                    <li><a href="http://www.yeahzan.com/fa/facss.html" target="main"><i class="fa fa-fw fa-font"></i>图标调用</a></li>
                    <li><a href="http://hemin.cn/jq/cheatsheet.html" target="main"><i class="fa fa-fw fa-chain"></i>Jquery手册</a></li>
                    <li><a href="http://tool.c7sky.com/webcolor/" target="main"><i class="fa fa-fw fa-tachometer"></i>配色板</a></li>
                    <li><a href="element.html" target="main"><i class="fa fa-fw fa-tags"></i>其他组件</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <!--左侧导航 结束-->

    <!--主体部分 开始-->
    <div class="main_box">
        <iframe src="{{url('admin/info')}}" frameborder="0" width="100%" height="100%" name="main"></iframe>
    </div>
    <!--主体部分 结束-->

    <!--底部 开始-->
    <div class="bottom_box">
        CopyRight © 2015. Powered By <a href="http://www.itxdl.cn">http://www.qymblog.com</a>.
    </div>
    <!--底部 结束-->
@endsection