<div class="modal" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div style="padding: 15px;" class="modal-content">
      <div style="border: 0px; position: relative;" class="modal-header">
        <h4 style="color: gray;font-weight: 100; transform: rotate(45deg);position: absolute; font-size: 3em; top: -10px; cursor: pointer;" class="no-select" data-dismiss="modal">+</h4>
        <h4 style="color: #3F3F3F; margin-bottom: 0px; margin-top: 40px; font-size: 1.7em" class="modal-title" id="subscribeModalLabel">分享</h4>
      </div>
      <div style="color: #3F3F3F; margin-top: -15px; font-weight: 500; font-size: 1.1em" class="modal-body">
        <hr style="margin-top: 8px; margin-bottom: 28px">
        <div class="addthis_inline_share_toolbox"></div>
        <hr style="margin-top: 24px;">
        <div id="copy-text-wrapper" style="background-color: #f9f9f9; border: 1px #e5e5e5 solid; padding: 10px;"><span id="copy-text">{{ Request::fullUrl() }}</span><span id="copy-btn" style="cursor: pointer; color: #d84b6b" class="pull-right no-select" onclick="copyToClipboard('#copy-text')">複製</span></div>
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