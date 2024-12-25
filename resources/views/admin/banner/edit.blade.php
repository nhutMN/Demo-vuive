@extends('admin.index')
@section('title', 'Sửa banner')
@section('content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Sửa banner</h1>
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
                        <form action="{{ route('banner.update', $banner->id) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                            @csrf @method('PUT')

                            <!-- Tiêu đề banner -->
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Tiêu đề</label></div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="text-input" name="title" placeholder="Tiêu đề banner" class="form-control" value="{{ old('title', $banner->title) }}">
                                    @error('title')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Mô tả -->
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="textarea-input" class=" form-control-label">Mô tả</label></div>
                                <div class="col-12 col-md-9">
                                    <textarea name="description" id="textarea-input" rows="5" class="form-control">{{ old('description', $banner->description) }}</textarea>
                                    @error('description')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Ảnh banner -->
                            <div class="row form-group">
                                <div class="col col-md-3"><label for="file-input" class=" form-control-label">Ảnh banner</label></div>
                                <div class="col-12 col-md-9">
                                    <img src="{{ asset('uploads/banners/' . $banner->image) }}" alt="" width="200" height="200">
                                    <input type="file" id="file-input" name="img" class="form-control-file">
                                    @error('img')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Trạng thái -->
                            <div class="row form-group">
                                <div class="col col-md-3"><label class=" form-control-label">Trạng thái</label></div>
                                <div class="col col-md-9">
                                    <div class="form-check-inline form-check">
                                        <label for="inline-checkbox1" class="form-check-label">
                                            <input type="checkbox" id="inline-checkbox1" name="status" {{ old('status', $banner->status) ? 'checked' : '' }} class="form-check-input"> Kích hoạt
                                        </label>
                                    </div>
                                    @error('status')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

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
