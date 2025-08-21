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

        @auth
            <a href="{{ route('order.checkout') }}" class="btn btn-outline-secondary">سفارش من</a>
        @endauth

        <div class="ms-auto">
            @if(session('success'))
                <span class="badge bg-success me-2">{{ session('success') }}</span>
            @endif
            @if(session('error'))
                <span class="badge bg-danger me-2">{{ session('error') }}</span>
            @endif

            @auth
                <span class="mx-2">سلام {{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">خروج</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="btn btn-success">ورود</a>
                <a href="{{ route('register') }}" class="btn btn-info text-white">ثبت‌نام</a>
            @endauth
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

</body>
</html>
