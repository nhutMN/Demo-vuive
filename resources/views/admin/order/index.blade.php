@extends('admin.index')
@section('title', 'Danh mục sản phẩm')
@section('content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Danh sách mua hàng</h1>
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
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <p class="mb-0 mr-2 font-weight-bold">Tổng số: {{$idCount}}</p>
                            </div>
                            <div class="d-flex">
                                <!-- Search Form -->
                                <form method="GET" action="{{ route('admin.order') }}">
                                    <input type="text" name="search" id="tableSearch" class="form-control form-control-sm" 
                                           style="width: 250px;" placeholder="Tìm kiếm..." value="{{ request('search') }}">
                                </form>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <table id="bootstrap-data-table" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Tài khoản</th>
                                    <th>Tên người mua</th>
                                    <th>Giá</th>
                                    <th>Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    {{-- <td>{{$item->orderUser->name}}</td> --}}
                                    <td>{{ $item->orderUser ? $item->orderUser->name : 'N/A' }}</td>

                                    <td>{{$item->name}}</td>
                                    <td>{{$item->total_price}}</td>
                                    <td>{{$item->created_at}}</td>
                                    <td class="text-right">
                                        <button class="btn btn-sm btn-success" onclick="window.location.href='{{ route('admin.orderDetail', $item->id) }}'">Chi tiết</button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{ $data->links('vendor.pagination.bootstrap-4') }}
                </div>
            </div>


        </div>
    </div><!-- .animated -->
</div><!-- .content -->
@endsection