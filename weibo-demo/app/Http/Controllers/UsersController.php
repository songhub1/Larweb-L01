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
        // 创建该用户
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        // 注册成功消息提示
        // session() 访问会话实例
        // flash() 只在下一次的请求内有效
        // 之后可以使用 session()->get('success') 取出值
        // 注册成功后自动登陆
        Auth::login($user);
        session()->flash('success', '欢迎， 您将在这里开启一段新的旅程～');
        // 重定向个人页面
        return redirect()->route('users.show',[$user]);
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(User $user, Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $data = [];
        $data['name'] = $request->name;
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }
        $user->update($data);

        session()->flash('success', '个人资料更新成功!');

        return redirect()->route('users.show', $user);
    }
}
