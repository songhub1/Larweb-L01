<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function create() {
        return view('users.create');
    }

    public function show(User $user) {
        return view('users.show',compact('user'));
    }

    public function store(Request $request) {
        //对输入的请求数据进行验证
        //required 验证是否为空
        //min 和 max 来限制用户名所填写的最小长度和最大长度
        //email 验证用户邮箱格式 -- 格式验证
        //unique 验证邮箱是否被其他人使用过 -- 唯一性验证
        // confirm 验证两次输入的密码是否一直 -- 密码匹配验证
        $this->validate($request,[
            'name' => 'required|max:50',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|min:6'
        ]);
        return;
    }
}
