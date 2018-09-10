@extends('layouts.app')

@section('content')

<div style="padding-top:40px; background-color:#E6E6E6">
    <div id="showJob" class="container" style="background-color:white; width:80%; padding-left: 80px; padding-right: 80px; padding-top: 50px; padding-bottom: 90px;">
        <div style="font-size: 25px" id="job-company-name"> {{ $currentJob->company->name }} </div>
        <div style="font-size: 15px" id="job-company-description"> {{ $currentJob->company->description }} </div>
        <hr>
        <div style="font-size: 25px; text-align: center" id="job-title"> {{ $currentJob->title }} </div>
        <hr>
        <div style="font-size: 15px; font-weight: 600">Responsibilities:</div>
        <div id="job-responsibility"> {{ $currentJob->responsibility }} </div>
        <br>
        <div style="font-size: 15px; font-weight: 600">Requirements:</div>
        <div id="job-requirement"> {{ $currentJob->requirement }} </div>
        <br>
        <div style="font-size: 15px; font-weight: 600">All Personal data collected will be used for recruitment purpose only. </div>
        <br>

        <div class="row sidenav" style="margin-top: 5px">
            <div class="col-md-4 col-md-offset-4">
                <button type="submit" {{ $disabled }} class="btn btn-info btn-block">{{ $btn_text }}</button>
            </div>
        </div>
    </div>
    <br><br><br>
</div>

@endsection