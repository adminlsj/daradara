<!-- Modal -->
<div style="margin:20px; padding: 150px;" class="modal fade" id="reportModal" tabindex="-1" role="dialog" aria-labelledby="reportModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('email.userReport') }}" method="GET">
      <div style="padding: 10px;" class="modal-content">
        <div style="border: 0px;" class="modal-header">
          <h4 style="color: black; margin-bottom: 0px;" class="modal-title" id="reportModalLabel">無法觀看這部影片嗎？</h4>
        </div>
        <div style="color: gray; font-weight: 300; margin-top: -15px;" class="modal-body">
          感謝您向我們提供意見或回報任何錯誤：
          <div style="margin-top: 10px;" class="form-check">
            <input class="form-check-input" type="radio" name="userReportReason" id="issue" value="無法觀看這部影片" required>
            <label style="font-weight: 400; margin-left: 10px;" class="form-check-label" for="issue">
              無法觀看這部影片
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
              其他原因
            </label>
          </div>
        </div>
        <div style="border: 0px; margin-bottom: -10px; font-size: 1.05em;" class="modal-footer">
            <input name="video-id" type="hidden" value="{{ $video->id }}">
            <a style="width: auto; background-color: white; border: 0px; color: black; font-weight: 400;" class="btn btn-primary" data-dismiss="modal">取消</a>
            <button type="submit" style="width: auto; background-color: white; border: 0px; color: #d84b6b; font-weight: 400;" class="btn btn-primary" name="submit">提交</button>
        </div>
      </div>
    </form>
  </div>
</div>