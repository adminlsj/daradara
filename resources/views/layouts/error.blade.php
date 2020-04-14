@if (count($errors) > 0)
    <div class="center-block" style="width: 96%;">
	    <div class="alert alert-danger" style="margin-top: -7px">
	        <ul>
	            @foreach ($errors->all() as $error)
	                <li>{{ $error }}</li>
	            @endforeach
	        </ul>
	    </div>
    </div>
@endif