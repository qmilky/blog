<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Role;
use App\Entities\Permission;
use DB;
class RoleController extends Controller
{
    public  function  roleAdd(Request $request)
    {
//        dd(111);
        if($request->method()=='POST'){
            $data['name']=$request->get('name');
            $data['description']=$request->get('description');
            $res = app(Role::class)->create($data);
            if($res){
                return redirect('admin/role/list')->with(['msg'=>'角色添加成功']);
            }else{
                return redirect('admin/role/create')->withInput();
            }
        }
        return view('admin.role.role_add');
    }
    public  function  roleList(Request $request)
    {
        $colums = [
            'rid',
            'name',
            'description',
        ];
       $roles =  App(Role::class)->get($colums);
        return view('admin.role.role_list',compact('roles'));
    }
    public   function  roleAuth($id)
    {
        $colums = [
            'pid',
            'name',
        ];
        $role = App(Role::class)->find($id);
        $permissions = App(Permission::class)->get($colums);
        $own_permissions = $own_permissions = DB::table('role_permission')->where('rid',$id)->pluck('pid')->toArray();
//        dd($own_permissions);
       return  view('admin.role.role_auth',compact('permissions','role','own_permissions'));
    }
    public  function  doauth(Request $request)
    {
       $data['role_id'] = $request->get('role_id');
       $data['permission_id'] = $request->get('permission_id');
       foreach($data['permission_id'] as $k=>$v){
           $datas[$k]['rid']=$data['role_id'];
           $datas[$k]['pid']=$v;
       }
    DB::beginTransaction();


        try{
            //删除角色以前拥有的权限
            DB::table('role_permission')->where('rid',$data['role_id'])->delete();
//            给当前角色重新授权


//        2. 将授权数据添加到permission_role表中

                    DB::table('role_permission')->create($datas);


        }catch (Exception $e){
            DB::rollBack();
        }

        DB::commit();

        //添加成功后，跳转到列表页
        return redirect('admin/role/list');
    }
}
