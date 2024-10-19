<div class="headings">
    <div class="cover">
        <img src="{{ $anime->photo_cover }}" alt="">
        <div class="button-groups">
            <div class="list btn-group">
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-secondary add" data-toggle="modal"
                        data-target="#createSavelist">{{ $anime_save ? App\Savelist::$statuslists[$status] : '添加至列表' }}
                    </button>

                    <div class="btn-group" role="group">
                        <button id="btnGroupDrop1" type="button" class="btn btn-secondary dropdown-toggle down"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-chevron-down"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                            <a class="dropdown-item flex-column" href="#">添加至觀看中</a>
                            <a class="dropdown-item flex-column" href="#">添加至準備觀看</a>
                            <a class="dropdown-item flex-column" href="#">編輯列表</a>
                        </div>
                    </div>
                </div>

                <form id="createSavelistForm" action="{{ route('anime.save', ['anime' => $anime]) }}" method="POST">
                    {{ csrf_field() }}

                    <input id="type" name="type" type="hidden" value="anime">
                    <input id="is_status" name="is_status" type="hidden" value="false">

                    <div id="createSavelist" class="modal" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <span class="material-icons pull-left no-select modal-close-btn"
                                        data-dismiss="modal">close</span>
                                </div>
                                <div class="modal-body" style="padding:0px; text-align: left">
                                    <div class="photo-banner">
                                        <img src="https://i.meee.com.tw/fl3xmwq.jpg" alt=""
                                            style="width: 100%; height: 180px;">
                                    </div>
                                    <div class="photo-cover flex-row">
                                        <img src="{{ $anime->photo_cover }}" alt="">
                                        <h3> {{ $anime->title_ro }} </h3>
                                    </div>
                                    <div class="add-to-list-content">
                                        <div class="filters">
                                            <div class="filter watching-status">
                                                <h3>觀看狀態</h3>
                                                <div class="bar form-control">
                                                    <select id="status" name="status"
                                                        onclick="document.getElementById('option-watching-status').style.display='block'">
                                                        <div class="scroll-wrap" id="option-watching-status">
                                                            <div class="option-group">
                                                                <option value="watching">觀看狀態...</option>
                                                                <option value="watching" {{ $status == 'watching' ? 'selected' : '' }}>觀看中</option>
                                                                <option value="planning" {{ $status == 'planning' ? 'selected' : '' }}>準備觀看</option>
                                                                <option value="completed" {{ $status == 'completed' ? 'selected' : '' }}>已觀看</option>
                                                                <option value="rewatching" {{ $status == 'rewatching' ? 'selected' : '' }}>重看中</option>
                                                                <option value="paused" {{ $status == 'paused' ? 'selected' : '' }}>暫停</option>
                                                                <option value="dropped" {{ $status == 'dropped' ? 'selected' : '' }}>棄番</option>
                                                            </div>
                                                        </div>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="filter episodes-progress">
                                                <h3>觀看進度</h3>
                                                <div class="bar">
                                                    <input id="episode_progress" name="episode_progress" type="number"
                                                        value="{{ $anime_save ? $anime_save->episode_progress : null }}"
                                                        min="0" max="100000000">
                                                </div>
                                            </div>

                                            <div class="filter total-rewatches">
                                                <h3>觀看次數</h3>
                                                <div class="bar">
                                                    <input id="total_rewatches" name="total_rewatches" type="number"
                                                        value="{{ $anime_save ? $anime_save->total_rewatches : null }}">
                                                </div>
                                            </div>

                                            <div class="filter watch-date">
                                                <h3>觀看日期</h3>
                                                <div class="bar">
                                                    <input id="start_date" name="start_date" type="date"
                                                        value="{{ $anime_save ? Carbon\Carbon::parse($anime_save->start_date)->format('Y-m-d') : null }}">
                                                </div>
                                            </div>

                                            <div class="filter watch-enddate">
                                                <h3>完成日期</h3>
                                                <div class="bar">
                                                    <input id="finish_date" name="finish_date" type="date"
                                                        value="{{ $anime_save ? Carbon\Carbon::parse($anime_save->finish_date)->format('Y-m-d') : null }}">
                                                </div>
                                            </div>

                                            <div class="filter notes">
                                                <h3>備註</h3>
                                                <div class="bar">
                                                    <textarea id="notes" name="notes"
                                                        name="">{{ $anime_save ? $anime_save->notes : null }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group">
                                            <h3>列表</h3>
                                            <input type="checkbox" name="is_private" value="1" id="is_private">
                                            <label class="no-select" for="is_private">私人清單</label>
                                            <hr>
                                        </div>
                                    </div>

                                </div>
                                <hr style="border-color: #333333; margin: 0;">
                                <div class="modal-footer">
                                    <div class="toggle-playlist-modal" data-dismiss="modal">返回</div>
                                    <button id="video-create-playlist-btn" method="POST"
                                        class="pull-right btn btn-primary">建立播放清單</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <button class="favorite">♥</button>
        </div>
    </div>
    
    <div class="heading-content">
        <h3> {{ $anime->title_ro }} </h3>
        <p> {{ $anime->description }} </p>
        <div class="navtabs flex-row">
            <button class="tablinks" onclick="activeTab(event, 'overview')">簡介</button>
            <button class="tablinks" onclick="activeTab(event, 'episodes')">集數列表</button>
            <button class="tablinks" onclick="activeTab(event, 'characters')">登場人物</button>
            <button class="tablinks" onclick="activeTab(event, 'themes')">主題曲</button>
            <button class="tablinks" onclick="activeTab(event, 'staffs')">製作人員</button>
            <button class="tablinks" onclick="activeTab(event, 'comments')">討論版</button>
        </div>
    </div>
</div>

<script>
    var dropdownMenu = document.getElementById('dropdownMenu');
    function toggleDropdownMenu() {
        if (dropdownMenu.style.display === 'none' || dropdownMenu.style.display === '') {
            dropdownMenu.style.display = 'flex';
        }
        else if (dropdownMenu.style.display === 'flex') {
            dropdownMenu.style.display = 'none';
        }
    }
</script>

<script>
    window.addEventListener('mouseup', function (event) {
        var dropdownMenu = document.getElementById('dropdownMenu');
        if (event.target != dropdownMenu) {
            dropdownMenu.style.display = 'none';
        }
    });
</script>

<script>
    var modal = document.getElementById('addToList');

    window.onclick = function (event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>

<script>
    function activeTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>

<script>
    window.addEventListener('mouseup', function (event) {
        var optionWatchingStatus = document.getElementById('option-watching-status');
        var optionListPrivacy = document.getElementById('option-list-privacy');

        if (event.target === optionWatchingStatus) {
            optionWatchingStatus.style.display = 'block';
        }
        else if (event.target === optionListPrivacy) {
            optionListPrivacy.style.display = 'block';
        }

        optionWatchingStatus.style.display = 'none';
        optionListPrivacy.style.display = 'none';
    });  
</script>