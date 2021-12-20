<div id="shareModal" class="modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 3px; background-color: #222222; color: white">
      <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
        <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
        <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 5px; font-size: 18px;">分享內容</h4>
      </div>
      <div class="modal-body">
        <h4>社交平台</h4>
        <p id="hentai-tags-text" style="color: darkgray; padding-bottom: 10px">大家一起把愛和歡樂傳出去：</p>
        <div class="addthis_inline_share_toolbox"></div>
        <hr style="margin-top: 24px; border-color: #333333;">
        <div id="copy-text-wrapper" style="background-color: #222222; border: 1px #333333 solid; padding: 10px;"><span id="copy-text">{{ Request::fullUrl() }}</span><span id="copy-btn" style="cursor: pointer; color: red" class="pull-right no-select" onclick="copyToClipboard('#copy-text')">複製</span></div>
      </div>
      <hr style="border-color: #333333; margin: 0; margin-top: 5px;">
      <div class="modal-footer" style="border-top: none; width: 100%; text-align: center; padding: 0;">
        <div style="display: inline-block; width: 50%; float: left; line-height: 46px; color: darkgray; cursor: pointer;" data-dismiss="modal">返回</div>
        <div style="border: none; color: white; background-color: #b08fff; border-radius: 0; height: 100%; width: 50%; font-weight: bold; line-height: 34px;" data-dismiss="modal" class="pull-right btn btn-primary">確定</div>
      </div>
    </div>
  </div>
</div>

<!-- Go to www.addthis.com/dashboard to customize your tools -->
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5e521ceef60346cb"></script>

<script>
  function copyToClipboard(element) {
    var $temp = $("<input>");
    $("#copy-text-wrapper").append($temp);
    $temp.val($(element).text()).select();
    document.execCommand("copy");
    $temp.remove();
  }
</script>