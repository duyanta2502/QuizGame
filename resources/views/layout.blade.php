<!-- layout.blade.php -->
<!DOCTYPE html>
<html lang="vi">
<head>
    @include('layouts/header') <!-- Include file header -->
</head>
<body>
    @include('layouts/menu') <!-- Include file menu -->

    <div class="container">
        @include('layouts/sidebar') <!-- Include file sidebar -->

        <div class="content-area">
            @yield('layouts/content') <!-- Phần nội dung động -->
        </div>
    </div>

    @include('layouts/footer') <!-- Include file footer -->
</body>
</html>
