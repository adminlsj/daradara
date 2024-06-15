<div id="overview" class="tabcontent">
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
<strong>繁體:</strong> {{ $anime->title_ch_trad }}
<strong>簡體:</strong> {{ $anime->title_ch_simp }}
<strong>English:</strong> {{ $anime->title_en }}
<strong>日文:</strong> {{ $anime->title_jp }}
<strong>羅馬字:</strong> {{ $anime->title_ro }}
</pre>
        </div>
    </div>

    <div id="summary">
        <div class="intro">
            <h3>簡介</h3>
            <p>{{ $anime->description }}</p>
        </div>
        <div class="trailer">
            <h3>宣傳片</h3>
            <iframe width="560" height="315" src="{{ $anime->trailer }}"
                title="YouTube video player" frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
        </div>
        <div class="volumes">
            <h3>Blu-ray & DVD</h3>
            <table>
                <tr>
                    <th></th>
                    <th>第一卷</th>
                    <th>第二卷</th>
                    <th>第三卷</th>
                </tr>
                <tr>
                    <td><b>BD</b></td>
                    <td>12,946</td>
                    <td>8,434</td>
                    <td>8,159</td>
                </tr>
            </table>
        </div>

        <div class="awards">

        </div>

        <div class="recommandations">
            <h3>為您推薦</h3>
            <div class="recommandation-list">
                <div class="recommandation">
                    <a href=""><img src="https://i.meee.com.tw/gcpyEiJ.jpg" alt=""></a>
                    <div class="title">
                        <h4>銀魂</h4>
                        <h5 style="padding: 4px 0">評分: 95/100</h5>
                    </div>
                </div>
                <div class="recommandation">
                    <a href=""><img src="https://i.meee.com.tw/6d2CF3m.webp" alt=""></a>
                    <div class="title">
                        <h4>七大罪</h4>
                        <h5 style="padding: 4px 0">評分: 95/100</h5>
                    </div>
                </div>
                <div class="recommandation">
                    <a href=""><img src="https://i.meee.com.tw/w7hR66x.jpeg" alt=""></a>
                    <div class="title">
                        <h4 style="max-width:100px">這個勇者明明超tueee卻過度謹慎</h4>
                        <h5 style="padding: 4px 0">評分: 90/100</h5>
                    </div>
                </div>
                <button><img src="https://i.meee.com.tw/PT12BYq.png" alt=""></button>
            </div>
        </div>


    </div>


</div>