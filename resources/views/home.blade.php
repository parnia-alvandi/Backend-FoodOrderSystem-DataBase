@extends('layouts.app')

@section('content')
<div class="p-4 bg-light rounded">
    <h1 class="h4 mb-3">به سیستم سفارش غذا خوش آمدید</h1>
    <p class="mb-3">از منوی بالا وارد «منو» شوید و غذای موردنظرتان را سفارش دهید.</p>
    <a class="btn btn-primary" href="{{ route('menu.index') }}">رفتن به منو</a>
</div>
@endsection
