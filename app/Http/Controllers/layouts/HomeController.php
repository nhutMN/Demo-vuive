<?php

namespace App\Http\Controllers\layouts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Banner;
use App\Models\AboutPage;

class HomeController extends Controller
{
    public function index(){
        $cate = Category::orderBy('id', 'DESC')->get();
        return view('layouts.index', compact('cate'));
    }

    public function trang_chu(){
        $cate = Category::orderBy('id', 'DESC')->get();
        $ban = Banner::orderBy('id', 'DESC')->get();
        $prot = Product::inRandomOrder('id')->take(6)->get();
        return view('layouts.trangchu', compact('cate', 'ban', 'prot'));
    }

    public function about(){
        $cate = Category::orderBy('id', 'DESC')->get();
        $about = AboutPage::orderBy('id', 'DESC')->first();
        return view('layouts.about', compact('cate', 'about'));
    }

    public function contact(){
        $cate = Category::orderBy('id', 'DESC')->get();
        return view('layouts.contact', compact('cate'));
    }

    
    public function home(Request $request, $categoryId = null)
    {
        $cate = Category::orderBy('id', 'DESC')->get();

        $search = $request->input('search');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        if ($categoryId) {
            $query = Product::where('category_id', $categoryId);
        } else {
            $query = Product::query();
        }

        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

        $data = $query->orderBy('id', 'DESC')->paginate(12);

        return view('layouts.shop', compact('data', 'cate'));
    }


    public function detail(Product $product){
        $cate = Category::orderBy('id', 'DESC')->get();
        $brand = Category::find($product->category_id);
        return view('layouts.detail', compact('cate', 'brand', 'product'));
    }
}
