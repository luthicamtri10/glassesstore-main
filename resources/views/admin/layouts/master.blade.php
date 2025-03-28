<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>@yield('title')</title>

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/admin/admin.css', 'resources/js/admin/admin.js'])
</head>
<body>
    <div class="wrapper">
        @include('admin.includes.sidebar') <!-- Giữ sidebar ở đây -->
        <div class="main bg-light">
            @include('admin.includes.navbar')
            <div class="container mt-4" id="content">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
