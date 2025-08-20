@extends('layouts.app')

@section('content')
    <h2>نتیجه پرداخت</h2>

    @if($status === 'Completed')
        <p style="color: green;">پرداخت موفق بود. شماره سفارش: {{ $order_id }}</p>
    @else
        <p style="color: red;">پرداخت ناموفق بود. لطفاً دوباره تلاش کنید.</p>
    @endif

    <a href="/menu">بازگشت به منو</a>
@endsection
