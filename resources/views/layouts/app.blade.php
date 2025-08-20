<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8" />
    <title>@yield('title', 'سیستم سفارش غذا')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    {{-- Bootstrap --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

    <nav class="mb-4 d-flex gap-2 align-items-center">
        <a href="{{ route('home') }}" class="btn btn-outline-primary">خانه</a>
        <a href="{{ route('menu.index') }}" class="btn btn-outline-primary">منو</a>

        <div class="ms-auto">
            @if(auth()->check())
                <span class="mx-2">سلام {{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">خروج</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-success">ورود</a>
                <a href="{{ route('register') }}" class="btn btn-info text-white">ثبت‌نام</a>
            @endif
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    {{-- Bootstrap JS (optional) --}}    {{--این قسمت هنوز باگ داره و باید درست شه--}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
