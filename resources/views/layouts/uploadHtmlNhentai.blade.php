<form id="nhentai-upload-form" action="{{ route('nhentai.upload') }}" method="POST">
  {{ csrf_field() }}
  {{ method_field('POST') }}

  <textarea style="width: 70%;" name="nhentai-html" id="nhentai-html" rows="30" placeholder="nhentai html" autofocus onkeyup="this.form.submit();"></textarea>

  <input type="hidden" value="{{ Request::input('type') }}" id='nhentai-type' name='nhentai-type'>

  <button style="display: block; margin-top: 10px;" type="submit">submit</button>
</form>

<script>
  var $myForm = $("#nhentai-upload-form");
  $myForm.submit(function(){
      $myForm.submit(function(){
          return false;
      });
  });
</script>