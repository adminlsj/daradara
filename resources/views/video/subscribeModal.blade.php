<div style="padding:125px" class="modal fade" id="subscribeModal" tabindex="-1" role="dialog" aria-labelledby="subscribeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">

    <form id="subscribe-form" action="{{ route('video.subscribe') }}" method="POST">

      {{ csrf_field() }}

      <div style="padding: 10px;" class="modal-content">
        <div style="border: 0px; position: relative;" class="modal-header">
          <h4 style="color: gray;font-weight: 100; transform: rotate(45deg);position: absolute; font-size: 3em; top: -10px; cursor: pointer;" class="no-select" data-dismiss="modal">+</h4>
          <h4 style="color: #3F3F3F; margin-bottom: 0px; margin-top: 40px; font-size: 1.7em" class="modal-title" id="subscribeModalLabel">開始訂閱《{{ $video->watch()->title }}》</h4>
        </div>
        <div style="color: #3F3F3F; margin-top: -15px; font-weight: 500; font-size: 1.1em" class="modal-body">
          訂閱通知將發送至你的電郵地址。
          <div class="form-group" style="margin-top: 20px;">
            <input type="email" class="form-control" name="email" id="email" value="{{ Auth::user()->email }}" placeholder="電郵地址">
          </div>

          <input name="subscribe-watch-id" type="hidden" value="{{ $video->watch()->id }}">
          <input name="subscribe-user-id" type="hidden" value="{{ Auth::user()->id }}">
          <button style="height: 45px; margin-top: 10px;" type="submit" class="btn btn-info" name="submit">訂閱</button>
        </div>
      </div>

    </form>

  </div>
</div>