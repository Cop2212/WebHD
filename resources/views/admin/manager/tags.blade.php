@extends('layouts.admin')

@section('title', 'Danh sách thẻ')

@section('content')
<div class="card mb-4 border-0 shadow-sm">
    <div class="card-header bg-success text-white py-3">
        <h5 class="mb-0"><i class="fas fa-tags me-2"></i>Danh sách thẻ</h5>
    </div>
    <div class="card-body">
        {{-- Danh sách thẻ --}}
        <ul class="list-group">
            @foreach ($tags as $tag)

                <li class="list-group-item d-flex justify-content-between align-items-center">
                    @if (request('edit') == $tag->id)
                        {{-- Form chỉnh sửa --}}
                        <form action="{{ route('admin.tags.update', $tag->id) }}" method="POST" class="w-100 d-flex gap-2">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ old('name', $tag->name) }}" class="form-control" required>
                            <button class="btn btn-sm btn-success">Lưu</button>
                            <a href="{{ route('admin.tags') }}" class="btn btn-sm btn-secondary">Hủy</a>
                        </form>
                    @else
                        {{-- Hiển thị thông tin thẻ --}}
                        <span>{{ $tag->name }}</span>
                        <div class="d-flex gap-2">

                            <form action="{{ route('admin.tags.delete', $tag->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa thẻ này?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" data-bs-toggle="tooltip" title="Xóa">
                                    <i class="fas fa-trash-alt"></i> Xóa
                                </button>
                            </form>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>

        <hr>

        {{-- Form thêm mới --}}
        <form action="{{ route('admin.tags.store') }}" method="POST" class="mt-3">
    @csrf
    <div class="input-group">
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="Nhập tên thẻ mới" required value="{{ old('name') }}">
        <button class="btn btn-primary" type="submit">Thêm thẻ</button>
    </div>
    @error('name')
        <div class="invalid-feedback d-block mt-1">
            {{ $message }}
        </div>
    @enderror
</form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tooltips = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltips.map(el => new bootstrap.Tooltip(el));
    });
</script>
@endpush
