<?php
namespace App\Http\Controllers\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Entities\AdminUser;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
class UserController extends Controller
{
    public function create(Request $request)
    {
        if($request->method()=='POST'){
            $data['admin_name']=$request->get('admin_name');
            $data['password']=$request->get('password');
            $rule = [
                'admin_name'=>'required|regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u|between:2,20',
                "password"=>'required|between:6,20'
            ];


            $mess = [
                'admin_name.required'=>'用户名必须输入',
                'admin_name.regex'=>'用户名必须汉字字母数字下划线',
                'admin_name.between'=>'用户名必须在2到20位之间',
                'password.required'=>'密码必须输入',
                'password.between'=>'密码必须在6到20位之间'
            ];
            $validator =  Validator::make($data,$rule,$mess);
            if ($validator->fails()) {
                return redirect('admin/user/create')
                    ->withErrors($validator)
                    ->withInput();
            }

//            $data['password']=Crypt::encrypt($request->get('password'));
            $data['password']=password_hash($request->get('password'),PASSWORD_BCRYPT);
            $res = AdminUser::create($data);
            if($res){
                return redirect('admin/user/lists')->with('msg','添加成功');
            }
            return redirect('admin/user/create')->with('msg','添加失败');
        }
        return view('admin.user.add');
    }


    /*参数在控制器和表单中的交互，$request!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!*/
    public function lists(AdminUser $adminUser,Request $request)
    {
        DB::enableQueryLog();
        $user = AdminUser::orderBy('id','asc')
        ->where(function($query)use($request){
            $username = $request->input('keywords1');
            if(!empty($username)){
                /*若like后面将，改为.则无法查询出结果*/
                $query->where('admin_name','like','%'.$username.'%');
//                dd($query);
            }
        })
        ->paginate($request->input('num',2));
//        ->get();
//        dd(DB::getQueryLog());
        /*此处将request对象传到表单页面，并带有表单传递过来的数据*/
        
        Log::notice('得到用户列表', DB::getQueryLog());
        Log::error('得到用户列表', DB::getQueryLog());
        Log::info('得到用户列表', ['1','2','3']);
//       dd(Config :: get('app.debug')) ;
        return view('admin/user/lists',['request'=>$request,'user'=>$user]);
    }








}

