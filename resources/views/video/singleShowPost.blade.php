@include('video.player')

<div style="background-color: #f9f9f9; padding-top: 7px; padding-bottom: 9px;" class="padding-setup">
    <p style="font-size: 0.9em; padding-bottom: 2px;">
      @foreach ($video->tags() as $tag)
        @if (strpos($tag, '完整版') !== false)
          <a style="color:#a9a9a9" href="{{ route('video.watch') }}?v={{ App\Video::where('category', $video->category)->orderBy('created_at', 'desc')->first()->id }}">#{{ $tag }}</a>
        @else
          <a style="color:#a9a9a9" href="{{ route('video.search') }}?query={{ $tag }}">#{{ $tag }}</a>
        @endif
      @endforeach
    </p>

    <a id="shareBtn-link" href="{{ route('video.watch') }}?v={{ $video->id }}" style="text-decoration: none; pointer-events: none;">
      <h4 id="shareBtn-title" style="line-height: 23px; font-weight: 500; margin-top:-10px; margin-bottom: 0px; color: #323232; font-size: 1.25em">{{ $video->title }}</h4>
    </a>

    <p style="color: #a9a9a9; margin-top: 10px; margin-bottom: 2px; font-size: 0.85em;">
      <i style="vertical-align:middle; font-size: 1.2em; margin-top: -2px; margin-right: 3px;" class="material-icons">remove_red_eye</i>{{ $video->views() }}次 • {{ Carbon\Carbon::parse($video->created_at)->format('Y-m-d') }}
    </p>

    <div id="toggleVideoDescription" style="margin-top: -31px; padding-top:10px; padding-right:2px;cursor: pointer; color: gray;" class="pull-right"><i id="toggleVideoDescriptionIcon" class="material-icons noselect">expand_more</i></div>

    <a style="margin-top: -26px; margin-right: 11px; padding-right:3px; cursor: pointer;" class="pull-right" data-toggle="modal" data-target="#reportModal">
      <i style="color: gray;" class="material-icons pull-right noselect">flag</i>
    </a>

    <a id="shareBtn" style="margin-top: -26px; margin-right:9px; padding-right:7px; cursor: pointer; text-decoration: none;" class="pull-right">
      <i style="color: gray;-moz-transform: scale(-1, 1);-webkit-transform: scale(-1, 1);-o-transform: scale(-1, 1);-ms-transform: scale(-1, 1);transform: scale(-1, 1);" class="material-icons pull-right noselect">reply</i>
    </a>

    <!-- Modal -->
    <div style="padding: 150px;" class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div style="padding: 10px;" class="modal-content">
          <div style="border: 0px;" class="modal-header">
            <h4 style="color: black; margin-bottom: 0px;" class="modal-title" id="reportModalLabel">無法觀看這部影片嗎？</h4>
          </div>
          <div style="color: gray; font-weight: 300; margin-top: -15px;" class="modal-body">
            感謝您向我們提供意見或回報任何錯誤。
          </div>
          <div style="border: 0px; margin-bottom: -10px; font-size: 1.05em;" class="modal-footer">
            <a style="width: auto; background-color: white; border: 0px; color: black; font-weight: 400;" class="btn btn-primary" data-dismiss="modal">取消</a>
            <a rel="nofollow" href="{{ route('email.userReport') }}?v={{ $video->id }}" style="width: auto; background-color: white; border: 0px; color: #d84b6b; font-weight: 400;" class="btn btn-primary">提交</a>
          </div>
        </div>
      </div>
    </div>

    <div id="videoDescription" style="display: none; margin-top: 10px;">
      <p style="white-space: pre-wrap; color: gray; margin-bottom: 4px;">{{ $video->caption }}</p>
    </div>
</div>​