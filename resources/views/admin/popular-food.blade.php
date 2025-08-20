@extends('layouts.app')

@section('content')
<h2>غذاهای پرطرفدار</h2>

<ul>
    @foreach($popular as $food)
        <li>{{ $food['name'] }} — {{ $food['count'] }} سفارش</li>
    @endforeach
</ul>
@endsection
