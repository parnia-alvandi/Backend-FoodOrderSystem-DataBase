@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">لیست منوها</h1>

    <div class="row">
        @foreach($menus as $menu)
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $menu->name }}</h5>
                        <p class="card-text">{{ $menu->description }}</p>
                        <p class="card-text"><strong>قیمت:</strong> {{ number_format($menu->price) }} تومان</p>
                        <p class="card-text"><strong>کامنت‌ها:</strong> {{ $menu->comments_count }}</p>
                        <p class="card-text"><strong>نظرسنجی‌ها:</strong> {{ $menu->surveys_count }}</p>

                        <div class="d-flex gap-2">
                            <a href="{{ route('menu.show', $menu->id) }}" class="btn btn-outline-secondary">جزئیات</a>
                            @auth
                                <a href="{{ route('order.checkout', ['menu_id' => $menu->id]) }}" class="btn btn-primary">
                                    سفارش سریع
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-primary">سفارش سریع</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-3">
        {{ $menus->links() }}
    </div>
</div>
@endsection
