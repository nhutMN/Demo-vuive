@extends('layouts.index')
@section('content')
<section class="bg-light">
    <div class="container pb-5">
        <div class="row">
            <div class="col-lg-5 mt-5">
                <div class="card mb-3">
                    <img class="card-img img-fluid" src="{{asset('uploads/products/' .$product->image)}}" alt="Card image cap" id="product-detail">
                </div>
            </div>
            <!-- col end -->
            <div class="col-lg-7 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h2">{{$product->name}}</h1>
                        <p class="h3 py-2">{{ number_format($product->price) }} VNĐ</p>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <h6>Brand:</h6>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted"><strong>{{ $brand->name ?? 'Unknown Brand' }}</strong></p>
                            </li>
                        </ul>                       

                        <div class="row pb-3">
                            <div class="col d-grid">
                                <a href="{{route('add.cart', $product->id)}}" type="submit" class="btn btn-success btn-lg" name="submit" value="addtocard">Add To Cart</a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div>
            <h6>Thông số kỹ thuật:</h6>
            <p>{{$product->description}}</p>
        </div>
    </div>
</section>
@endsection