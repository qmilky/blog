@extends('layouts.layouts')
@section('title')
    <title>vue</title>
@endsection
@section('websocket')
        <script src="{{asset('js/vue/vue.min.js')}}"></script>
        <script src="{{asset('js/axios/axios.min.js')}}"></script>
        {{--使用cdn--}}
        {{--<script src="https://unpkg.com/axios/dist/axios.min.js"></script>--}}
    {{--<script src="https://cdn.bootcss.com/vue/2.4.2/vue.min.js"></script>--}}
@endsection

{{--长链接测试--}}
    {{--<script type="text/javascript">--}}
        {{--var exampleSocket = new WebSocket("ws://qymblog.com:9555");--}}

{{--//            if (exampleSocket.readyState===1) {--}}
{{--//                exampleSocket.send("长链接，我来啦！！！");--}}
{{--//            }else{--}}
{{--//                console.log('正在链接中。。。。。。');--}}
{{--//            }--}}
        {{--exampleSocket.onopen = function (event) {--}}
            {{--exampleSocket.send("长链接已经建立！");--}}
        {{--};--}}

        {{--exampleSocket.onmessage = function (event) {--}}
            {{--console.log(event.data);--}}
        {{--}--}}
    {{--</script>--}}
@section('body')
    <form method="post" action="/job/swoole">
        {{csrf_field()}}
        <input  type="text" id="content" name="message">
        <button>发送</button>
        {{--<button  onclick="exampleSocket.send( document.getElementById('content').value )">发送</button>--}}
    </form>


<div id="axios">
    <button @click="Axioss" id="butt">axios异步ajax</button>
    <p v-if="seen">@{{name}}</p>
</div>

<script>
     new Vue({
    el:"#axios",
    data:{
        name:'哈哈',
        seen:false,
        },
        methods:{
            Axioss:function () {
                //存储变量的重要性，axios成功返回执行的函数中this为window对象
                vm = this;
                var instance = axios.create({
                    baseURL: 'http://qymblog.com/'
                });
                //创建实例进行配置请求和响应
                instance.defaults.headers.common['Authorization'] = 'AUTH_TOKEN';
                instance.defaults.timeout = 2500;
                // 为已知需要花费很长时间的请求覆写超时设置
                instance.post('user/axios', {
                    timeout: 5000
                });
                //请求配置,只有 url 是必需的
                axios({
                    method: 'post',
                    url: 'user/axios',
                    data: {
                        firstName: 'Fred',
                        lastName: 'Flintstone'
                    },
                    transformRequest: [function (data) {
                        // 对 data 进行任意转换处理

                        return data;
                    }],
                    transformResponse: [function (data) {
                        // 对 data 进行任意转换处理

                        return data;
                    }],
                    headers: {'X-Requested-With': 'XMLHttpRequest'},
                    paramsSerializer: function(params) {
                        return Qs.stringify(params, {arrayFormat: 'brackets'})
                    },
                    timeout: 1000


                })
                axios.post('user/axios', {
                //                axios.get('/user/axios', {
                                    params: {
                                        phone:15210643471,
                                        name:'dream',
                                    }
                                })

                        .then(function (response) {
                        console.log(vm);
                        console.log(response);
                        console.log(vm.name);
                        vm.name=response.data.data.params.name;  //post
//                        vm.name=response.data.data.name;  //get
                        console.log(vm.seen);
                        vm.seen = true;
                        console.log(vm.name);
                        console.log(vm.seen);
                    })
                    .catch(function (error) {
                        console.log(error);
                        console.log(error.message);
                        console.log(error.code); // Not always specified
                        console.log(error.config); // The config that was used to make the request
                        console.log(error.response); // Only available if response was received from the server
                    });


//                })
            }
        }
    })
</script>
{{--===================================================================================--}}
<div id="vue_det">
    <h1>site:@{{  site }}</h1>
    <h1>url:@{{  url }}</h1>
    <h1>@{{  details() }}</h1>
</div>

</body>
<div id="app">
    <ul>
        <li v-for="value in object">
            @{{ value }}
        </li>
    </ul>
</div>
<div id="apps">
    <p>
        全选：
    </p>
    <input type="checkbox" id="checkbox" v-model="checked" @click="changeAllChecked()">
    <label for="checkbox">
        @{{checked}}
    </label>
    <p>
        多个复选框：
    </p>
    <input type="checkbox" id="runoob" value="Runoob" v-model="checkedNames">
    <label for="runoob">
        Runoob
    </label>
    <input type="checkbox" id="google" value="Google" v-model="checkedNames">
    <label for="google">
        Google
    </label>
    <input type="checkbox" id="taobao" value="Taobao" v-model="checkedNames">
    <label for="taobao">
        taobao
    </label>
    <br>
    <span>
		选择的值为:@{{checkedNames}}
	</span>
</div>

<script>
    new Vue({
        el: '#app',
        data: {
            object: {
                name: '菜鸟教程',
                url: 'http://www.runoob.com',
                slogan: '学的不仅是技术，更是梦想！'
            }
        }
    })
</script>

<script type="text/javascript">

    var vm = new Vue({
        el: '#vue_det',
        data:{
            site:"菜鸟教程",
            url: "www.runoob.com",
            alexa:"10000"
        },
        methods: {
            details: function() {
                return  this.site + " - 学的不仅是技术，更是梦想！";
            }
        }
    })
</script>
<script>
    new Vue({
        el: '#apps',
        data: {
            checked: false,
            checkedNames: [],
            checkedArr: ["Runoob", "Taobao", "Google"]
        },
        methods: {

            changeAllChecked: function() {
                console.log(this.checked);  //true;
                if (this.checked) {
                    this.checkedNames = this.checkedArr
                } else {
                    this.checkedNames = []
                }
            }
        },
//        watch: {
//            "checkedNames": function() {
//                if (this.checkedNames.length == this.checkedArr.length) {
////                    this.checked = true
//                } else {
////                    this.checked = false
//                }
//            }
//        }
    })
</script>
@endsection