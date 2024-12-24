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

    // Lấy dữ liệu từ request
    $data = $request->only('name', 'price', 'sale_price', 'status', 'description', 'category_id', 'quantity');
    $data['status'] = $request->has('status') ? 1 : 0;

    // Xử lý ảnh
    $img_name = $request->img->hashName();
    $request->img->move(public_path('uploads/products'), $img_name);
    $data['image'] = $img_name;

    // Lưu sản phẩm vào cơ sở dữ liệu
    if (Product::create($data)) {
        return redirect()->route('product.index')->with('success', 'Sản phẩm đã được thêm thành công!');
    }

    // Nếu không thành công, quay lại trang trước
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
    // Apply validation rules
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

    // Prepare data for update
    $data = $request->only('name', 'price', 'sale_price', 'status', 'description', 'category_id', 'quantity');
    $data['status'] = $request->has('status') ? 1 : 0;

    // Handle image upload if present
    if ($request->hasFile('img')) {
        if ($product->image && file_exists(public_path('uploads/products/') . $product->image)) {
            unlink(public_path('uploads/products/') . $product->image);
        }

        $img_name = $request->img->hashName();
        $request->img->move(public_path('uploads/products'), $img_name);
        $data['image'] = $img_name;
    }

    // Update the product
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
    // Xóa các bản ghi liên quan trong bảng order_items (có thể là xóa hoàn toàn hoặc thay đổi trạng thái khác)
    $product->orderItems()->delete(); // Hoặc $product->orderItems()->update(['status' => 'product_removed']);

    // Xóa ảnh nếu có
    if ($product->image && file_exists(public_path('uploads/products/') . $product->image)) {
        unlink(public_path('uploads/products/') . $product->image);
    }

    // Xóa sản phẩm khỏi bảng products
    $product->delete();

    // Redirect về trang danh sách sản phẩm với thông báo thành công
    return redirect()->route('product.index')->with('success', 'Sản phẩm đã được xóa thành công!');
}

    




    public function exportExcelHtml()
    {
        $products = Product::with('cate')->get();

        // Tạo nội dung HTML cho file Excel
        $htmlContent = '
        <html>
            <head>
                <meta charset="UTF-8">
                <title>Báo cáo tồn kho sản phẩm</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                    }
                    h2 {
                        text-align: center;
                        color: #333;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                    }
                    table, th, td {
                        border: 1px solid #ccc;
                    }
                    th, td {
                        padding: 8px;
                        text-align: center;
                    }
                    th {
                        background-color: #f4f4f4;
                        font-weight: bold;
                    }
                    tr:nth-child(even) {
                        background-color: #f9f9f9;
                    }
                </style>
            </head>
            <body>
                <h2>BÁO CÁO TỒN KHO SẢN PHẨM</h2>
                <table>
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Danh mục</th>
                            <th>Số lượng tồn</th>
                            <th>Giá</th>
                            <th>Giá khuyến mãi</th>
                            <th>Trạng thái</th>
                            <th>Ngày tạo</th>
                            <th>Ngày cập nhật</th>
                        </tr>
                    </thead>
                    <tbody>';

        $index = 1;
        foreach ($products as $product) {
            $htmlContent .= '
                        <tr>
                            <td>' . $index++ . '</td>
                            <td>' . htmlspecialchars($product->name) . '</td>
                            <td>' . htmlspecialchars($product->cate->name ?? 'Không có') . '</td>
                            <td>' . $product->quantity . '</td>
                            <td>' . number_format($product->price, 0, ',', '.') . ' VNĐ</td>
                            <td>' . number_format($product->sale_price, 0, ',', '.') . ' VNĐ</td>
                            <td>' . ($product->status ? 'Kích hoạt' : 'Không kích hoạt') . '</td>
                            <td>' . $product->created_at->format('d/m/Y H:i:s') . '</td>
                            <td>' . $product->updated_at->format('d/m/Y H:i:s') . '</td>
                        </tr>';
        }

        $htmlContent .= '
                    </tbody>
                </table>
            </body>
        </html>';

        // Tạo file Excel từ nội dung HTML
        $fileName = 'bao_cao_ton_kho_' . now()->format('Y_m_d_H_i_s') . '.xls';
        return response($htmlContent)
            ->header('Content-Type', 'application/vnd.ms-excel')
            ->header('Content-Disposition', "attachment; filename={$fileName}");
    }

}
