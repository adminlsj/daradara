<form action="{{ route('m3u8.update') }}" method="POST">
  {{ csrf_field() }}
  {{ method_field('POST') }}

  <textarea style="width: 70%;" name="m3u8" id="m3u8" rows="30" placeholder="m3u8"></textarea>
  <input style="width: 70%; margin-top: 10px;" name="user0" id="user0" placeholder="user0"></input>
  <input style="width: 70%; margin-top: 10px;" name="user1" id="user1" placeholder="user1"></input>
  <input style="width: 70%; margin-top: 10px;" name="user2" id="user2" placeholder="user2"></input>
  <input style="width: 70%; margin-top: 10px;" name="lang" id="lang" placeholder="lang"></input>
  <button style="display: block; margin-top: 10px;" type="submit">submit</button>
</form>