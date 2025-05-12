<div class="card mb-4">
    <div class="card-header bg-success text-white">Danh sách thẻ</div>
    <div class="card-body">
        <ul class="list-group">
            @foreach ($tags as $tag)
                <li class="list-group-item d-flex justify-content-between">
                    <span>{{ $tag->name }}</span>
                    <!-- Nút xóa thẻ -->
                    <form action="{{ route('admin.tags.delete', $tag->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
</div>
