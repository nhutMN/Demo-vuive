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
    
    public function home(Request $request, $categoryId = null) {
        $cate = Category::orderBy('id', 'DESC')->get();

        // Get the search query from the request
        $search = $request->input('search');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

        // Check if a category ID is provided
        if ($categoryId) {
            $query = Product::where('category_id', $categoryId);
        } else {
            $query = Product::query();
        }

        // Apply the search filter if search keyword is provided
        if ($search) {
            $query->where('name', 'LIKE', "%{$search}%");
        }

        // Apply price filters if provided
        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

        // Fetch the filtered products
        $data = $query->orderBy('id', 'DESC')->get();
    
        return view('layouts.shop', compact('data', 'cate'));
    }

    public function detail(Product $product){
        $cate = Category::orderBy('id', 'DESC')->get();
        $brand = Category::find($product->category_id);
        return view('layouts.detail', compact('cate', 'brand', 'product'));
    }
}
