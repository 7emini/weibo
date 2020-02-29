<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{

    public function __construct()
    {
        // 需要用户登录的操作
        $this->middleware('auth', [
            //除去
            'except' => ['show', 'create', 'store', 'index']
        ]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));  
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

        Auth::login($user); 
        session()->flash('success', '恭喜，注册成功');
        return redirect()->route('users.show', $user);
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
}
