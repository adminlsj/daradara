<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-78314014-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-78314014-1');
    </script>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div style="margin-bottom: 73px;">@include('layouts.nav-search')</div>

        <div class="hidden-xs" id="left" style="margin-top: -13px; padding-bottom: 60px; background-color: white;">
            <div class="container" style="width: 100%">
                <div class="visible-xs-block" style="margin-top: 30px"></div>
                @if ($currentJob != null)
                    @foreach ($jobs as $job)
                        <div style="position: relative;" class="row selectJobContainer">
                            <form id="selectJob{{ $job->id }}" action="{{route('job.select', ['job' => $job->id])}}" method="POST">
                                {{ csrf_field() }}
                                <button id="selectJobBtn{{ $job->id }}" type="submit" style="cursor:pointer; width:100%; padding:15px 30px; text-align:left; border:none; border-bottom: 1px solid #E6E6E6; {{ $currentJob->id == $job->id ? 'background-color:#d84b6b; color:white':'' }}">
                                    <div><a id="selectJobTitle{{ $job->id }}" style="{{ $currentJob->id == $job->id ? 'color:white;':'color:#d84b6b;' }}font-size: 18px;" href="{{ route('job.show', ['job' => $job->id]) }}" target="_blank">{{ str_limit($job->title, 32) }}</a></div>
                                    <div> {{ $job->company->name }}</div>
                                    <div> {{ $job->location }} </div>
                                    <div> {{ $job->created_at->diffForHumans() }}<span style="font-weight: 600" class="pull-right">${{ $job->salary }} / 月</span></div>
                                    <input type="hidden" id="currentId" name="currentId" value="{{$currentJob->id}}">
                                </button>
                            </form>
                            @include('job.save-job-form-left')
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="search-pagination container" style="width: 90%; text-align: center">
                <div style="display: none">{{ $jobs->appends(['title' => request('title'), 'category' => request('category'), 'location' => request('location'), 'salary' => request('salary'), 'endDate' => request('endDate'), 'experience' => request('experience'), 'level' => request('level'), 'type' => request('type'), 'education' => request('education')])->links() }}</div>

                @if ($jobs->hasPages())
                    <ul class="pagination pagination">
                        {{-- Previous Page Link --}}
                        @if ($jobs->onFirstPage())
                            <li class="disabled"><span>«</span></li>
                        @else
                            <li><a href="{{ $jobs->previousPageUrl() }}" rel="prev">«</a></li>
                        @endif

                        @if($jobs->lastPage() <= 5)
                            @foreach(range(1, $jobs->lastPage()) as $i)
                                @if ($i == $jobs->currentPage())
                                    <li class="active"><span>{{ $i }}</span></li>
                                @else
                                    <li><a href="{{ $jobs->url($i) }}">{{ $i }}</a></li>
                                @endif
                            @endforeach
                        @elseif($jobs->currentPage() <= 3)
                            @foreach(range(1, 5) as $i)
                                @if ($i == $jobs->currentPage())
                                    <li class="active"><span>{{ $i }}</span></li>
                                @else
                                    <li><a href="{{ $jobs->url($i) }}">{{ $i }}</a></li>
                                @endif
                            @endforeach
                        @elseif($jobs->currentPage() > 3 && $jobs->currentPage() <= $jobs->lastPage() - 2)
                            @foreach(range($jobs->currentPage() - 2, $jobs->currentPage() + 2) as $i)
                                @if ($i == $jobs->currentPage())
                                    <li class="active"><span>{{ $i }}</span></li>
                                @else
                                    <li><a href="{{ $jobs->url($i) }}">{{ $i }}</a></li>
                                @endif
                            @endforeach
                        @elseif($jobs->currentPage() > $jobs->lastPage() - 2)
                            @foreach(range($jobs->lastPage() - 4, $jobs->lastPage()) as $i)
                                @if ($i == $jobs->currentPage())
                                    <li class="active"><span>{{ $i }}</span></li>
                                @else
                                    <li><a href="{{ $jobs->url($i) }}">{{ $i }}</a></li>
                                @endif
                            @endforeach
                        @endif

                        {{-- Next Page Link --}}
                        @if ($jobs->hasMorePages())
                            <li><a href="{{ $jobs->nextPageUrl() }}" rel="next">»</a></li>
                        @else
                            <li class="disabled"><span>»</span></li>
                        @endif
                    </ul>
                @endif
            </div>
		</div>

		<div id="right" style="margin-top: -13px;">
            <div id="slide-out-blank" style="margin-bottom: 50px; display: {{ $slideOutSearch ? '' : 'none' }};"></div>
            <div style="padding-top:30px; background-color:#edeeee;">
                @include('layouts.error')
                @include('job.search-right-content')
                <br><br>
            </div>
            <nav class="visible-xs-block navbar navbar-default navbar-fixed-top" style="border-top: solid 1px #E6E6E6; border-bottom: solid 1px #E6E6E6; height: 30px; margin-top: 60px;">
                @include('job.search-left-mobile')
            </nav>
		</div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
