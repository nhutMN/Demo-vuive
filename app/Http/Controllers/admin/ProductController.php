<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $data = Product::query()
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'DESC')
            ->get();

        $idCount = $data->count();
        
        return view('admin.products.index', compact('data', 'idCount'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = Category::orderBy('name','ASC')->get();
        return view('admin.products.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:4|max:150|unique:products',
            'price' => 'required|numeric',
            'sale_price' => 'numeric|lte:price',
            'img' => 'required|file|mimes:jpg,jpeg,png,gif',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|integer|min:0', // Thêm validation cho quantity
        ]);

        $data = $request->only('name', 'price', 'sale_price', 'status', 'description', 'category_id', 'quantity');
        $data['status'] = $request->has('status') ? 1 : 0;

        $img_name = $request->img->hashName();
        $request->img->move(public_path('uploads/products'), $img_name);
        $data['image'] = $img_name;

        if (Product::create($data)) {
            return redirect()->route('product.index');
        }

        return redirect()->back();
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $data = Category::orderBy('name','ASC')->select('id','name')->get();
        return view('admin.products.edit', compact('data','product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|min:4|max:150|unique:products,name,' . $product->id,
            'price' => 'required|numeric|min:0|max:99999999.99',
            'sale_price' => 'numeric|lte:price',
            'img' => 'nullable|file|mimes:jpg,jpeg,png,gif',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|integer|min:0', // Thêm validation cho quantity
        ]);

        $data = $request->only('name', 'price', 'sale_price', 'status', 'description', 'category_id', 'quantity');
        $data['status'] = $request->has('status') ? 1 : 0;

        // Xử lý ảnh nếu có tải lên
        if ($request->hasFile('img')) {
            if ($product->image && file_exists(public_path('uploads/products/') . $product->image)) {
                unlink(public_path('uploads/products/') . $product->image);
            }

            $img_name = $request->img->hashName();
            $request->img->move(public_path('uploads/products'), $img_name);
            $data['image'] = $img_name;
        }

        if ($product->update($data)) {
            return redirect()->route('product.index');
        }

        return redirect()->back();
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index');
    }
}
