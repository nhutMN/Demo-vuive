<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutPage;

class AboutController extends Controller
{
    // Display the list of About pages
    public function index()
    {
        $data = AboutPage::get();

        return view('admin.about.index', compact('data'));
    }

    // Show the form to create a new About page
    public function create()
    {
        return view('admin.about.create');
    }

    // Store the new About page
    public function store(Request $request)
    {
        // Validate dữ liệu gửi lên từ form
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ], [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'name.string' => 'Tên sản phẩm phải là một chuỗi ký tự.',
            'name.max' => 'Tên sản phẩm không được quá 255 ký tự.',
            'description.required' => 'Mô tả là bắt buộc.',
            'description.string' => 'Mô tả phải là một chuỗi ký tự.',
        ]);

        // Lưu dữ liệu vào cơ sở dữ liệu
        AboutPage::create([
            'title' => $request->name,
            'content' => $request->description,
        ]);

        // Chuyển hướng về trang danh sách với thông báo thành công
        return redirect()->route('about.index')->with('success', 'Trang About đã được thêm thành công.');
    }


    // Show the form to edit the About page
    public function edit($id)
    {
        // Lấy thông tin của sản phẩm cần sửa từ cơ sở dữ liệu
        $about = AboutPage::findOrFail($id);
        
        return view('admin.about.edit', compact('about'));
    }


    // Update the About page
    public function update(Request $request, $id)
    {
        // Validate dữ liệu người dùng gửi lên
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ], [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'description.required' => 'Mô tả là bắt buộc.',
        ]);

        // Cập nhật dữ liệu trong cơ sở dữ liệu
        $about = AboutPage::findOrFail($id);
        $about->update([
            'title' => $request->name,
            'content' => $request->description,
        ]);

        // Chuyển hướng về trang danh sách và hiển thị thông báo thành công
        return redirect()->route('about.index')->with('success', 'Cập nhật sản phẩm thành công.');
    }


    // Delete the About page
    public function destroy($id)
    {
        // Tìm sản phẩm cần xóa
        $about = AboutPage::findOrFail($id);

        // Xóa sản phẩm
        $about->delete();

        // Chuyển hướng về trang danh sách và hiển thị thông báo thành công
        return redirect()->route('about.index')->with('success', 'Sản phẩm đã được xóa thành công.');
    }

}

