<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;


class AdminController extends Controller
{
    public function index(){
        $dataUser = User::orderBy('id', 'DESC')->get();
        $dataCategory = Category::orderBy('id', 'DESC')->get();
        $dataProduct = Product::orderBy('id', 'DESC')->get();
        $dataOrder = Order::orderBy('id', 'DESC')->get();

        $countUser = $dataUser->count();
        $countCategory = $dataCategory->count();
        $countProduct= $dataProduct->count();
        $countOrder = $dataOrder->count();
        return view('admin.dashboard', compact('countUser', 'countCategory', 'countProduct', 'countOrder'));
    }

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
            return redirect()->route('admin.index');
        }
        return redirect()->back();
    }

    public function logout(){
        auth()->logout();
        return redirect()->route('admin.login');
    }

    public function register(){
        return view('admin.register');
    }

    // public function postRegister(Request $request){
    //     $request->validate([
    //         'name' => 'required|min:6|max:100',
    //         'role' => 'required|min:6|max:100',
    //         'email' => 'required|email|unique:users',
    //         'password' => 'required|'
    //     ]);

    //     $data = $request->only('name', 'email', 'password', 'role');
    //     $pass_hash = bcrypt($request->password);
    //     $data['password'] = $pass_hash;

    //     if(User::create($data)){
    //         return redirect()->route('admin.login');
    //     }
    //     return redirect()->back();

    // }
}
