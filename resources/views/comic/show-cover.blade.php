@extends('layouts.app')

@section('nav')
  @include('nav.main')
@endsection

@section('content')
<div style="margin-left: 4%; margin-right: 4%; background-color: #222222; border-radius: 5px; padding: 30px;">
  <div class="row">
    <div class="col-md-4">
      <a href="{{ route('comic.showContent', ['comic' => $comic, 'page' => 1]) }}">
        <img class="lazy" style="border-radius: 5px; width: 100%;" src="https://t.nhentai.net/galleries/{{ $comic->galleries_id }}/cover.jpg" data-src="https://i.nhentai.net/galleries/{{ $comic->galleries_id }}/1.jpg" data-srcset="https://i.nhentai.net/galleries/{{ $comic->galleries_id }}/1.jpg">
      </a>
    </div>
    <div class="col-md-8">
      <h3 class="title" style="margin: 0; margin-top: -5px; line-height: 30px;">
        <span class="before" style="color: #999">{{ $comic->title_n_before }}</span>
        <span class="pretty" style="color: white">{{ $comic->title_n_pretty }}</span>
        <span class="after" style="color: #999">{{ $comic->title_n_after }}</span>
      </h3>
      <br>
      <h4 class="title" style="margin:0; line-height: 30px;">
        <span class="before" style="color: #999">{{ $comic->title_o_before }}</span>
        <span class="pretty" style="color: white">{{ $comic->title_o_pretty }}</span>
        <span class="after" style="color: #999">{{ $comic->title_o_after }}</span>
      </h4>

      <br>
      <h5 style="color: #999">#<span style="color: #d9d9d9">{{ $comic->id }}</span></h5>
      <br>

      @foreach ($metadata as $key => $value)
        @if ($value)
          <h5 style="margin:0; color: #d9d9d9;">{{ $key }}：
            @foreach ($value as $data)
              <div class="no-select" style="background-color: #4d4d4d; padding: 4px 7px; border-radius: 5px; color: #d9d9d9; cursor: pointer; display: inline-block; margin-bottom: 4px">{{ $data }}</div>
            @endforeach
          </h5>
        @endif
      @endforeach

      <h5 style="margin:0; color: #d9d9d9;">頁數：
        <div class="no-select" style="background-color: #4d4d4d; padding: 4px 7px; border-radius: 5px; color: #d9d9d9; cursor: pointer; display: inline-block; margin-bottom: 4px">{{ $comic->pages }}</div>
      </h5>

      <h5 style="margin:0; color: #d9d9d9;">上傳：
        <div class="no-select" style="background-color: #4d4d4d; padding: 4px 7px; border-radius: 5px; color: #d9d9d9; cursor: pointer; display: inline-block; margin-bottom: 4px">{{ Carbon\Carbon::parse($comic->created_at)->diffForHumans() }}</div>
      </h5>

      <br>

      <button class="no-select" style="background-color: crimson; border: none; color: #d9d9d9; border-radius: 5px; padding: 10px 20px 10px 18px;">
        <span style="vertical-align: middle; font-size: 18px; margin-top: -3px; margin-right: 5px; cursor: pointer;" class="material-icons">favorite</span>加入最愛
      </button>
      <button class="no-select" style="background-color: #4d4d4d; border: none; color: #d9d9d9; border-radius: 5px; padding: 10px 20px 10px 15px;">
        <span style="vertical-align: middle; font-size: 20px; margin-top: -3px; margin-bottom: -2px; margin-right: 5px; cursor: pointer;" class="material-icons">download</span>下載
      </button>
    </div>
  </div>
</div>

<div style="margin-left: 4%; margin-right: 4%; margin-top: 30px; background-color: #222222; border-radius: 5px; padding: 30px;">
  @for ($i = 1; $i <= $comic->pages; $i++)
    <a href="{{ route('comic.showContent', ['comic' => $comic, 'page' => $i]) }}">
      <img style="border-radius: 5px; width: calc(100% / 6 - 4px); margin-bottom: 4px;" src="https://t.nhentai.net/galleries/{{ $comic->galleries_id }}/{{ $i }}t.jpg">
    </a>
  @endfor
</div>

<div style="margin-left: 4%; margin-right: 4%; margin-top: 30px; background-color: #222222; border-radius: 5px; padding: 30px;">
  <div id="comic-rows-wrapper" style="position: relative; margin: 0; padding: 0;">
    <h3 style="margin-bottom: 20px; text-align: center; color: #d9d9d9;">更多相關漫畫</h3>

    @foreach ($related as $comic)
      <a style="text-decoration: none;" href="{{ route('comic.showCover', ['comic' => $comic->id]) }}">
        <div class="comic-rows-videos-div" style="position: relative; display: inline-block; margin-bottom: 0px">
          <img style="border-radius: 5px;" src="https://t.nhentai.net/galleries/{{ $comic->galleries_id }}/cover.jpg">
          <div class="comic-rows-videos-title" style="position:absolute; bottom:0; left:0; white-space: initial; overflow: hidden;text-overflow: ellipsis; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; color: white; width: 100%; padding: 3px 5px; background: linear-gradient(to bottom, transparent 0%, black 120%);">{{ $comic->title_o_pretty }}</div>
        </div>
      </a>
    @endforeach
  </div>
</div>
@endsection