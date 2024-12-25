@extends('admin.index')
@section('title', 'Sửa sản phẩm')
@section('content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Sửa sản phẩm</h1>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="content">
    <div class="animated fadeIn">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body card-block col-lg-8">
                        <form action="{{ route('about.update', $about->id) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                            @csrf 
                            @method('PUT')

                            <!-- Tên sản phẩm -->
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="text-input" class="form-control-label">Tên sản phẩm</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="text-input" name="name" placeholder="Tên sản phẩm" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $about->title) }}">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Mô tả -->
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="textarea-input" class="form-control-label">Mô tả</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <textarea name="description" id="textarea-input" rows="9" class="form-control @error('description') is-invalid @enderror">{{ old('description', $about->content) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Nút gửi form -->
                            <div class="form-actions form-group">
                                <button type="submit" class="btn btn-primary btn-sm">Sửa</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
