<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $data = User::query()
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'DESC')
            ->get();

        $idCount = $data->count();

        return view('admin.users.index', compact('data', 'idCount'));
    }


    public function register(){
        return view('admin.users.register');
    }

    public function postRegister(Request $request)
    {
        // Kiểm tra và validate dữ liệu đầu vào
        $request->validate([
            'name' => ['required', 'unique:users,name'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => 'required',
            'role' => 'required'
        ], [
            'name.required' => 'Tên người dùng là bắt buộc.',
            'name.unique' => 'Tên người dùng đã tồn tại.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Định dạng email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'role.required' => 'Vai trò là bắt buộc.'
        ]);
        
    
        $data = $request->only('name', 'email', 'password', 'role');
        $pass_hash = bcrypt($request->password);
        $data['password'] = $pass_hash;
    
        if(User::create($data)){
            return redirect()->route('admin.user');
        }
        return redirect()->back();
    }

    public function edit(User $user) {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user) {
        $request->validate([
            'name' => ['required', 'unique:users,name,' . $user->id],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
            'role' => ['required']
        ], [
            'name.required' => 'Tên người dùng là bắt buộc.',
            'name.unique' => 'Tên người dùng đã tồn tại.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Định dạng email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
            'role.required' => 'Vai trò là bắt buộc.'
        ]);
    
        $data = $request->only('name', 'email', 'role');
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }
    
        if ($user->update($data)) {
            return redirect()->route('admin.user')->with('success', 'Cập nhật người dùng thành công!');
        }
    
        return redirect()->back()->with('error', 'Cập nhật người dùng thất bại.');
    }
    
    
    public function destroy(User $user) {
        if ($user->delete()) {
            return redirect()->route('admin.user')->with('success', 'Xóa người dùng thành công!');
        }
        return redirect()->back()->with('error', 'Xóa người dùng thất bại.');
    }      
}
