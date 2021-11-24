<script type="application/javascript">
    var ad_idzone = "{{ $id }}",
    ad_width = "{{ $width }}",
    ad_height = "{{ $height }}"
</script>
<script type="application/javascript" src="https://a.realsrv.com/ads.js"></script>
<noscript>
  <iframe src="https://syndication.realsrv.com/ads-iframe-display.php?idzone={{ $id }}&output=noscript&type={{ $width }}x{{ $height }}" width="{{ $width }}" height="{{ $height }}" scrolling="no" marginwidth="0" marginheight="0" frameborder="0"></iframe>
</noscript>