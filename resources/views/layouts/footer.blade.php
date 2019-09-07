<footer id="myFooter" class="footer">
    <div style="width: 90%" class="container">
        <div class="row">
            <div style="text-align: center" class="col-sm-12 col-md-3">
                <h2 class="logo"><a href="#">FreeRider</a></h2>
            </div>
            <div class="col-sm-12 col-md-2 text-center">
                <h5>資訊</h5>
                <ul>
                    <li><a href="{{ route('blog.genre.index', ['genre' => 'travel']) }}">旅日塾</a></li>
                    <li><a href="{{ route('blog.genre.index', ['genre' => 'news']) }}">微新聞</a></li>
                    <li><a href="{{ route('blog.genre.index', ['genre' => 'press']) }}">簡讀</a></li>
                </ul>
            </div>
            <div class="col-sm-12 col-md-2 text-center">
                <h5>知識</h5>
                <ul>
                    <li><a href="{{ route('blog.genre.index', ['genre' => 'tech']) }}">科學園</a></li>
                    <li><a href="{{ route('blog.genre.index', ['genre' => 'finance']) }}">融易</a></li>
                </ul>
            </div>
            <div class="col-sm-12 col-md-2 text-center">
                <h5>社群</h5>
                <ul>
                    <li><a href="{{ route('blog.genre.index', ['genre' => 'forum']) }}">亦語</a></li>
                    <li><a href="{{ route('blog.genre.index', ['genre' => 'laughseejapan']) }}">娛見日本</a></li>
                    <li><a href="{{ route('blog.genre.index', ['genre' => 'ranking']) }}">排行百科</a></li>
                </ul>
            </div>
            <div class="col-sm-12 col-md-3">
                <div class="social-networks">
                    <a href="https://www.facebook.com/twobayjobs/" target="_blank" class="twitter"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.facebook.com/twobayjobs/" target="_blank" class="facebook"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.facebook.com/twobayjobs/" target="_blank" class="google"><i class="fab fa-google-plus"></i></a>
                </div>
                <a href="/contact" class="btn btn-info" target="_blank">Contact Us</a>
            </div>
        </div>
    </div>
    <div class="footer-copyright">
        <p style="white-space: pre-wrap; padding-bottom: 50px;">本網站之伺服器不保存任何影音內容，
所有資源皆來自其他網站。</p>
    </div>
</footer>