<form id="signUpModalForm" action="{{ route('register') }}" method="POST">
  {{ csrf_field() }}
  {{ Session::put('previousUrl', Request::fullUrl()) }}

  <div id="signUpModal" class="modal" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <span class="material-icons pull-left no-select modal-close-btn" data-dismiss="modal">close</span>
          <h4 class="modal-title">註冊帳戶</h4>
        </div>
        <div class="modal-body" style="text-align: left">
          <h4>註冊帳戶開始訂閱</h4>
          <p id="hentai-tags-text" style="color: darkgray; padding-bottom: 10px">訂閱通知將發送至你的電郵地址。</p>
          <div class="form-group" style="margin-top: 10px;">
            <input style="background-color: #333333; color: white; border-color: #333333;" type="email" class="form-control" name="email" id="email" placeholder="電郵地址" required>
          </div>
          <div class="form-group">
            <input style="background-color: #333333; color: white; border-color: #333333;" type="text" class="form-control" name="name" id="name" placeholder="名字" required>
          </div>
          <div class="form-group">
            <input style="background-color: #333333; color: white; border-color: #333333;" type="password" class="form-control" name="password" id="password" placeholder="設定密碼" required>
          </div>

          @include('layouts.socialLoginBtn')

          <div style="margin-top: 20px; margin-bottom: 5px; font-size: 0.95em; color: darkgray;">
            <span style="font-weight: 400">已經有Hanime1帳戶了？</span>&nbsp;<a id="switch-login-modal" style="cursor: pointer; text-decoration: none; font-weight: 500;">登入</a>
          </div>
        </div>
        <hr style="border-color: #323434; margin: 0">
        <div class="modal-footer">
          <div data-dismiss="modal">返回</div>
          <button class="pull-right btn btn-primary" type="submit">馬上註冊加入</button>
        </div>
      </div>
    </div>
  </div>
</form>