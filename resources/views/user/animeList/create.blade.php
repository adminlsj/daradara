<form id="createSavelistForm" action="{{ route('user.savelist.store', ['user' => $user]) }}" method="POST">
    {{ csrf_field() }}

    <input id="type" name="type" type="hidden" value="anime">
    <input id="is_status" name="is_status" type="hidden" value="false">

    <div id="createSavelist" class="modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius: 3px 3px 0 0 !important; border: none !important;">
                <div class="modal-body" style="padding: 0px; text-align: left; background-color: white; border-radius: 3px 3px 0 0 !important; padding-bottom: 50px;">
                    <div class="photo-banner" style="position: relative;">
                        <img src="https://s4.anilist.co/file/anilistcdn/media/anime/banner/16498-8jpFCOcDmneX.jpg" alt="" style="width: 100%; height: 180px;">
                        <span style="font-size: 18px; position: absolute; right: 18px; top: 18px; color: #909399; font-weight: 400; cursor: pointer;" class="material-icons no-select modal-close-btn" data-dismiss="modal">close</span>
                    </div>
                    <div class="photo-cover flex-row">
                        <img src="https://cor-cdn-static.bibliocommons.com/list_jacket_covers/live/2036358919.png" alt="">
                        <h3>編輯清單</h3>
                    </div>
                    <div class="add-to-list-content" style="color: rgba(92,114,138); min-height: 285px;">
                        <div class="row" style="margin-top: 10px; padding-right: 45px; width: 80%;">
                            <div class="filter watching-status col-md-12">
                                <h3>標題</h3>
                                <div class="bar">
                                    <input type="text" name="title" id="title" required>
                                </div>
                            </div>

                            <div class="filter episodes-progress col-md-12">
                                <h3>詳細說明 (選填)</h3>
                                <div class="bar" style="height: 89px">
                                    <textarea style="line-height: 25px; height: 89px; padding-top: 8px; padding-bottom: 8px;" id="description" name="description" rows="4"></textarea>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group" style="width: 20%">
                            <h3 style="font-size: 1.3rem; color: rgba(122,133,143, .9); font-weight: 400; margin-top: 30px;">隱私</h3>
                            <div style="margin-bottom: 1px;">
                                <div style="float: left; width: 24px; display: inline-block;">
                                    <input style="filter: brightness(1.5);" type="checkbox" name="is_private" value="1" id="is_private">
                                </div>
                                <div style="display: inline-block; width: calc(100% - 24px);">
                                    <label style="font-size: 1.2rem; font-weight: 400; margin-top: -1px; margin-left: -12px; padding-left: 12px;" class="no-select" for="is_private">私人清單</label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <hr style="margin: 0;">
                <div class="modal-footer" style="background-color: #EDF1F5; border-radius: 0 0 3px 3px !important;">
                    <div style="color: rgb(92, 114, 138); margin-left: 35px;" class="toggle-playlist-modal" data-dismiss="modal">返回</div>
                    <button id="video-create-playlist-btn" method="POST" style="background-color: #3DB4F2 !important; font-weight: 400; margin-right: 35px;" class="pull-right btn btn-primary">儲存</button>
                </div>
            </div>
        </div>
    </div>
</form>