@extends('layouts.app')

@section('title', 'تأیید سفارش')

@section('content')
<div class="container">
    <h1 class="mb-4">تأیید سفارش</h1>

    {{-- نمایش پیام موفقیت یا خطا --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    {{-- نمایش لیست غذاهای انتخاب‌شده --}}
    <h4>غذاهای سفارش‌داده‌شده:</h4>
    <ul class="list-group mb-3">
        @foreach($order->items as $item)
            <li class="list-group-item d-flex justify-content-between">
                <span>{{ $item->menu->name }} ({{ $item->quantity }} عدد)</span>
                <strong>{{ number_format($item->menu->price * $item->quantity) }} تومان</strong>
            </li>
        @endforeach
    </ul>

    {{-- نمایش مجموع قیمت --}}
    <p><strong>مبلغ کل:</strong> {{ number_format($order->total_price) }} تومان</p>

    {{-- فرم اعمال تخفیف --}}
    <form action="{{ route('order.checkout') }}" method="POST" class="mb-3">
        @csrf
        <input type="hidden" name="order_id" value="{{ $order->id }}">

        <div class="mb-3">
            <label for="discount_code" class="form-label">کد تخفیف</label>
            <input type="text" name="discount_code" id="discount_code" class="form-control"
                   placeholder="در صورت داشتن کد تخفیف وارد کنید">
        </div>

        <button type="submit" class="btn btn-warning">اعمال تخفیف</button>
    </form>

    {{-- دکمه پرداخت --}}
    <a href="{{ route('payment.process', $order->id) }}" class="btn btn-success">
        ادامه به پرداخت
    </a>
</div>
@endsection
