@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-2">{{ $menu->name }}</h1>
    <p>{{ $menu->description }}</p>
    <p><strong>قیمت:</strong> {{ number_format($menu->price) }} تومان</p>

    <div class="mb-3">
        @auth
            {{-- ✅ فرم سفارش سریع --}}
            <form action="{{ route('order.place') }}" method="POST" style="display:inline;">
                @csrf
                <input type="hidden" name="menu_id" value="{{ $menu->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-primary">سفارش سریع</button>
            </form>
        @else
            <a href="{{ route('login') }}" class="btn btn-primary">سفارش این آیتم</a>
        @endauth

        <a href="{{ route('menu.index') }}" class="btn btn-secondary">بازگشت به لیست</a>
    </div>

    <h3 class="h5 mt-4">کامنت‌ها</h3>
    <ul>
        @forelse($menu->comments as $comment)
            <li><strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}</li>
        @empty
            <li>کامنتی ثبت نشده است.</li>
        @endforelse
    </ul>

    <h3 class="h5 mt-4">نظرسنجی‌ها</h3>
    <ul>
        @forelse($menu->surveys as $survey)
            <li><strong>{{ $survey->user->name }}:</strong> امتیاز {{ $survey->rating }}</li>
        @empty
            <li>نظرسنجی‌ای ثبت نشده است.</li>
        @endforelse
    </ul>
</div>
@endsection
