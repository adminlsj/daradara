@extends('layouts.app')

@section('nav')
    @include('nav.md')
@endsection

@section('content')
  <div id="signUpModal" class="list-rows-wrapper" style="padding: 0 13.6%; color: white;">
    <form action="{{ route('register') }}" method="POST">

      {{ csrf_field() }}
      {{ Session::put('previousUrl', '/') }}

      <h4 style="font-size: 1.7em">Register</h4>
      <div style="font-size: 1.1em">
        <span style="font-weight: 500;">Upload, store, and share your files on <span style="font-weight: bold">SwiftShare.org</span>. All in a Swift.</span>
        <div class="form-group" style="margin-top: 20px;">
          <input style="background-color: #131313; color: gray;" type="email" class="form-control" name="email" id="email" placeholder="Email address" required>
        </div>
        <div class="form-group">
          <input style="background-color: #131313; color: gray;" type="text" class="form-control" name="name" id="name" placeholder="Name" required>
        </div>
        <div class="form-group">
          <input style="background-color: #131313; color: gray;" type="password" class="form-control" name="password" id="password" placeholder="Password" required>
        </div>
        <button style="height: 45px; margin-top: 10px; font-size: 1em; background-color: red !important; border-color: red !important;" type="submit" class="btn btn-info" name="submit">Sign up</button>

        @include('layouts.socialLoginBtn')

        <div style="margin-top: 20px; font-size: 0.95em">
          <span style="font-weight: 400">Already have a SwiftShare account?</span>&nbsp;<a href="{{ route('login') }}" style="cursor: pointer; text-decoration: none; font-weight: 500;">Login</a>
        </div>
      </div>

    </form>
  </div>

  <br>

  @include('layouts.footer')
@endsection
