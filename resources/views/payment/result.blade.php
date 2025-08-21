@extends('layouts.app')

@section('content')
<div class="container text-center">
    <h1 class="mb-4">نتیجه پرداخت</h1>

    @if($status === 'success')
        <div class="alert alert-success">
            پرداخت شما با موفقیت انجام شد ✅
        </div>
    @else
        <div class="alert alert-danger">
            پرداخت ناموفق بود ❌
        </div>
    @endif

    <p><strong>شماره سفارش:</strong> {{ $order->id }}</p>
    <p><strong>مبلغ سفارش:</strong> {{ number_format($order->total_amount) }} تومان</p>

    <a href="{{ route('menu.index') }}" class="btn btn-primary mt-3">
        بازگشت به منو
    </a>
</div>
@endsection
