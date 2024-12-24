@extends('admin.index')
@section('title', 'Chỉnh sửa người dùng')
@section('content')
<div class="content">
    <h2>Chỉnh sửa người dùng</h2>
    <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Tên</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
            @error('name')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
            @error('email')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Mật khẩu (để trống nếu không đổi)</label>
            <input type="password" name="password" class="form-control">
            @error('password')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label>Vai trò</label>
            <select name="role" class="form-control" required>
                <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
            </select>
            @error('role')
            <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        
        <button type="submit" class="btn btn-success">Lưu thay đổi</button>
    </form>
</div>
@endsection
