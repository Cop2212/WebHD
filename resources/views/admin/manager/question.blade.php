<div class="card mb-4">
    <div class="card-header bg-dark text-white">Danh sách câu hỏi</div>
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tiêu đề</th>
                    <th>Người đăng</th>
                    <th>Ngày tạo</th>
                    <th>Thao tác</th> <!-- Cột thao tác cho nút xóa -->
                </tr>
            </thead>
            <tbody>
                @foreach ($questions as $question)
                    <tr>
                        <td>{{ $question->id }}</td>
                        <td>{{ $question->title }}</td>
                        <td>{{ $question->user->name ?? 'Không rõ' }}</td>
                        <td>{{ $question->created_at->format('d/m/Y') }}</td>
                        <td>
                            <form action="{{ route('admin.questions.delete', $question->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa câu hỏi này?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
