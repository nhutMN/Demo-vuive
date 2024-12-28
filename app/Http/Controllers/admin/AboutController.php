<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AboutPage;

class AboutController extends Controller
{
    public function index()
    {
        $data = AboutPage::get();

        return view('admin.about.index', compact('data'));
    }

    public function create()
    {
        return view('admin.about.create');
    }

    public function store(Request $request)
    {
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

        AboutPage::create([
            'title' => $request->name,
            'content' => $request->description,
        ]);

        return redirect()->route('about.index')->with('success', 'Trang About đã được thêm thành công.');
    }


    public function edit($id)
    {
        $about = AboutPage::findOrFail($id);
        
        return view('admin.about.edit', compact('about'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
        ], [
            'name.required' => 'Tên sản phẩm là bắt buộc.',
            'description.required' => 'Mô tả là bắt buộc.',
        ]);

        $about = AboutPage::findOrFail($id);
        $about->update([
            'title' => $request->name,
            'content' => $request->description,
        ]);

        return redirect()->route('about.index')->with('success', 'Cập nhật sản phẩm thành công.');
    }


    public function destroy($id)
    {
        $about = AboutPage::findOrFail($id);

        $about->delete();

        return redirect()->route('about.index')->with('success', 'Sản phẩm đã được xóa thành công.');
    }

}

