<!-- Modal -->
<div class="modal" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <form action="{{ route('email.userReport') }}" method="GET">
      <div style="padding: 15px;" class="modal-content">
        <div style="border: 0px;" class="modal-header">
          <h4 style="color: gray;font-weight: 100; transform: rotate(45deg);position: absolute; font-size: 3em; top: 5px; cursor: pointer;" class="no-select" data-dismiss="modal">+</h4>
          <h4 style="color: #3F3F3F; margin-bottom: 0px; margin-top: 40px; font-size: 1.7em" class="modal-title" id="reportModalLabel">無法觀看這部影片嗎？</h4>
        </div>
        <div style="color: #3F3F3F; margin-top: -15px; font-weight: 500; font-size: 1.1em" class="modal-body">
          感謝您向我們提供意見或回報任何錯誤：
          <div style="margin-top: 10px;" class="form-check">
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
        </div>
        <div style="border: 0px; margin-bottom: -10px;" class="modal-footer">
            <input name="video-id" type="hidden" value="{{ $video->id }}">
            <a style="width: auto; background-color: white; border: 0px; color: black; font-weight: 400; font-size: 1.1em;" class="btn btn-primary" data-dismiss="modal">取消</a>
            <button type="submit" style="width: auto; background-color: white; border: 0px; color: #d84b6b; font-weight: 400; font-size: 1.1em;" class="btn btn-primary" name="submit">提交</button>
        </div>
      </div>
    </form>
  </div>
</div>