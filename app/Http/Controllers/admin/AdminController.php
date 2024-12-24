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
    
        $data = $request->only('name', 'password');
        $check = auth()->attempt($data);
    
        if ($check) {
            return redirect()->route('admin.index');
        }
    
        return redirect()->back()->with('error', 'Tên đăng nhập hoặc mật khẩu không đúng.');
    }
    

    public function logout(){
        auth()->logout();
        return redirect()->route('admin.login');
    }

    public function register(){
        return view('admin.register');
    }
}
