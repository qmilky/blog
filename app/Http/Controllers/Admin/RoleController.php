<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RoleController extends Controller
{
    public  function  roleAdd(Request $request)
    {
//        dd(111);
        if($request->method()=='POST'){

        }
        return view('admin.role.role_add');
    }
    public  function  roleList(Request $request)
    {
        return view('admin.role.role_list');
    }
}
