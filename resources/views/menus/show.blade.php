@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $menu->name }}</h1>
    <p>{{ $menu->description }}</p>
    <p><strong>قیمت:</strong> {{ $menu->price }} تومان</p>

    <h3>کامنت‌ها</h3>
    <ul>
        @foreach($menu->comments as $comment)
            <li>
                <strong>{{ $comment->user->name }}:</strong> {{ $comment->content }}
            </li>
        @endforeach
    </ul>

    <h3>نظرسنجی‌ها</h3>
    <ul>
        @foreach($menu->surveys as $survey)
            <li>
                <strong>{{ $survey->user->name }}:</strong> امتیاز {{ $survey->rating }}
            </li>
        @endforeach
    </ul>

    <a href="{{ route('menus.index') }}" class="btn btn-secondary mt-3">بازگشت به لیست منوها</a>
</div>
@endsection
