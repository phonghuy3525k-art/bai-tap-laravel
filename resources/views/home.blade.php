<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang Chủ Blog Tin Tức</title>
    <!-- Sử dụng Tailwind CSS qua CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

    <!-- 1. HEADER -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-4 flex justify-between items-center">
            <a href="/" class="text-2xl font-bold text-indigo-600">MyBlog.</a>
            <nav class="hidden md:flex space-x-6 font-medium">
                <a href="/" class="text-indigo-600">Trang chủ</a>
                <a href="#" class="hover:text-indigo-600">Công nghệ</a>
                <a href="#" class="hover:text-indigo-600">Đời sống</a>
            </nav>
            <div>
                <a href="#" class="bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700">Tài khoản</a>
            </div>
        </div>
    </header>

    <!-- 2. HERO / BANNER NỔI BẬT -->
    <section class="bg-indigo-900 text-white py-16">
        <div class="container mx-auto px-4 text-center">
            <span class="bg-indigo-700 text-xs uppercase px-3 py-1 rounded-full font-semibold">Nổi bật</span>
            <h1 class="text-4xl md:text-5xl font-bold mt-4 mb-4">Khám phá thế giới công nghệ và lập trình hiện đại</h1>
            <p class="text-indigo-200 max-w-2xl mx-auto mb-6">Cập nhật những bài viết mới nhất từ hệ thống cơ sở dữ liệu Laravel.</p>
        </div>
    </section>

    <!-- 3. MAIN CONTENT (Chia 2 cột: Nội dung chính + Sidebar) -->
    <main class="container mx-auto px-4 py-10 grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Cột chính bên trái (70%): Danh sách bài viết động từ Database -->
        <div class="lg:col-span-2 space-y-6">
            <h2 class="text-2xl font-bold border-b pb-2">Bài viết mới nhất</h2>

            @foreach($posts as $post)
            <article class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row gap-4">
                <div class="md:w-1/3 bg-gray-200 rounded-lg h-40 flex items-center justify-center text-gray-400">Hình ảnh</div>
                <div class="md:w-2/3 flex flex-col justify-between">
                    <div>
                        <span class="text-xs text-indigo-600 font-semibold uppercase">Bài viết</span>
                        <!-- Tiêu đề click vào sẽ chuyển sang trang chi tiết -->
                        <h3 class="text-xl font-bold mt-1 hover:text-indigo-600">
                            <a href="/posts/{{ $post->id }}">{{ $post->title }}</a>
                        </h3>
                        <p class="text-gray-600 text-sm mt-2">{{ Str::limit($post->content, 100) }}</p>
                    </div>
                    <div class="flex items-center text-xs text-gray-500 mt-4 space-x-4">
                        <span>👤 Tác giả: {{ $post->author_name }}</span>
                        <span>📅 {{ date('d/m/Y', strtotime($post->created_at)) }}</span>
                    </div>
                </div>
            </article>
            @endforeach
        </div>

        <!-- Cột Sidebar bên phải (30%) -->
        <aside class="space-y-6">
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100">
                <h3 class="font-bold text-lg mb-3">Tìm kiếm</h3>
                <div class="flex">
                    <input type="text" placeholder="Nhập từ khóa..." class="w-full border rounded-l-lg px-3 py-2 text-sm focus:outline-none">
                    <button class="bg-indigo-600 text-white px-4 rounded-r-lg text-sm">🔍</button>
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 text-center">
                <div class="w-20 h-20 bg-gray-300 rounded-full mx-auto mb-3"></div>
                <h3 class="font-bold text-lg">Quản trị viên</h3>
                <p class="text-sm text-gray-600 mt-1">Chuyên trang chia sẻ kiến thức lập trình.</p>
            </div>
        </aside>

    </main>

    <!-- 4. FOOTER -->
    <footer class="bg-gray-900 text-gray-400 py-8 mt-12">
        <div class="container mx-auto px-4 text-center text-sm">
            <p>&copy; 2026 MyBlog. Bản quyền thuộc về bạn.</p>
        </div>
    </footer>

</body>
</html>