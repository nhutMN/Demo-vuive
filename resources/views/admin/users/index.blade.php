@extends('admin.index')
@section('title', 'Quản lý nhân viên')
@can('admin')
@section('content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Quản lý nhân viên</h1>
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
                            <button class="btn btn-success btn-sm" onclick="window.location.href='{{route('admin.register')}}';">
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
                                <!-- Form for search functionality -->
                                <form method="GET" action="{{ route('admin.user') }}">
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
                                    <th>Tên</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{$item->name}}</td>
                                    <td>{{$item->email}}</td>
                                    <td>{{$item->role}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td class="text-right">
                                        <a href="{{ route('admin.user.edit', $item->id) }}" class="btn btn-sm btn-primary">
                                            <i class="fa fa-edit"></i> Sửa
                                        </a>
                                        <form action="{{ route('admin.user.delete', $item->id) }}" method="POST" style="display:inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?');">
                                                <i class="fa fa-trash"></i> Xóa
                                            </button>
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
@endcan