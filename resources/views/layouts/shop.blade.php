@extends('layouts.index')
@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-lg-12">
            <!-- Search Form -->
            <form method="GET" action="{{ route('layouts.home', $categoryId ?? '') }}" class="mb-4">
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" class="form-control" name="search" placeholder="Tìm kiếm theo tên" value="{{ request()->input('search') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control" name="min_price" placeholder="Giá tối thiểu" value="{{ request()->input('min_price') }}">
                    </div>
                    <div class="col-md-3">
                        <input type="number" class="form-control" name="max_price" placeholder="Giá tối đa" value="{{ request()->input('max_price') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
                    </div>
                </div>
            </form>

            <div class="row">
                @if ($data->isEmpty())
                    <p>No products found for this category.</p>
                @else
                    @foreach ($data as $item)
                        <div class="col-md-4">
                            <div class="card mb-4 product-wap rounded-0">
                                <div class="card rounded-0">
                                    <img class="card-img rounded-0 img-fluid" src="{{ asset('uploads/products/' . $item->image) }}">
                                    <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                        <ul class="list-unstyled">
                                            <li>
                                                <a class="btn btn-success text-white mt-2" href="{{ route('layouts.detail', $item->id) }}">
                                                    <i class="far fa-eye"></i>
                                                </a>
                                            </li>

                                        </ul>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <a href="#" class="h3 text-decoration-none">{{ $item->name }}</a>
                                    <p class="text-center mb-0">{{ number_format($item->price) }} VNĐ</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif

                {{ $data->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
@endsection
