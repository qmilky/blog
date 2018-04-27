@extends('layouts.layouts')
@section('title')
    <title>{{config('title.admin')}}</title>
@endsection
@section('body')
    <div class="login_box">
    <h1>QymBlog</h1>
    <h2>欢迎回家,请出示令牌</h2>
    <div class="form">
        @if (count($errors) > 0)
            <div class="alert alert-danger" id="info">
                <ul>
                    @if(is_object($errors))
                        @foreach ($errors->all() as $error)
                            <li style="color:red">{{ $error }}</li>
                        @endforeach
                    @else
                        <li style="color:red">{{ $errors }}</li>
                    @endif
                </ul>
            </div>
        @endif
        <form action="{{url('admin/login')}}" method="post">
            {{csrf_field()}}
            <ul>
                <li>
                    <input type="text" name="admin_name" class="text" value="{{old('admin_name')}}"/>
                    <span><i class="fa fa-user"></i></span>
                </li>
                <li>
                    <input type="password" name="password" class="text" value="{{old('password')}}"/>
                    <span><i class="fa fa-lock"></i></span>
                </li>

                <li>
                    <input type="text" class="code" name="code" value="{{old('code')}}"/>
                    <span><i class="fa fa-check-square-o"></i></span>
                    <img src="{{url('admin/yzm')}}" onclick="this.src='{{url('admin/yzm')}}?'+Math.random()" alt="点我呀！！！">
                </li>
                <li>
                    <input type="submit" value="立即回家"/>
                </li>
            </ul>
        </form>
        <p><a href="#">返回首页</a> &copy; 2016 Powered by <a href="http://www.itxdl.cn" target="_blank">http://www.itxdl.cn</a></p>
    </div>
</div>
    <script>
        $('#info').fadeOut(2000);
    </script>
    {{--/*若此处用@show而不用@endsection则登陆页会出现2个form表单*/--}}
@endsection