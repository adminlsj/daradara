@extends('layouts.app')

@section('nav')
@include('layouts.nav')
@endsection

@section('content')
<div class="flex-column user-profile" style="background-color:rgb(237,241,245);">
    @include('user.show.userProfile')
    @include('user.show.navTabs')

    <div class="likes">
        <div class="likes-anime">
            <div class="likes-heading">
                <h4>動畫</h4>
                <button>重新排序</button>
            </div>
            <div class="likes-grid">
                <div class="likes-card">
                    <a href=""><img src="https://i.meee.com.tw/tXI61LZ.jpg" alt=""></a>
                </div>
                <div class="likes-card">
                    <a href=""><img src="https://i.meee.com.tw/CwT5WII.webp" alt=""></a>
                </div>
                <div class="likes-card">
                    <a href=""><img src="https://i.meee.com.tw/PRr5kKS.jpeg" alt=""></a>
                </div>
                <div class="likes-card">
                    <a href=""><img src="https://i.meee.com.tw/Qya6Ki8.png" alt=""></a>
                </div>
                <div class="likes-card">
                    <a href=""><img src="https://i.meee.com.tw/GTeSnSY.jpeg" alt=""></a>
                </div>
                <div class="likes-card">
                    <a href=""><img src="https://i.meee.com.tw/GTeSnSY.jpeg" alt=""></a>
                </div>
                <div class="likes-card">
                    <a href=""><img src="https://i.meee.com.tw/GTeSnSY.jpeg" alt=""></a>
                </div>
                <div class="likes-card">
                    <a href=""><img src="https://i.meee.com.tw/GTeSnSY.jpeg" alt=""></a>
                </div>
                <div class="likes-card">
                    <a href=""><img src="https://i.meee.com.tw/GTeSnSY.jpeg" alt=""></a>
                </div>
                <div class="likes-card">
                    <a href=""><img src="https://i.meee.com.tw/GTeSnSY.jpeg" alt=""></a>
                </div>
            </div>
        </div>

        <div class="likes-characters">
            <div class="likes-heading">
                <h4>角色</h4>
                <button>重新排序</button>
            </div>
            <div class="likes-grid">
                <div class="likes-card">
                    <a href=""><img src="https://i.meee.com.tw/afyG25x.jpg" alt=""></a>
                </div>
                <div class="likes-card">
                    <a href=""><img src="https://i.meee.com.tw/jZlIxXs.jpg" alt=""></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection