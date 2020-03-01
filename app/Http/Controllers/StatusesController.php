<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;



class StatusesController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:140'
        ]);
        $user = Auth::user();
        $user->statuses()->create([
            'content'=>$request['content']
        ]);
        session()->flash('success', '发布成功');
        return redirect()->back();  
    }

    public function destroy($user)
    {

    }
}
