<div class="headings">
    <div class="cover">
        <img src="{{ $anime->photo_cover }}" alt="">
        <div class="button-groups">
            <div class="list btn-group">
                <button class="add btn btn-secondary">添加至列表</button>
                <button class="down btn btn-secondary dropdown-toggle dropdown" type="button" id="dropdownMenuButton"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onclick="document.getElementById('dropdownMenu').style.display='flex'">
                    <i class="fa fa-chevron-down"></i>
                </button>
                <div class="dropdown-menu" id="dropdownMenu" aria-labelledby="dropdownMenuButton" style="display:none;">
                    <a class="dropdown-item" href="#">添加至觀看中</a>
                    <a class="dropdown-item" href="#">添加至準備觀看</a>
                    <a class="dropdown-item" href="#">列表編輯器</a>
                </div>
            </div>
            <button class="favorite">♥</button>
        </div>
    </div>
    <div class="heading-content">
        <h3> {{ $anime->title_ro }} </h3>
        <p> {{ $anime->description }} </p>
        <div class="navtabs">
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
    window.addEventListener('mouseup', function (event) {
        var dropdownMenu = document.getElementById('dropdownMenu');
        if (event.target != dropdownMenu && event.target.parentNode != dropdownMenu) {
            dropdownMenu.style.display = 'none';
        }
    });  
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