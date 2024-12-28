<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\OrderItem;

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
        ->paginate(10); // Directly paginate the query builder

    $idCount = $data->total(); // Use total() to get the total count

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
            'quantity' => 'required|integer|min:0', 
        ], [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.min' => 'Tên sản phẩm phải có ít nhất 4 ký tự.',
            'name.max' => 'Tên sản phẩm không được quá 150 ký tự.',
            'name.unique' => 'Tên sản phẩm đã tồn tại.',
            'price.required' => 'Giá sản phẩm là bắt buộc.',
            'price.numeric' => 'Giá sản phẩm phải là một số.',
            'sale_price.numeric' => 'Giá khuyến mãi phải là một số.',
            'sale_price.lte' => 'Giá khuyến mãi không được lớn hơn giá sản phẩm.',
            'img.required' => 'Ảnh sản phẩm là bắt buộc.',
            'img.file' => 'Ảnh sản phẩm phải là một tệp.',
            'img.mimes' => 'Ảnh sản phẩm phải có định dạng jpg, jpeg, png, hoặc gif.',
            'category_id.required' => 'Danh mục sản phẩm là bắt buộc.',
            'category_id.exists' => 'Danh mục sản phẩm không tồn tại.',
            'quantity.required' => 'Số lượng sản phẩm là bắt buộc.',
            'quantity.integer' => 'Số lượng sản phẩm phải là một số nguyên.',
            'quantity.min' => 'Số lượng sản phẩm không được nhỏ hơn 0.',
        ]);

        $data = $request->only('name', 'price', 'sale_price', 'status', 'description', 'category_id', 'quantity');
        $data['status'] = $request->has('status') ? 1 : 0;

        $img_name = $request->img->hashName();
        $request->img->move(public_path('uploads/products'), $img_name);
        $data['image'] = $img_name;

        if (Product::create($data)) {
            return redirect()->route('product.index')->with('success', 'Sản phẩm đã được thêm thành công!');
        }

        return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm sản phẩm.');
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
            'quantity' => 'required|integer|min:0',
        ], [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'price.required' => 'Giá sản phẩm là bắt buộc.',
            'sale_price.numeric' => 'Giá khuyến mãi phải là một số.',
            'img.mimes' => 'Ảnh sản phẩm phải có định dạng jpg, jpeg, png, hoặc gif.',
            'category_id.exists' => 'Danh mục sản phẩm không tồn tại.',
            'quantity.required' => 'Số lượng sản phẩm là bắt buộc.',
            'quantity.integer' => 'Số lượng sản phẩm phải là một số nguyên.',
        ]);

        $data = $request->only('name', 'price', 'sale_price', 'status', 'description', 'category_id', 'quantity');
        $data['status'] = $request->has('status') ? 1 : 0;

        if ($request->hasFile('img')) {
            if ($product->image && file_exists(public_path('uploads/products/') . $product->image)) {
                unlink(public_path('uploads/products/') . $product->image);
            }

            $img_name = $request->img->hashName();
            $request->img->move(public_path('uploads/products'), $img_name);
            $data['image'] = $img_name;
        }
        if ($product->update($data)) {
            return redirect()->route('product.index')->with('success', 'Sản phẩm đã được cập nhật!');
        }

        return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật sản phẩm.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->orderItems()->delete();
        if ($product->image && file_exists(public_path('uploads/products/') . $product->image)) {
            unlink(public_path('uploads/products/') . $product->image);
        }
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Sản phẩm đã được xóa thành công!');
    }
}
