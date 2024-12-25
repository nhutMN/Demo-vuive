@extends('admin.index')
@section('title', 'Sản phẩm')
@section('content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Banner</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <button class="btn btn-success btn-sm" onclick="window.location.href='{{route('banner.create')}}';">
                                <i class="fa fa-plus"></i> Thêm mới
                            </button>      
                        </div>
                    </div>
                    
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <p class="mb-0 mr-2 font-weight-bold">Tổng số: {{$idCount}}</p>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Title</th>
                                    <th>Ảnh</th>
                                    <th>Mô tả</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{$item->title}}</td>

                                    <td>
                                        <img src="{{asset('uploads/banners/' .$item->image)}}" alt="" width="50" height="50">
                                    </td>

                                    <td>{{$item->description}}</td>
                                    <td class="text-right">
                                        <form action="{{ route('banner.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">
                                            @csrf
                                            @method('DELETE')
                                            <a href="{{ route('banner.edit', $item->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Sửa</a>
                                            <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Xóa</button>
                                        </form>
                                    </td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div>
    </div><!-- .animated -->
</div><!-- .content -->
@endsection