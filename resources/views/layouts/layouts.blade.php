<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    @yield('title')
    <link rel="stylesheet" href="{{asset('admin/style/css/ch-ui.admin.css')}}">
    <link rel="stylesheet" href="{{asset('admin/style/font/css/font-awesome.min.css')}}">
    <script type="text/javascript" src="{{asset('admin/style/js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin/style/js/ch-ui.admin.js')}}"></script>
    <script type="text/javascript" src="{{asset('layer/layer.js')}}"></script>
    @section('websocket')
    @show
</head>
<script type="text/javascript">
//    此处js代码必须在提交按钮之前，
//        var exampleSocket = new WebSocket("ws://qymblog.com:9505");
//
//        //            if (exampleSocket.readyState===1) {
//        //                exampleSocket.send("长链接，我来啦！！！");
//        //            }else{
//        //                console.log('正在链接中。。。。。。');
//        //            }
//        exampleSocket.onopen = function (event) {
//            exampleSocket.send("长链接已经建立！");
//        };
//
//        exampleSocket.onmessage = function (event) {
//            console.log(event.data);
////            alert(event.data);
//        }

</script>
<body style="background:#F3F3F4;">
@section('body')
    @show
</body>

{{--<input  type="text" id="content">--}}
{{--<button  onclick="exampleSocket.send( document.getElementById('content').value )" type="">发送</button>--}}
</html>