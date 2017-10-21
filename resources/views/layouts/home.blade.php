@extends('layouts.app')

@section('content')

<div style="margin-top: -25px; margin-bottom: 25px; width: 100%">
	<img style="width:100%" src="https://s3-us-west-2.amazonaws.com/freerider/system/intro/2.jpg" alt="Los Angeles">
</div>

<div class="container" style="width: 90%">
	<div class="row">
		<div class="col-md-6">
			<img style="border-radius: 2px" class="d-block img-responsive" src="https://s3-us-west-2.amazonaws.com/freerider/system/intro/3.jpg" alt="Chicago">
		</div>
		<div class="col-md-6">
			<img style="border-radius: 2px" class="d-block img-responsive" src="https://s3-us-west-2.amazonaws.com/freerider/system/intro/4.jpg" alt="Chicago">
		</div>
	</div>
    
    <div class="row" style="margin-top: 70px;">
    	<div class="col-md-12">
			<div class="tab" style="border-width: 0px; margin-bottom: -10px">
				@foreach (App\Order::$category as $key => $element)
					<button style="text-align: center;" class="tablinks" onclick="openStatus(event, '{{ $key }}')" {{ $key == 'makeup' ? "id=defaultOpen" : '' }}>{{ App\Order::$category[$key] }}</button>
				@endforeach
			</div>

			@foreach (App\Order::$category as $key => $element)
				<div id="{{ $key }}" class="tabcontent" style="padding-top: 10px; border-width: 0px">
					<div class="owl-carousel owl-theme">
						@foreach ($loopOrders[$key] as $order)
				            @include('order.single-order', ['radius' => 'border-bottom-left-radius: 2px; border-bottom-right-radius: 2px;'])
				        @endforeach
				    </div>
				</div>
			@endforeach
		</div>
	</div>

	<div class="row" style="margin-top: 15px">
		<div class="col-md-4 col-md-offset-4">
		    <form action="{{ route('order.search') }}" method="GET">
		        <button type="submit" class="btn btn-info btn-outline btn-lg btn-block" style="border-radius: 0; font-size: 15px;">查看所有分類</button>
		    </form>
	    </div>
	</div>

	<div class="row" style="padding-top: 90px;">
		<div class="col-md-8">
		    <form action="{{ route('order.search') }}" method="GET">
		    	<input type="hidden" name="country" id="country" value="japan">
				<input class="img-responsive" type="image" src="https://s3-us-west-2.amazonaws.com/freerider/system/country/japan.jpg">
			</form>
		</div>
		<div class="col-md-4">
			<form action="{{ route('order.search') }}" method="GET">
		    	<input type="hidden" name="country" id="country" value="korea">
				<input class="img-responsive" type="image" src="https://s3-us-west-2.amazonaws.com/freerider/system/country/korea.jpg">
			</form>
		</div>
	</div>

	<div class="row" style="margin-top: 15px">
		<div class="col-md-7">
			<div class="row">
				<div class="col-md-12">
				    <form action="{{ route('order.search') }}" method="GET">
				    	<input type="hidden" name="country" id="country" value="taiwan">
						<input class="img-responsive" type="image" src="https://s3-us-west-2.amazonaws.com/freerider/system/country/taiwan.jpg">
					</form>
				</div>
			</div>
			<div class="row" style="margin-top: 15px">
				<div class="col-md-12">
				    <form action="{{ route('order.search') }}" method="GET">
				    	<input type="hidden" name="country" id="country" value="singapore">
						<input class="img-responsive" type="image" src="https://s3-us-west-2.amazonaws.com/freerider/system/country/singapore.jpg">
					</form>
				</div>
			</div>
		</div>
		<div class="col-md-5">
			<div class="row">
				<div class="col-md-6">
					<form action="{{ route('order.search') }}" method="GET">
				    	<input type="hidden" name="country" id="country" value="usa">
						<input class="img-responsive" type="image" src="https://s3-us-west-2.amazonaws.com/freerider/system/country/usa.jpg">
					</form>
				</div>
				<div class="col-md-6" style="text-align: left">
					<form action="{{ route('order.search') }}" method="GET">
				    	<input type="hidden" name="country" id="country" value="france">
						<input class="img-responsive" type="image" src="https://s3-us-west-2.amazonaws.com/freerider/system/country/paris.jpg">
					</form>
				</div>
			</div>
		</div>
	</div>

	<div class="row" style="margin-top: 20px">
		<div class="col-md-4 col-md-offset-4">
		    <form action="{{ route('order.search') }}" method="GET">
		        <button type="submit" class="btn btn-info btn-outline btn-lg btn-block" style="border-radius: 0; font-size: 15px;">查看所有產品</button>
		    </form>
		</div>
	</div>
	<br><br><br>
</div>

<script>
	function openStatus(evt, cityName) {
	    var i, tabcontent, tablinks;
	    tabcontent = document.getElementsByClassName("tabcontent");
	    for (i = 0; i < tabcontent.length; i++) {
	        tabcontent[i].style.display = "none";
	    }
	    tablinks = document.getElementsByClassName("tablinks");
	    for (i = 0; i < tablinks.length; i++) {
	        tablinks[i].className = tablinks[i].className.replace(" active", "");
	    }
	    document.getElementById(cityName).style.display = "block";
	    evt.currentTarget.className += " active";
	}

	// Get the element with id="defaultOpen" and click on it
	document.getElementById("defaultOpen").click();

	$(document).ready(function(){
		$('.owl-carousel').owlCarousel({
			items: 4,
			loop: true,
			margin: 5,
			nav: true,
			dots: false,
			lazyLoad: true,
			autoplay: false,
			navText : ['<i class="material-icons" style="font-size:36px; margin-left:-91px; color:#666666">keyboard_arrow_left</i>','<i class="material-icons" style="font-size:36px; margin-right:-90px; color:#666666">keyboard_arrow_right</i>']
		});
	});
</script>

@endsection
