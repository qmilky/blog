<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
{{--    <meta name="Authorization" content="{{ $authorization}}" />--}}
    <title>推送</title>
</head>
<body>
        <form method="POST" action="{{url('admin/push')}}">
            {{csrf_field()}}
            <button> 提交</button>
        </form>
</body>
</html>