<div class="sidebar flex-column">
    <div class="ranking">
        <strong>⭐ <a href=""> 季度排名 #1</a></strong>
    </div>
    <div class="ranking">
        <strong>🏆 <a href=""> 動畫總排名 #31</a></strong>
    </div>
    <div class="data">
        <div class="data-set">
            <div class="type">動畫類別</div>
            <div class="format"> <a href="">{{ $anime->category }}</a> </div>
        </div>
        <div class="data-set">
            <div class="type">集數</div>
            <div class="format"> {{ $anime->episodes }} </div>
        </div>
        <div class="data-set">
            <div class="type">集數總長</div>
            <div class="format"> {{ $anime->episodes_length }}分鐘 </div>
        </div>
        <div class="data-set">
            <div class="type">播放狀態</div>
            <div class="format"> <a href="">{{ $anime->airing_status }}</a> </div>
        </div>
        <div class="data-set">
            <div class="type">首播日期</div>
            <div class="format"> {{ $anime->started_at ? $anime->started_at : 'Not available yet' }} </div>
        </div>
        <div class="data-set">
            <div class="type">完播日期</div>
            <div class="format"> {{ $anime->ended_at ? $anime->ended_at : 'Not available yet' }} </div>
        </div>
        <div class="data-set">
            <div class="type">季番</div>
            <div class="format"> <a href="">{{ $anime->season ? $anime->season : 'Not available yet' }}</a> </div>
        </div>
        <div class="data-set">
            <div class="type">更新時間</div>
            <div class="format"> {{ $anime->updated_at }} </div>
        </div>
        <div class="data-set">
            <div class="type">動畫社</div>
            <div class="format"> <a href="">{{ $anime->animation_studio == 'add some' ? 'Unknown' : $anime->animation_studio }}</a> </div>
        </div>
        <div class="data-set">
            <div class="type">類別</div>
            @foreach ($anime->genres as $genre)
                <div class="format"> <a href="">{{ $genre }}</a> </div>
            @endforeach
        </div>
        <div class="data-set">
            <div class="type">羅馬譯</div>
            <div class="format"> {{ $anime->title_ro }} </div>
        </div>
        <div class="data-set">
            <div class="type">日譯</div>
            <div class="format"> {{ $anime->title_jp }} </div>
        </div>
        <div class="data-set">
            <div class="type">英譯</div>
            <div class="format"> {{ $anime->title_en ? $anime->title_en : $anime->title_ro }} </div>
        </div>
        <div class="data-set">
            <div class="type">簡譯</div>
            <div class="format"> {{ $anime->title_zhs }} </div>
        </div>
    </div>
    <div class="tags">
        <h3>標籤</h3>
        <div class="tag">
            <a href="">搞笑</a>
            <div class="rank">97%</div>
        </div>
        <div class="tag">
            <a href="">戀愛</a>
            <div class="rank">95%</div>
        </div>
        <div class="tag">
            <a href="">日常</a>
            <div class="rank">93%</div>
        </div>
        <div class="tag">
            <a href="">異世界</a>
            <div class="rank">90%</div>
        </div>
    </div>
</div>