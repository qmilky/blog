<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public  function index()
    {
        return view('admin.admin_index');
    }
    public  function info()
    {
        return view('admin.info');
    }
}
