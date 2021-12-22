<form id="loginModalForm" action="{{ route('login') }}" method="POST">
  {{ csrf_field() }}
  {{ Session::put('previousUrl', Request::fullUrl()) }}

  <div id="loginModal" class="modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content" style="border-radius: 3px; background-color: #222222; color: white">
        <div class="modal-header" style="border-bottom: 1px solid #333333; position: relative; height: 65px;">
          <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
          <h4 class="modal-title" style="text-align: center; font-weight: bold; margin: 0; padding: 0; margin-top: 5px; font-size: 18px;">登入帳戶</h4>
        </div>
        <div class="modal-body">
          <h4>登入帳戶開始訂閱</h4>
          <p id="hentai-tags-text" style="color: darkgray; padding-bottom: 10px">訂閱通知將發送至你的電郵地址。</p>
          <div class="form-group" style="margin-top: 10px;">
            <input style="background-color: #333333; color: white; border-color: #333333;" type="email" class="form-control" name="email" id="email" placeholder="電郵地址" required>
          </div>
          <div class="form-group">
            <input style="background-color: #333333; color: white; border-color: #333333;" type="password" class="form-control" name="password" id="password" placeholder="密碼" required>
          </div>

          @include('layouts.socialLoginBtn')

          <div style="margin-top: 20px; margin-bottom: 5px; font-size: 0.95em; color: darkgray;">
            <span style="font-weight: 400">尚未擁有帳戶？</span>&nbsp;<a id="switch-signup-modal" style="cursor: pointer; text-decoration: none; font-weight: 500;">註冊</a>
          </div>
        </div>
        <hr style="border-color: #3a3c3f; margin: 0">
        <div class="modal-footer" style="border-top: none; width: 100%; text-align: center; padding: 0;">
          <div style="display: inline-block; width: 50%; float: left; line-height: 46px; color: darkgray; cursor: pointer;" data-dismiss="modal">返回</div>
          <button style="border: none; color: white; background-color: #b08fff; border-radius: 0; height: 100%; width: 50%; font-weight: bold; line-height: 34px;" class="pull-right btn btn-primary" type="submit">登入</button>
        </div>
      </div>
    </div>
  </div>
</form>