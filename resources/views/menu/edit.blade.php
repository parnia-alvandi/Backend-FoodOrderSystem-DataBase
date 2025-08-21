@extends('layouts.app')

@section('content')
<h2>ویرایش غذا</h2>

<form method="POST" action="/menu/update/{{ $food['id'] }}">
    @csrf
    <input type="text" name="name" value="{{ $food['name'] }}" required>
    <input type="text" name="description" value="{{ $food['description'] }}" required>
    <input type="number" name="price" value="{{ $food['price'] }}" required>
    <button type="submit">ذخیره تغییرات</button>
</form>
@endsection
