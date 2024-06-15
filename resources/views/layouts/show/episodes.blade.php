<div id="episodes" class="tabcontent">
<div class="description">
        <div class="ranking-seasonal">
            <strong>⭐ <a href="">季度排名 #1</a></strong>
        </div>
        <div class="ranking-yearly">
            <strong>⭐ <a href="">年度排名 #1</a></strong>
        </div>
        <div class="ranking-all">
            <strong>🏆 <a href="">動畫總排名 #31</a></strong>
        </div>
        <div class="ranking-following">
            <strong>❤️ <a href="">喜愛總數 #23</a></strong>
        </div>
        <div class="long-des">
            <pre>
<h3>資訊</h3>
<strong>動畫類別</strong>
<a href="">{{ $anime->category }}</a>

<strong>集數</strong>
{{ $anime->episodes }}

<strong>集數總長</strong>
{{ $anime->episodes_length }}分鐘

<strong>播放狀態</strong>
<a href="">{{ $anime->airing_status }}</a>

<strong>首播日期</strong>
{{ $anime->started_at }}

<strong>完播日期</strong>
{{ $anime->ended_at }}

<strong>季番</strong>
<a href="">{{ $anime->season }}</a>

<strong>更新時間</strong>
<a href="">週三</a> 23:30

<strong>動畫社</strong>
<a href="">{{ $anime->animation_studio }}</a>

<strong>類別</strong>
<a href="">搞笑</a>
<a href="">戀愛</a>
<a href="">日常</a>
<a href="">異世界</a>

<h3>評分</h3>
daradara    {{ $anime->rating }}/100
MyAnimeList {{ $anime->rating_mal }}/10
AniList     {{ $anime->rating_al }}/100
bangumi     4.5/5

<h3>副標題</h3>
<strong>繁體:</strong> {{ $anime->title_zht }}
<strong>簡體:</strong> {{ $anime->title_zhs }}
<strong>English:</strong> {{ $anime->title_en }}
<strong>日文:</strong> {{ $anime->title_jp }}
<strong>羅馬字:</strong> {{ $anime->title_ro }}
</pre>
        </div>
    </div>

    <div class="episode-list">
        <div class="filter">
            <button onclick="myFunction()" class="dropbtn">
                最舊到最新 &#9660
            </button>
            <div id="myDropdown" class="dropdown-content">
                <a href="">最舊到最新</a>
                <a href="">最新到最舊</a>
            </div>
        </div>

        <div class="videos">
            <div class="episode">
                <img src="https://i.meee.com.tw/wENTFYg.png" alt="episode1">
                第一集 - 為光明的未來乾杯！<br>
                播放日期: 2024/4/10
            </div>
            <div class="episode">
                <img src="https://i.meee.com.tw/OdCb0Mo.png" alt="episode2">
                第二集 - 為這個中二病獻上爆焰！<br>
                播放日期: 2024/4/17
            </div>
            <div class="episode">
                <img src="https://i.meee.com.tw/FdamS3v.png" alt="episode3">
                第三集 - 以這隻右手偷取寶物！<br>
                播放日期: 2024/4/24
            </div>
            <div class="episode">
                <img src="https://i.meee.com.tw/XsAqEri.png" alt="episode4">
                第四集 - 為這名強敵施展爆裂魔法！<br>
                播放日期: 2024/5/1
            </div>
        </div>
    </div>

</div>

<script>
    /* When the user clicks on the button, 
    toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    // Close the dropdown if the user clicks outside of it
    window.onclick = function (event) {
        if (!event.target.matches('.dropbtn')) {
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    openDropdown.classList.remove('show');
                }
            }
        }
    }
</script>