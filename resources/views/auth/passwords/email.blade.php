@extends('layouts.app')

@section('nav')
    @include('nav.main', ['theme' => 'white'])
@endsection

@section('content')

  <div id="loginModal" class="list-rows-wrapper" style="padding: 0 4%; color: white;">
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

      <form method="POST" action="{{ route('password.email') }}">

        {{ csrf_field() }}

        <h4 style="font-size: 1.7em;">重設密碼</h4>
        <div style="font-size: 1.1em;">
          <span style="font-weight: 500;">在 <span style="font-weight: bold">Hanime1.me</span> 上享受最愛的影片、崁入原創內容，並與全世界觀眾分享您的影片。</span>
          <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}" style="margin-top: 20px;">
            <input style="background-color: #131313; color: gray;" type="email" class="form-control" name="email" id="email" placeholder="電郵地址" required>
            @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
          </div>

          <button style="height: 45px; margin-top: 10px; font-size: 1em; background-color: red !important; border-color: red !important;" type="submit" class="btn btn-info" name="submit">驗證電郵地址並重設密碼</button>
        </div>

      </form>
  </div>

@endsection
