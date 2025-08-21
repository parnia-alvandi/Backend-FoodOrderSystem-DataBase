@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $menu->name }}</h1>
    <p>{{ $menu->description }}</p>
    <p><strong>قیمت:</strong> {{ number_format($menu->price) }} تومان</p>

    @if(!empty($menu->discount) && $menu->discount > 0)
        <p class="text-danger"><strong>تخفیف:</strong> {{ $menu->discount }}%</p>
    @endif

    @auth
        <form action="{{ route('order.place') }}" method="POST" class="mt-3">
            @csrf
            <input type="hidden" name="menu_id" value="{{ $menu->id }}">
            <button type="submit" class="btn btn-success">سفارش غذا</button>
        </form>
    @endauth

    <hr>

    <h3>کامنت‌ها</h3>
    <ul>
        @forelse($menu->comments as $comment)
            <li>
                <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
            </li>
        @empty
            <li>کامنتی ثبت نشده است.</li>
        @endforelse
    </ul>

    <h3>نظرسنجی‌ها</h3>
    <ul>
        @forelse($menu->surveys as $survey)
            <li>
                <strong>{{ $survey->user->name }}:</strong> امتیاز {{ $survey->rating }}
            </li>
        @empty
            <li>نظرسنجی ثبت نشده است.</li>
        @endforelse
    </ul>

    <a href="{{ route('menu.index') }}" class="btn btn-secondary mt-3">بازگشت به لیست منوها</a>
</div>
@endsection
