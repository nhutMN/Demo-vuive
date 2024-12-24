@extends('admin.index')
@section('title', 'Chi tiết đơn hàng')
@section('content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Chi tiết đơn hàng: #{{ $order->id }}</h1>
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
                    <div class="card-header d-flex justify-content-between">
                        <div class="col-md-9">
                            <p><strong>Tên người mua:</strong> {{ $order->name }}</p>
                            <p><strong>Gmail:</strong> {{ $order->email }}</p>
                            <p><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                            <p><strong>Địa chỉ</strong> {{ $order->address }}</p>
                            <p><strong>Tổng giá:</strong> {{ $order->total_price }}</p>
                            <p><strong>Ngày tạo:</strong> {{ $order->created_at }}</p>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.order.export.html', $order->id) }}" class="btn btn-success">Xuất Excel</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>Ảnh</th>
                                    <th>Giá</th>
                                    <th>Số lượng</th>
                                    <th>Tổng</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->product->name }}</td>
                                    <td>
                                        <img src="{{ asset('uploads/products/' . $item->product->image) }}" alt="" width="50" height="50">
                                    </td>
                                    <td>{{ $item->price }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ $item->price * $item->quantity }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
