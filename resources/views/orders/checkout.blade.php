@extends('layouts.app')

@section('content')
<h2>بررسی سفارش</h2>

@if(count($foods) > 0)
    <ul>
        @foreach($foods as $item)
            <li>{{ $item['name'] }} - {{ $item['price'] }} تومان</li>
        @endforeach
    </ul>

    <p><strong>جمع کل: {{ $total }} تومان</strong></p>

    <form method="POST" action="{{ route('order.place') }}">
        @csrf

        @foreach($selectedItems as $id)
            <input type="hidden" name="items[]" value="{{ $id }}">
        @endforeach

        <label>کد تخفیف (اختیاری):</label>
        <input type="text" name="discount_code" placeholder="مثلاً: SAVE10">

        <br><br>
        <button type="submit">ثبت نهایی سفارش و پرداخت</button>
    </form>
@else
    <p>هیچ غذایی انتخاب نشده است.</p>
    <a href="{{ route('menu.index') }}">بازگشت به منو</a>
@endif
@endsection
