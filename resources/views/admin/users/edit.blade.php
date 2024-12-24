@extends('admin.index')
@section('title', 'Chỉnh sửa người dùng')
@section('content')
<div class="content">
    <h2>Chỉnh sửa người dùng</h2>
    <form action="{{ route('admin.user.update', $user->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Tên</label>
            <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Mật khẩu (để trống nếu không đổi)</label>
            <input type="password" name="password" class="form-control">
        </div>
        <div class="form-group">
            <label>Vai trò</label>
            <select name="role" class="form-control" required>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Lưu thay đổi</button>
    </form>
</div>
@endsection
