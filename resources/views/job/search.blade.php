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

    <!-- Google Adsense -->
    <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <script>
      (adsbygoogle = window.adsbygoogle || []).push({
        google_ad_client: "ca-pub-4485968980278243",
        enable_page_level_ads: true
      });
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
        <div style="margin-bottom: 73px;">@include('layouts.nav')</div>

        <div id="left" style="margin-top: -13px; padding-bottom: 60px; background-color: white;">
            <div id="slide-out-blank-left" class="hidden-md hidden-lg" style="display: {{ $slideOutSearch ? '' : 'none' }};"></div>
            <div class="container" style="width: 100%">
                <div class="visible-xs-block" style="margin-top: 30px"></div>
                @if ($currentJob != null)
                    @foreach ($jobs as $job)
                        @include('job.search-left-content')
                    @endforeach
                @else
                    <br><br>
                    <div class="container card-shadow">
                        <div style="font-size: 20px; line-height: 40px;">
                            <h2>No jobs matching your keyword: <span style="font-weight: 600">{{ request('title') }}</span></h2>
                            <br>
                            <div style="font-weight: 600">Suggestions:</div>
                            <div>- Make sure all words are spelled correctly</div>
                            <div>- Try more general keywords</div>
                            <div>- Try different keywords</div>
                        </div>
                        <br><br><br><br><br><br>
                    </div>
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
            <div id="slide-out-blank-right" style="margin-bottom: 50px; display: {{ $slideOutSearch ? '' : 'none' }};"></div>
            <div style="padding-top:30px; background-color:#edeeee;">
                @include('layouts.error')
                @include('job.search-right-content')
                <br><br>
            </div>
		</div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
