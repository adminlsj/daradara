<nav style="background-color: white !important; border: none !important;" class="responsive-frame">
  <div style="width: 80%; background-color: white !important;" class="container-fluid">
    <div style="background-color: white !important;">
      <a href="{{ route('blog.genre.index', ['genre' => $genre]) }}">
	        <img src="https://s3-us-west-2.amazonaws.com/freerider/avatars/originals/default_freerider_profile_pic.jpg" style="border-radius: 20px; margin-top: -15px;" width="40px" height="40px">
	    </a>

	    <a style="font-size: 30px; color: black !important; font-weight: 600; line-height: 50px; text-decoration: none;" href="{{ route('blog.genre.index', ['genre' => $genre]) }}">{{ App\Blog::$genres[$genre]['navTitle'] }}</a>

	    @foreach (App\Blog::$genres[$genre]['categories'] as $text => $value)
            <a class="pull-right" style="font-size: 18px; color: white !important; background-color: gray; padding: 5px 7px; margin-left: 2px; line-height: 40px; text-decoration: none;" href="{{ route('blog.category.index', ['genre' => $genre, 'category' => $value]) }}">{{ $text }}</a>
	    @endforeach
    </div>
  </div>
</nav>