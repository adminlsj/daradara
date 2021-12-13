<form action="{{ route('bot.updateCaptions') }}" method="POST">
  {{ csrf_field() }}

  <textarea style="width: 70%;" name="captions" id="captions" rows="30" placeholder="captions"></textarea>
  <button style="display: block; margin-top: 10px;" type="submit">submit</button>
</form>