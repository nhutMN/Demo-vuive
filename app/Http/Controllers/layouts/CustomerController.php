<?php

namespace App\Http\Controllers\layouts;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class CustomerController extends Controller
{
    public function login(){
        return view('admin.login');
    }

    public function postLogin(Request $request){
        $request->validate([
            'name' => 'required|exists:users,name',
            'password' => 'required'
        ]);

        $data = $request->only('name','password');
        $check = auth()->attempt($data);
        if($check){
            return redirect()->route('layouts.home');
        }

        return redirect()->back();
    }

    public function register(){
        return view('layouts.register');
    }

    public function postRegister(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:users,name'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => 'required',
        ],[

        ]);
    
        $data = $request->only('name', 'email', 'password');
        $pass_hash = bcrypt($request->password);
        $data['password'] = $pass_hash;
    
        if(User::create($data)){
            return redirect()->route('login');
        }
        return redirect()->back();
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route('layouts.trangchu');
    }

    public function userProfile()
    {
        $cate = Category::orderBy('id', 'DESC')->get();
        $user = Auth::user(); 
        return view('layouts.user-profile', compact('user', 'cate'));
    }

    public function updateProfile(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
        'address' => 'nullable|string|max:255',
        'sdt' => 'nullable|string|max:15',
    ],[
        'name.required' => 'Họ và tên là bắt buộc.',
        'name.string' => 'Họ và tên phải là một chuỗi ký tự.',
        'name.max' => 'Họ và tên không được vượt quá 255 ký tự.',
        'email.required' => 'Email là bắt buộc.',
        'email.email' => 'Vui lòng nhập một địa chỉ email hợp lệ.',
        'email.max' => 'Email không được vượt quá 255 ký tự.',
        'email.unique' => 'Email này đã tồn tại.',
        'address.string' => 'Địa chỉ phải là một chuỗi ký tự.',
        'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
        'sdt.string' => 'Số điện thoại phải là một chuỗi ký tự.',
        'sdt.max' => 'Số điện thoại không được vượt quá 15 ký tự.',
    ]);

    $user = Auth::user();
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->address = $request->input('address');
    $user->sdt = $request->input('sdt');
    $user->save();

    return redirect()->route('user.profile')->with('success', 'Thông tin đã được cập nhật!');
}


    
}
