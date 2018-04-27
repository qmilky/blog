<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>vue</title>
{{--    <script src="{{myAssetMix('js/manifest.js')}}"></script>--}}
        <script src="{{asset('js/vue/vue.min.js')}}"></script>
        <script src="{{asset('js/axios/axios.min.js')}}"></script>
        {{--使用cdn--}}
        {{--<script src="https://unpkg.com/axios/dist/axios.min.js"></script>--}}
    {{--<script src="https://cdn.bootcss.com/vue/2.4.2/vue.min.js"></script>--}}
</head>
<body>

<div id="axios">
    <button @click="Axioss" id="butt">axios异步ajax</button>
</div>

<script>
    new Vue({
    el:"#axios",
        data:{},
        methods:{
            Axioss:function () {
                axios.get('user/axios', {
{{--                axios.get({{asset('/user/axios')}}, {--}}
                    params: {
                        phone:15210643471,
                        name:'dream',
                    }
                })
                    .then(function (response) {
                        console.log(response);
                    })
                    .catch(function (error) {
                        console.log(error);
                    });

            }
        }
    })
</script>
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
</html>