@extends('layouts.app')

@section('content')
<h2>افزودن غذا</h2>

<form method="POST" action="/menu/store">
    @csrf
    <input type="text" name="name" placeholder="نام غذا" required>
    <input type="text" name="description" placeholder="توضیح" required>
    <input type="number" name="price" placeholder="قیمت (تومان)" required>
    <button type="submit">ثبت</button>
</form>
@endsection
