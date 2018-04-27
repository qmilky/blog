<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
//require_once app_path().'\Org\code\Code.class.php';
use App\Org\code\Code;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use App\Entities\AdminUser;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public  function login(Request $request)
    {
        /*此处Request不是门面类，而是use Illuminate\Http\Request;*/
        if($request->method()=="POST"){
           $data = $request->except('_token');
            $rule = [
                'admin_name'=>'required|regex:/^[\x{4e00}-\x{9fa5}A-Za-z0-9_]+$/u|between:5,20',
                "password"=>'required|between:3,20'
            ];
            $mess = [
                'admin_name.required' =>'用户名必须输入',
                'admin_name.regex'    =>'用户名必须汉字字母下划线',
                'admin_name.between'  =>'用户名必须在5到20位之间',
                'password.required' =>'密码必须输入',
                'password.between'  =>'密码必须在5到20位之间'
            ];
            $validator = Validator::make($data,$rule,$mess);
            if ($validator->fails()) {
                return redirect('admin/login')
                    ->withErrors($validator)
                    ->withInput();
            }
//            echo $data['code'].'<br>'.Session::get('code');
            if( strtolower($data['code']) !=  strtolower(Session::get('code'))) {
                return redirect('admin/login')->with('errors','验证码错误');
            }
            $user=AdminUser::where('admin_name',$data['admin_name'])->first();
            if(!$user){
                return redirect('admin/login')->with('errors','对不起，用户名不存在！！！');
            }
            if(!password_verify($data['password'],$user->password)){
//            if(Crypt::decrypt($user->password)!=$data['password']){
                return redirect('admin/login')->with('errors','对不起，密码错误！！！');
            }
            Session::put('admin_user',$user);
            return redirect('admin/index');
        }       
            return  view('login.login');
    }
    public function yzm()
    {
        $code=new Code();
        $code->make();
    }
    public function jm(){
        $str='Frontqym7777';
//        $cry =  Crypt::encrypt($str);
//        $cry =  password_hash($str,PASSWORD_DEFAULT);
        $cry =  password_hash($str,PASSWORD_BCRYPT);
        echo $cry;
    }
}
