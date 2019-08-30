<nav style="background-color: #414143 !important;" id="scroll-hide-nav" class="responsive-frame">
  <div style="width: 80%; background-color: #414143 !important;" class="container-fluid">
    <div style="background-color: #414143 !important;">
      <a href="{{ route('blog.genre.index', ['genre' => $genre]) }}">
	        <img src="https://twobayjobs.s3.amazonaws.com/avatars/originals/square_freerider_profile_pic.jpg" style="border-radius: 20px; margin-top: -14px;" width="40px" height="40px">
	    </a>

	    <a style="font-size: 25px; color: white !important; font-weight: 300; line-height: 50px; text-decoration: none; margin-left: -5px;" href="{{ route('blog.genre.index', ['genre' => $genre]) }}">FreeRider</a>

      @foreach (App\Blog::$genres[$genre]['categories'] as $text => $value)
        <a class="pull-right" style="color: #f2f2f2 !important; padding: 0px 0px {{ $loop->index == 0 ? '0px' : '15px'}} 15px;" href="{{ route('blog.category.index', ['genre' => $genre, 'category' => $value]) }}"><i style="font-size: 25px; vertical-align:middle; margin-bottom: -22.5px" class="material-icons">{{ App\Blog::$navIcons[$loop->index] }}</i></a>
      @endforeach
    </div>
  </div>
</nav>