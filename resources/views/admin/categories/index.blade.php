@extends('admin.index')
@section('title', 'Danh mục sản phẩm')
@section('content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Danh mục sản phẩm</h1>
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
                            <button class="btn btn-success btn-sm" onclick="window.location.href='{{route('category.create')}}';">
                                <i class="fa fa-plus"></i> Thêm mới
                            </button>                            
                        </div>
                    </div>
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <p class="mb-0 mr-2 font-weight-bold">Tổng số: {{$idCount}}</p>
                            </div>
                            <div class="d-flex">
                                <!-- Add form tag for search functionality -->
                                <form method="GET" action="{{ route('category.index') }}">
                                    <input type="text" name="search" id="tableSearch" class="form-control form-control-sm" 
                                           style="width: 250px;" placeholder="Tìm kiếm..." value="{{ request()->get('search') }}">
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Tên danh mục</th>
                                    <th>Kích hoạt</th>
                                    <th>Ngày tạo</th>
                                    <th>Ngày update</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>
                                        <div style="padding-left: 20px">
                                            <input type="checkbox" id="inline-checkbox1" name="inline-checkbox1"
                                            value="option1" class="form-check-input" {{$item->status == 1 ? 'checked' : ''}}> Kích hoạt
                                        </div>
                                    </td>
                                    <td>{{$item->created_at}}</td>
                                    <td>{{$item->updated_at}}</td>
                                    <td class="text-right">
                                        <form action="{{ route('category.destroy', $item->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <a href="{{ route('category.edit', $item->id) }}" class="btn btn-sm btn-primary"><i
                                                    class="fa fa-edit"></i>Sửa</a>
                                            <button href="" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?');"><i class="fa fa-trash"></i>Xóa</button>
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