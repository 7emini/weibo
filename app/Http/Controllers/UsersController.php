<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{

    public function __construct()
    {
        // 需要用户登录的操作
        $this->middleware('auth', [
            //除去
            'except' => ['show', 'create', 'store', 'index', 'confirmEmail']
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        $statuses = $user->statuses()->orderBy('created_at', 'desc')->paginate(10);
        return view('users.show', compact('user', 'statuses'));  
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:users|max:50',
            'email'=> 'required|email|unique:users|max:255',
            'password'=> 'required|confirmed|min:6|max:20'
        ]);
        
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $this->sendEmailConfirmationTo($user);
        session()->flash('success', '验证邮件已发送到你的注册邮箱: '.$user->email.' ，请注意查收。');
        return redirect()->route('home');
    }

    public function sendEmailConfirmationTo($user)
    {
        $view = 'emails.confirm';
        $data = compact('user');
        $from = 'touchmain@qq.com';
        $name = 'GaoHe';
        $to = $user->email;
        $subject = '感谢注册Weibo应用';
        
        Mail::send($view, $data, function($message) use ($from, $name, $to, $subject){
            $message->from($from, $name)->to($to)->subject($subject);
        });

        // TODO:配置在生产环境中发送邮件
        // $view = 'emails.confirm';
        // $data = compact('user');
        // $to = $user->email;
        // $subject = "感谢注册 Weibo 应用！请确认你的邮箱。";

        // Mail::send($view, $data, function ($message) use ($to, $subject) {
        //     $message->to($to)->subject($subject);
        // });

    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $this->authorize('update', $user);
        $this -> validate($request, [
            'name' => 'required|max:20',
            'password' => 'nullable|confirmed|min:6'
        ]);
        $data = [];

        $data['name'] = $request->input('name');
        
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        session()->flash('success', '更新个人资料成功');

        return redirect()->route('users.show', $user->id);
    }

    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    public function destroy(User $user)
    {
        //只允许已经登录的管理员进行删除操作
        $this->authorize('destroy', $user);
        $user->delete();
        session()->flash('success', '成功删除用户');
        return redirect()->back();
    }

    public function confirmEmail($token)
    {
        $user = User::where('activation_token', $token)->firstOrFail();
        $user->activated = true;
        $user->activation_token = null;
        $user->save();

        Auth::login($user);
        session()->flash('success', '恭喜，账号激活成功');
        return redirect()->route('users.show', [$user]);
    }

    
    
}
