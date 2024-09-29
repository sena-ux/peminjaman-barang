<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sidebar')|SAPA</title>
    <link rel="shortcut icon" href="{{ asset('sman2amlapura.ico') }}" type="image/x-icon">
    @stack('css')
    <link rel="stylesheet" href="{{ asset('admin/dashboard/css') }}/style.css">
</head>

<body>
    @include('admin.layouts.sidebar')
    <main>
        @include('admin.layouts.navbar')

        <div class="content">
            @yield('content')
            @include('admin.layouts.footer')
        </div>
    </main>
    <script src="{{ asset('admin/dashboard/js') }}/script.js"></script>
    @stack('js')
</body>

</html>