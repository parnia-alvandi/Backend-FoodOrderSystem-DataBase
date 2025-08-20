@extends('layouts.app')

@section('content')
<h2>گزارش پرداخت‌ها</h2>

<table border="1" cellpadding="6">
    <thead>
        <tr>
            <th>شماره سفارش</th>
            <th>کاربر</th>
            <th>مبلغ (تومان)</th>
            <th>وضعیت</th>
            <th>تاریخ</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payments as $p)
            <tr>
                <td>{{ $p['order_id'] }}</td>
                <td>{{ $p['user_id'] }}</td>
                <td>{{ $p['amount'] }}</td>
                <td>{{ $p['payment_status'] }}</td>
                <td>{{ $p['payment_date'] }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
