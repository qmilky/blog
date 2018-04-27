<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Entities\Permission;
class PermissionController extends Controller
{
    public  function permissionAdd(Request $request)
    {
        if($request->method()=='POST'){
            $data['name']=$request->get('name');
            $data['description']=$request->get('description');
          $resault = app(Permission::class)->create($data);
          if($resault){
              return redirect('admin/permission/list')->with('msg','权限添加成功');
          };
        }
       return  view('admin.permission.permission_add');
    }
    public  function permissionList()
    {
        $permissions = app(Permission::class )->get(['pid','name','description']);
        return  view('admin.permission.permission_list',compact('permissions'));
    }
}
