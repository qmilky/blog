<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .link{
            text-decoration: none;
        }
    </style>
</head>
<body>

 @foreach($arts as $k=>$v)
     <h3>{{$v->art_title}}：</h3>
     @if(!empty($v->art_links))
     @foreach($v->art_links as $m=>$n)
     <a href="{{$n['url']}}" class="link">
         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{$n['name']}};
     </a>====
         @endforeach
         @else
         无相关链接
     @endif
     @endforeach

</body>
</html>