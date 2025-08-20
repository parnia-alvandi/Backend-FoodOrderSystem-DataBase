@extends('layouts.app')

@section('content')
<h2>گزارش وضعیت سفارشات</h2>
<ul>
    @foreach($grouped as $status => $count)
        <li>{{ $status }}: {{ $count }} سفارش</li>
    @endforeach
</ul>
@endsection
