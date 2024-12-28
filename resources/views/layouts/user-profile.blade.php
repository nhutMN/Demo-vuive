@extends('layouts.index')

@section('content')
<div class="container mt-5">
    <h2 class="text-center">Thông tin người dùng</h2>
    <div class="card">
        <div class="card-header bg-success text-white">Thông tin chi tiết</div>
        <div class="card-body">
            <p><strong>Họ và tên:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Vai trò:</strong> {{ $user->role ?? 'Người dùng' }}</p>
            <p><strong>Địa chỉ:</strong> {{ $user->address ?? 'Chưa cập nhật' }}</p>
            <p><strong>Số điện thoại:</strong> {{ $user->sdt ?? 'Chưa cập nhật' }}</p>
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#editProfileModal">Chỉnh sửa thông tin</a>
        </div>
    </div>

    <!-- Modal for editing user profile -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Chỉnh sửa thông tin người dùng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.update') }}" method="POST">
                        @csrf
                        <!-- Name input -->
                        <div class="form-group">
                            <label for="name">Họ và tên</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Email input -->
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Address input -->
                        <div class="form-group">
                            <label for="address">Địa chỉ</label>
                            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address', $user->address) }}">
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Phone number input -->
                        <div class="form-group">
                            <label for="sdt">Số điện thoại</label>
                            <input type="text" class="form-control @error('sdt') is-invalid @enderror" id="sdt" name="sdt" value="{{ old('sdt', $user->sdt) }}">
                            @error('sdt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <!-- Submit button -->
                        <button type="submit" class="btn btn-success mt-3">Cập nhật thông tin</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to ensure modal stays open when there are validation errors -->
<script>
    @if ($errors->any())
        $('#editProfileModal').modal('show');
    @endif
</script>

@endsection
