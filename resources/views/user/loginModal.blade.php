<div class="modal" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">

    <form method="POST" action="{{ route('login') }}">

      {{ csrf_field() }}

      <div style="padding: 15px;" class="modal-content">
        <div style="border: 0px; position: relative;" class="modal-header">
          <h4 style="color: gray;font-weight: 100; transform: rotate(45deg);position: absolute; font-size: 3em; top: -10px; cursor: pointer;" class="no-select" data-dismiss="modal">+</h4>
          <h4 style="color: #3F3F3F; margin-bottom: 0px; margin-top: 40px; font-size: 1.7em" class="modal-title" id="loginModalLabel">登入帳戶開始訂閱</h4>
        </div>
        <div style="color: #3F3F3F; margin-top: -15px; font-size: 1.1em" class="modal-body">
          <div style="font-weight: 500;">訂閱通知將發送至你的電郵地址。</div>
          <div style="font-weight: 500;">溫馨提示：請務必檢查垃圾郵件！</div>
          <div class="form-group" style="margin-top: 20px;">
            <input type="email" class="form-control" name="email" id="email" placeholder="電郵地址" required>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" name="password" id="password" placeholder="密碼" required>
          </div>
          <button style="height: 45px; margin-top: 10px; font-size: 1em;" type="submit" class="btn btn-info" name="submit">登入</button>

          @include('layouts.socialLoginBtn')

          <div style="margin-top: 20px; font-size: 0.95em">
            <span style="font-weight: 400">尚未擁有帳戶？</span>&nbsp;<a id="switch-signup-modal" style="cursor: pointer; text-decoration: none; font-weight: 500;">註冊</a>
          </div>
        </div>
      </div>

    </form>

  </div>
</div>