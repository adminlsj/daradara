<div class="tab">
    <button class="tablinks" onclick="activeTab(event, 'overview')">簡介</button>
    <button class="tablinks" onclick="activeTab(event, 'episodes')">集數列表</button>
    <button class="tablinks" onclick="activeTab(event, 'characters')">登場人物</button>
    <button class="tablinks active" onclick="activeTab(event, 'staffs')">製作人員</button>
    <button class="tablinks" onclick="activeTab(event, 'themes')">主題曲</button>
    <button class="tablinks" onclick="activeTab(event, 'comments')">討論版</button>
</div>

<script>
    function activeTab(evt, tabname) {
        var i, tabcontent, tablinks;

        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }

        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }

        evt.currentTarget.className += " active";
        document.getElementById(tabname).style.display = "flex";
        document.getElementById(tabname).style.flexDirection = "row";
    }
</script>
