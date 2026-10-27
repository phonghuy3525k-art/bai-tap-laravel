<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách bài viết</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Danh sách bài viết</h1>
            <!-- Khớp với route('post.create') trong web.php của bạn -->
            <a href="{{ route('post.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700">Viết bài mới</a>
        </div>

        @if(session('success'))
            <div class="mb-4 p-4 bg-emerald-50 text-emerald-700 rounded-lg border border-emerald-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="space-y-6">
            @foreach($danhSachBaiViet as $item)
                <div class="bg-white border border-gray-200 p-5 rounded-xl shadow-sm flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                    <div class="flex-1">
                        <span class="text-xs text-indigo-600 font-semibold">Tác giả: {{ $item->user->name ?? 'Ẩn danh' }}</span>
                        <h3 class="text-xl font-bold text-gray-800 mt-1">{{ $item->title }}</h3>
                        <p class="text-gray-600 mt-2 text-sm">{{ $item->content }}</p>
                        
                        @if($item->image)
                            <div class="mt-3">
                                <img src="{{ asset('storage/' . $item->image) }}" class="w-40 h-28 object-cover rounded-lg shadow-sm" alt="Ảnh bài viết">
                            </div>
                        @endif
                    </div>

                    <div class="flex items-center space-x-2">
                        @auth
                            @if(auth()->id() === $item->user_id)
                                <!-- Khớp với route('post.edit') -->
                                <a href="{{ route('post.edit', $item->id) }}" class="px-3 py-1.5 bg-amber-500 text-white text-xs font-medium rounded-lg shadow hover:bg-amber-600">Sửa</a>
                                
                                <!-- Khớp với route('post.destroy') -->
                                <form action="{{ route('post.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc muốn xóa bài viết này?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1.5 bg-rose-500 text-white text-xs font-medium rounded-lg shadow hover:bg-rose-600">Xóa</button>
                                </form>
                            @endif
                        @endauth
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $danhSachBaiViet->links() }}
        </div>
    </div>
</body>
</html>