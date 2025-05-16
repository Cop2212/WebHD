@extends('layouts.app')

@section('title', 'Hồ sơ cá nhân')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-user-circle me-2"></i>Thông tin cá nhân</h4>
                </div>

                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            <div class="avatar-container mb-3">
                                <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&color=FFFFFF&background=4e73df' }}"
                                     class="rounded-circle img-thumbnail"
                                     width="150"
                                     height="150"
                                     alt="Avatar">
                                <button class="btn btn-sm btn-primary mt-3">
                                    <i class="fas fa-camera me-1"></i> Thay đổi
                                </button>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" class="form-control" value="{{ Auth::user()->email }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tên đăng nhập</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->username ?? 'Chưa cập nhật' }}" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Thêm form đổi mật khẩu tại đây -->
                    <div class="card mb-4 shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="fas fa-lock me-2"></i>Đổi mật khẩu</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('profile.update-password') }}" method="POST">
                                @csrf
                                @method('PATCH')

                                @if($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if(session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif

                                <div class="mb-3">
                                    <label class="form-label">Mật khẩu hiện tại</label>
                                    <input type="password" name="current_password"
                                           class="form-control @error('current_password') is-invalid @enderror">
                                    @error('current_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Mật khẩu mới</label>
                                    <input type="password" name="new_password"
                                           class="form-control @error('new_password') is-invalid @enderror">
                                    @error('new_password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Xác nhận mật khẩu mới</label>
                                    <input type="password" name="new_password_confirmation"
                                           class="form-control @error('new_password_confirmation') is-invalid @enderror">
                                    @error('new_password_confirmation')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Cập nhật mật khẩu
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Quay lại
                        </a>
                        <div>
        <a href="{{ route('questions.mine') }}" class="btn btn-info me-2">
            <i class="fas fa-question-circle me-1"></i> Câu hỏi của tôi
        </a>

        <a href="{{ route('profile.edit') }}" class="btn btn-primary">
            <i class="fas fa-edit me-1"></i> Chỉnh sửa
        </a>
    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
