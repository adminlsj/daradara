<div id="reportModal" class="modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
        <h4 class="modal-title">影片報錯</h4>
      </div>

        @if ($country_code == 'CN' || $country_code == 'MY')
          <div class="modal-body" style="text-align: left">
            <div style="padding: 15px 15px; color: maroon; background-color: pink; border: 1px solid lightpink; border-radius: 4px; margin-top: 15px; margin-bottom: 10px">
              由於您身處的地區限制訪問色情網站，請安裝VPN翻牆工具，以便影片正常播放。
            </div>
          </div>
          <hr style="border-color: #333333; margin: 0; margin-top: 5px;">
          <div class="modal-footer">
            <div data-dismiss="modal">返回</div>
            <div data-dismiss="modal" class="pull-right btn btn-primary">確定</div>
          </div>
        @else
          <form action="{{ route('email.userReport') }}" method="GET">
            <div class="modal-body"  style="text-align: left">
              <input type="hidden" id="video-id" name="video-id" value="{{ $current->id }}">
              <input type="hidden" id="video-title" name="video-title" value="{{ $current->title }} ({{ $lang }})">
              <input type="hidden" id="video-sd" name="video-sd" value="{{ $sd }}">

              <h4 style="margin-bottom: -10px;">播放時影片載入失敗嗎？</h4>
              <p style="color: darkgray; padding-bottom: 10px;">
                <div style="color: darkgray;">1. 請先嘗試<span style="color: red">刷新頁面</span></div>
                <div style="color: darkgray;">2. 請安裝VPN翻牆工具</div>
                <div style="color: darkgray;">3. 如果問題持續請告訴我們🙏</div>
              </p>

              <div style="margin-top: 15px;" class="form-check">
                <input class="form-check-input" type="radio" name="userReportReason" id="issue" value="無法觀看這部影片" required>
                <label style="font-weight: 400; margin-left: 10px;" class="form-check-label" for="issue">
                  無法觀看這部影片
                </label>
              </div>
              <div style="margin-top: 5px;" class="form-check">
                <input class="form-check-input" type="radio" name="userReportReason" id="mismatch" value="影片內容與標題不符" required>
                <label style="font-weight: 400; margin-left: 10px;" class="form-check-label" for="mismatch">
                  影片內容與標題不符
                </label>
              </div>
              <div style="margin-top: 5px;" class="form-check">
                <input class="form-check-input" type="radio" name="userReportReason" id="dislike" value="我不喜歡這部影片" required>
                <label style="font-weight: 400; margin-left: 10px;" class="form-check-label" for="dislike">
                  我不喜歡這部影片
                </label>
              </div>

              <div style="margin-top: 5px;" class="form-check">
                <input class="form-check-input" type="radio" name="userReportReason" id="others" value="其他原因" required>
                <label style="font-weight: 400; margin-left: 10px;" class="form-check-label" for="others">
                  其他原因：<input style="color: black;" type="text" class="form-control-plaintext" name="others-text" id="others-text" value="">
                </label>
              </div>

              <hr style="border-color: #333333;">

              <div style="margin-top: 5px;" class="form-check">
                <div>我們會透過電郵告知您相關問題的進度：</div>
                <label style="font-weight: 400; margin-top: 10px;" class="form-check-label" for="report-email">
                  <input style="width: 280px; color: black;" type="text" class="form-control-plaintext" name="report-email" id="report-email" value="{{ Auth::check() ? Auth::user()->email : '' }}" placeholder="電郵地址">
                </label>
              </div>
            </div>

            <hr style="border-color: #333333; margin: 0; margin-top: 5px;">
            <div class="modal-footer">
              <div data-dismiss="modal">返回</div>
              <button class="pull-right btn btn-primary" type="submit" name="submit">提交影片報錯</button>
            </div>
          </form>
        @endif
      </div>
    </div>
  </div>
</div>