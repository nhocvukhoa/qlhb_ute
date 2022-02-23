<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Gate;

session_start();

class AdminController extends Controller
{
    

    public function index()
    {
        $title = 'Đăng nhập Admin';
        return view('Admin.admin_login', compact('title'));
    }


    public function showDashboard()
    {
        $title = 'Trang quản trị';
        return view('Admin.dashboard', compact('title'));

        //return view('Admin.dashboard', compact('title'));
    }

    public function login(Request $request)
    {
        $request->validate(
            [
                'name' => 'required',
                'password' => 'required',
            ],
            [
                'name.required' => 'Vui lòng nhập tên đăng nhập',
                'password.required' => 'Vui lòng nhập mật khẩu',
            ]
        );
        if (Auth::attempt(['name' => $request->name, 'password' => $request->password])) {
            return Redirect::to('admin/dashboard');
        }
        session()->put('message', 'Tài khoản hoặc mật khẩu sai');
        Auth::logout();
        return redirect()->back();
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to('/admin');
    }


    public function thongke()
    {
        $title = 'Trang thống kê';
        return view('thongke', compact('title'));
    }
}
