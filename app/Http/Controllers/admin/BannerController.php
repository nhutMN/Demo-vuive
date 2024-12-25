<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Banner::orderBy('id', 'DESC')->get();

        $idCount = $data->count();
        
        return view('admin.banner.index', compact('data', 'idCount'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data = Banner::orderBy('title','ASC')->get();
        return view('admin.banner.create', compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:4|max:150|unique:banners',
            'img' => 'required|file|mimes:jpg,jpeg,png,gif',
            'description' => 'nullable|string|max:500',
        ], [
            'title.required' => 'Tiêu đề là bắt buộc.',
            'title.min' => 'Tiêu đề phải có ít nhất 4 ký tự.',
            'title.max' => 'Tiêu đề không được quá 150 ký tự.',
            'title.unique' => 'Tiêu đề đã tồn tại.',
            'img.required' => 'Ảnh là bắt buộc.',
            'img.file' => 'Ảnh phải là một tệp.',
            'img.mimes' => 'Ảnh phải có định dạng jpg, jpeg, png, hoặc gif.',
            'description.max' => 'Mô tả không được quá 500 ký tự.',
        ]);

        $data = $request->only('title', 'description');

        // Handle file upload
        $img_name = $request->img->hashName();
        $request->img->move(public_path('uploads/banners'), $img_name);
        $data['image'] = $img_name;

        // Create the banner
        if (Banner::create($data)) {
            return redirect()->route('banner.index')->with('success', 'Banner đã được thêm thành công!');
        }

        return redirect()->back()->with('error', 'Có lỗi xảy ra khi thêm banner.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        $data = Banner::orderBy('title','ASC')->select('id','title')->get();
        return view('admin.banner.edit', compact('data','banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title' => 'required|min:4|max:150|unique:banners,title,' . $banner->id,
            'img' => 'nullable|file|mimes:jpg,jpeg,png,gif',
            'description' => 'nullable|string|max:500',
        ], [
            'title.required' => 'Tiêu đề là bắt buộc.',
            'title.min' => 'Tiêu đề phải có ít nhất 4 ký tự.',
            'title.max' => 'Tiêu đề không được quá 150 ký tự.',
            'title.unique' => 'Tiêu đề đã tồn tại.',
            'img.mimes' => 'Ảnh phải có định dạng jpg, jpeg, png, hoặc gif.',
            'description.max' => 'Mô tả không được quá 500 ký tự.',
        ]);

        // Collect form data
        $data = $request->only('title', 'description');

        // Handle image upload
        if ($request->hasFile('img')) {
            // Delete old image if it exists
            if ($banner->image && file_exists(public_path('uploads/banners/') . $banner->image)) {
                unlink(public_path('uploads/banners/') . $banner->image);
            }

            $img_name = $request->img->hashName();
            $request->img->move(public_path('uploads/banners'), $img_name);
            $data['image'] = $img_name;
        }

        // Update the banner
        if ($banner->update($data)) {
            return redirect()->route('banner.index')->with('success', 'Banner đã được cập nhật!');
        }

        return redirect()->back()->with('error', 'Có lỗi xảy ra khi cập nhật banner.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Banner $banner)
    {
        // Check and delete the banner's image if it exists
        if ($banner->image && file_exists(public_path('uploads/banners/') . $banner->image)) {
            unlink(public_path('uploads/banners/') . $banner->image);
        }

        // Delete the banner record
        $banner->delete();

        // Redirect back with a success message
        return redirect()->route('banner.index')->with('success', 'Banner đã được xóa thành công!');
    }

}
