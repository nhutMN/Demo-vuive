@extends('admin.index')
@section('title', 'Thêm nhân viên')
@can('admin')
@section('content')
<div class="breadcrumbs">
    <div class="breadcrumbs-inner">
        <div class="row m-0">
            <div class="col-sm-4">
                <div class="page-header float-left">
                    <div class="page-title">
                        <h1>Thêm nhân viên</h1>
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
                        <form action="{{route('admin.register')}}" method="post" enctype="multipart/form-data" class="form-horizontal">
                            @csrf
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="text-input" class=" form-control-label">Username</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="text" id="text-input" name="name" placeholder="Text" class="form-control">
                                    <small class="form-text text-muted">This is a help text</small>
                                    @error('name') <!-- Hiển thị lỗi -->
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="email-input" class="form-control-label">Email</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="email" id="email-input" name="email" placeholder="Enter Email" class="form-control">
                                    <small class="help-block form-text">Please enter your email</small>
                                    @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="password-input" class=" form-control-label">Password</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <input type="password" id="password-input" name="password" placeholder="Password" class="form-control">
                                    <small class="help-block form-text">Please enter a complex password</small>
                                    @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="row form-group">
                                <div class="col col-md-3">
                                    <label for="role-select" class="form-control-label">Role</label>
                                </div>
                                <div class="col-12 col-md-9">
                                    <select name="role" id="role-select" class="form-control">
                                        <option value="admin">Admin</option>
                                        <option value="nvthungan">NV Thu Ngân</option>
                                        <option value="nvkho">NV Kho</option>
                                        <option value="nvbanhang">NV Bán Hàng</option>
                                    </select>
                                    <small class="form-text text-muted">Chọn vai trò cho nhân viên</small>
                                    @error('role')
                                    <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-actions form-group">
                                <button type="submit" class="btn btn-primary btn-sm">Thêm</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
@endcan
