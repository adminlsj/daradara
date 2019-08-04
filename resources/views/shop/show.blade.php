@extends('layouts.app')

@section('content')

<div>{{ $shop->name }}</div>

<br>

<div>介紹</div>
<div>{{ $shop->intro }}</div>

<br>

<div>菜單</div>

<br>

<div>優惠卷</div>

<br>

<div>評價</div>

<br>

<div>地址</div>
<div>{{ $shop->location }}</div>

<br>

<div>詳細情報</div>
<div>{{ $shop->category }}</div>

<br>

@endsection