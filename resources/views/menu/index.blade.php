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

                        @if(!empty($menu->discount) && $menu->discount > 0)
                            <p class="card-text text-danger">
                                <strong>تخفیف:</strong> {{ $menu->discount }}%
                            </p>
                        @endif

                        <p class="card-text"><strong>کامنت‌ها:</strong> {{ $menu->comments_count }}</p>
                        <p class="card-text"><strong>نظرسنجی‌ها:</strong> {{ $menu->surveys_count }}</p>

                        <a href="{{ route('menu.show', $menu->id) }}" class="btn btn-primary">مشاهده جزئیات</a>

                        @auth
                            <form action="{{ route('order.place') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                                <button type="submit" class="btn btn-success">سفارش سریع</button>
                            </form>
                        @endauth
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
