<?php

namespace App\Http\Controllers\layouts;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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

}
