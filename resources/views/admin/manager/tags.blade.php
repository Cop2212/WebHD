<div class="card mb-4">
    <div class="card-header bg-success text-white">Danh sách thẻ</div>
    <div class="card-body">
        <ul class="list-group">
            @foreach ($tags as $tag)
                <li class="list-group-item">{{ $tag->name }}</li>
            @endforeach
        </ul>
    </div>
</div>
