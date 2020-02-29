<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class SessionsController extends Controller
{

    public function __construct()
    {
        // 指定未登录的用户操作
        $this->middleware('guest', [
            //未登录用户只能访问登录页面
            'only' => ['create']
        ]);
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store(Request $request)
    {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required|min:6'
        ]);

        if (Auth::attempt($credentials, $request->has('remember'))) {
            if (Auth::user()->activated) {
                session()->flash('success', '登录成功');
                $fallback = route('users.show', [Auth::user()]);
                // 将用户重定向到之前访问的页面
                return redirect()->intended($fallback);
            } else {
                Auth::logout();
                session()->flash('warning', '请登录您的邮箱进行验证');
                return redirect()->route('home');
            }
        } else {
            session()->flash('danger', '账号或密码不正确');
            // 携带参数返回上级页面
            return redirect()->back()->withInput();
        }


        return;
    }

    public function destroy()
    {
        Auth::logout();
        session()->flash('success', '您已经成功退出');
        return redirect()->route('login');
    }
}
