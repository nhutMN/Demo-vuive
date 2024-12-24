@extends('layouts.index')
@section('content')
    <div class="bg-light py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mb-0"><a href="index.html">Home</a> <span class="mx-2 mb-0">/</span> <strong
                        class="text-black">Cart</strong></div>
            </div>
        </div>
    </div>
    <div class="site-section">
        <div class="container">
            <div class="row mb-5">
                <form class="col-md-12" method="post">
                    <div class="site-blocks-table">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="product-thumbnail">Ảnh</th>
                                    <th class="product-name">Tên</th>
                                    <th class="product-price">Giá</th>
                                    <th class="product-quantity">Số lượng</th>
                                    <th class="product-total">Tổng giá</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cart->items as $item)
                                    <tr>
                                        <td class="product-thumbnail">
                                            <img src="{{ asset('uploads/products/' . $item->image) }}" alt="Image" class="img-fluid" height="50px" width="50px">
                                        </td>
                                        <td class="product-name">
                                            <h2 class="h5 text-black">{{$item->name}}</h2>
                                        </td>
                                        <td>{{$item->price}}</td>
                                        <td>
                                            {{$item->quantity}}
                                        </td>
                                        <td>{{$item->quantity*$item->price}}</td>
                                        <td>
                                            <a 
                                            href="{{route('cart.delete', $item->id)}}" 
                                            class="btn btn-primary btn-sm"
                                            onclick="return confirm('Bạn có chắc muốn xóa ?')"
                                            >
                                            X
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach                               
                            </tbody>
                        </table>
                    </div>
                </form>
            </div>

            <div class="row">
                <div class="col-md-6">  
                    <a href="{{route('shop')}}">
                        <button  class="btn btn-primary btn-lg py-3 btn-block">Mua thêm</button></a>                 
                </div>
                
                <div class="col-md-6 pl-5">
                    <div class="row justify-content-end">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col-md-12 text-right border-bottom mb-5">
                                    <h3 class="text-black h4 text-uppercase">Tổng tiền</h3>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <span class="text-black">Tổng số lượng</span>
                                </div>
                                <div class="col-md-6 text-right">
                                    <strong class="text-black">{{$cart->totalQuantity}}</strong>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-6">
                                    <span class="text-black">Tổng tiền</span>
                                </div>
                                <div class="col-md-6 text-right">
                                    <strong class="text-black">{{$cart->totalPrice}}</strong>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 pb-5">
                                    <div class="row mb-5">
                                        <form action="{{ route('cart.checkout') }}" method="POST" class="col-md-12">
                                            @csrf
                                            <div class="form-group">
                                                <label for="name">Họ và tên</label>
                                                <input type="text" name="name" id="name" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" name="email" id="email" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="phone">Số điện thoại</label>
                                                <input type="text" name="phone" id="phone" class="form-control" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="address">Địa chỉ</label>
                                                <textarea name="address" id="address" class="form-control" rows="3" required></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-lg py-3 btn-block">Thanh toán</button>
                                        </form>
                                    </div>                                    
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
