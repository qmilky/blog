@extends('layouts.layouts')
@section('title')
    <title>后台文章添加页面</title>
@endsection
@section('body')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="#">首页</a> &raquo; <a href="#">文章管理</a> &raquo; 添加文章
    </div>
    <!--面包屑导航 结束-->

    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        <div class="result_title">

            <div class="alert alert-danger">
                <ul>
                    @if(session('msg'))
                        <li style="color:red">{{session('msg')}}</li>
                    @endif
                </ul>
            </div>

        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="#"><i class="fa fa-plus"></i>新增文章</a>
                <a href="#"><i class="fa fa-recycle"></i>批量删除</a>
                <a href="#"><i class="fa fa-refresh"></i>更新排序</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

    <div class="result_wrap">
        <form id="art_form" action="{{url('admin/article/'.$art->id.'/edit')}}" method="post" enctype="multipart/form-data">
            {{--        <form id="art_form" action="{{url('admin/article/xiugai/'.$art->art_id)}}" method="post" enctype="multipart/form-data">--}}
            <table class="add_tab">
                <tbody>
                <tr>
                    {{csrf_field()}}
{{--                    {{method_field('put')}}--}}
                    <th><i class="require">*</i>分类：</th>
                    <td>
                        <select name="cate_id">
                            <option value="">==请选择==</option>
                            @foreach($cates as $k=>$v)
                                @if($v->id == $art->cate_id)
                                    <option value="{{$v->id}}" selected>{{$v->cate_names}}</option>
                                @else
                                    <option value="{{$v->id}}" >{{$v->cate_names}}</option>
                                @endif
                            @endforeach

                        </select>

                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>文章标题：</th>
                    <td>
                        <input type="text" class="lg" name="art_title" value="{{$art->art_title}}">
                        <p>标题可以写30个字</p>
                    </td>
                </tr>
                <tr>
                    <th><i class="require">*</i>相关链接：</th>
                    <td>
                        <input type="text" class="lg" name="art_link" value="{{$art->art_link}}">
                        <p>链接与描述之间用@@隔开，链接之间用；隔开</p>
                    </td>
                </tr>
                <tr>

                    <th>编辑：</th>
                    <td>
                        <input type="text" class="sm" name="art_editor"  value="{{$art->art_editor}}">
                    </td>
                </tr>
                <tr>
                    <th>缩略图：</th>
                    <td>
                        <input type="text" size="50" id="art_thumb" name="art_thumb"  value="{{$art->art_thumb}}">
                        {{--//要想实现多文件上传，此处必须有中括号name="file_upload[]"，与Admin/UploadController.php中的$file = $file[0];匹配，否则要实现单文件上传就将2者都去掉。--}}
                        <input id="file_upload" name="file_upload[]" type="file" multiple >
                        <br>
                        <img src="{{$art->art_thumb}}" id="img1" alt="" style="width:80px;height:80px">
                        <script type="text/javascript">
                            $(function () {
                                $("#file_upload").change(function () {
                                    $('img1').show();
                                    uploadImage();
                                });
                            });
                            function uploadImage() {
                                // 判断是否有选择上传文件
                                var imgPath = $("#file_upload").val();
                                if (imgPath == "") {
                                    alert("请选择上传图片！");
                                    return;
                                }
                                //判断上传文件的后缀名
                                var strExtension = imgPath.substr(imgPath.lastIndexOf('.') + 1);
                                if (strExtension != 'jpg' && strExtension != 'gif'
                                    && strExtension != 'png' && strExtension != 'bmp'&& strExtension != 'jpeg') {
                                    alert("请选择图片文件");
                                    return;
                                }
                                //打包表单的方式，仅打包上传文件部分
                                    var formData = new FormData($('#art_form')[0]);
                                //打包表单方式，打包整个表单
                                {{--var formData = new FormData();--}}
                                {{--formData.append('file_upload', $('#file_upload')[0].files[0]);--}}
                                {{--formData.append('_token',"{{csrf_token()}}");--}}
                                $.ajax({
                                    type: "POST",
                                    url: "/admin/upload",
                                    data: formData,
                                    async: true,
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    success: function(data) {
                                        console.log(data);
//                                        $('#img1').attr('src','/uploads/'+data);//上传至本地服务器
                                        //上传至七牛云服务器
                                            $('#img1').attr('src','http://p0bvp893u.bkt.clouddn.com/uploads/'+data);
                                            // //上传至阿里云服务器
                                            // $('#img1').attr('src','http://project193.oss-cn-beijing.aliyuncs.com/'+data);
                                        $('#img1').show();
                                        $('#art_thumb').val('http://p0bvp893u.bkt.clouddn.com/uploads/'+data);
                                    },
                                    error: function(XMLHttpRequest, textStatus, errorThrown) {
                                        alert("上传失败，请检查网络后重试");
                                    }
                                });
                            }
                        </script>

                    </td>
                </tr>

                <tr>
                    <th>关键词：</th>
                    <td>
                        <input type="text" class="lg" name="art_tag"  value="{{$art->art_tag}}">
                    </td>
                </tr>
                <tr>
                    <th>描述：</th>
                    <td>
                        <textarea name="art_description">{{$art->art_description}}</textarea>
                    </td>
                </tr>
                <tr>
                    <th>文章内容：</th>
                    <td>
                        <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.config.js"></script>
                        <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.all.min.js"> </script>
                        <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
                        <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
                        <script type="text/javascript" charset="utf-8" src="/ueditor/lang/zh-cn/zh-cn.js"></script>

                        <script id="editor" name="art_content" type="text/plain" style="width:800px;height:300px;">{!! $art->art_content !!}</script>
                        <script>
                        var ue = UE.getEditor('editor');
                        </script>
                        <style>
                            .edui-default{line-height: 28px;}
                            div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
                            {overflow: hidden; height:20px;}
                            div.edui-box{overflow: hidden; height:22px;}
                        </style>
                    </td>
                </tr>
                <tr>
                    <th></th>
                    <td>
                        <input type="submit" value="提交">
                        <input type="button" class="back" onclick="history.go(-1)" value="返回">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
@endsection