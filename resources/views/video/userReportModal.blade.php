<!-- Modal -->
<div class="modal" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    @if ($country_code == 'CN' || $country_code == 'MY')
      <div style="padding: 15px;" class="modal-content">
        <div style="border: 0px;" class="modal-header">
          <h4 style="color: gray;font-weight: 100; transform: rotate(45deg);position: absolute; font-size: 3em; top: 5px; cursor: pointer;" class="no-select" data-dismiss="modal">+</h4>
          <div style="padding: 15px 15px; color: maroon; background-color: pink; border: 1px solid lightpink; border-radius: 4px; margin-top: 40px; margin-bottom: -20px">
            由於您身處的地區限制訪問色情網站，請安裝VPN翻牆工具，以便影片正常播放。
          </div>
          <br>
        </div>
      </div>
    @else
      <form action="{{ route('email.userReport') }}" method="GET">
        <input type="hidden" id="video-id" name="video-id" value="{{ $current->id }}">
        <input type="hidden" id="video-title" name="video-title" value="{{ $current->title }}">
        <input type="hidden" id="video-sd" name="video-sd" value="{{ $current->sd }}">
          <div style="padding: 15px;" class="modal-content">
            <div style="border: 0px;" class="modal-header">
              <h4 style="color: gray;font-weight: 100; transform: rotate(45deg);position: absolute; font-size: 3em; top: 5px; cursor: pointer;" class="no-select" data-dismiss="modal">+</h4>
              <h4 style="color: #3F3F3F; margin-bottom: 0px; margin-top: 40px; font-size: 1.7em" class="modal-title" id="reportModalLabel">播放時影片載入失敗嗎？</h4>
              <div style="color: #3F3F3F; margin-bottom: 0px; margin-top: 5px; line-height: 22px">
                <div>1. 請先嘗試<span style="color: red">刷新頁面</span></div>
                <div>2. 請安裝VPN翻牆工具</div>
                <div>3. 如果問題持續請告訴我們🙏</div>
              </div>
            </div>
            <div style="color: #3F3F3F; margin-top: -15px; font-weight: 500; font-size: 1.1em" class="modal-body">
              <div style="margin-top: 0px;" class="form-check">
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
                  其他原因：<input type="text" class="form-control-plaintext" name="others-text" id="others-text" value="">
                </label>
              </div>

              <hr>

              <div style="margin-top: 5px;" class="form-check">
                <div>我們會透過電郵告知您相關問題的進度：</div>
                <label style="font-weight: 400; margin-top: 10px;" class="form-check-label" for="report-email">
                  <input style="width: 280px;" type="text" class="form-control-plaintext" name="report-email" id="report-email" value="{{ Auth::check() ? Auth::user()->email : '' }}" placeholder="電郵地址">
                </label>
              </div>
              
            </div>
            <div style="border: 0px; margin-bottom: -10px;" class="modal-footer">
                <a style="width: auto; background-color: white; border: 0px; color: black; font-weight: 400; font-size: 1.1em;" class="btn btn-primary" data-dismiss="modal">取消</a>
                <button type="submit" style="width: auto; background-color: white; border: 0px; color: #d84b6b; font-weight: 400; font-size: 1.1em;" class="btn btn-primary" name="submit">提交</button>
            </div>
          </div>
      </form>
    @endif
  </div>
</div>