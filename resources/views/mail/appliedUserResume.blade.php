<div class="row">
	<div class="col-sm-2">
		<img src="https://s3.amazonaws.com/twobayjobs/avatars/originals/{{ Auth::user()->avatar->filename }}.jpg" style="width:100%; border-radius: 2px;">
	</div>
	<div class="col-sm-10">
		<div class="row">
	    	<div class="col-sm-6">
				<div class="form-group">
					<input value="{{ old('name', $resume->name) }}" type="text" class="form-control" id="name" name="name" placeholder="Name">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
	    			<input value="{{ old('title', $resume->email) }}" type="email" class="form-control" id="email" name="email" placeholder="Email">
	    		</div>
			</div>
		</div>

		<div class="row">
	    	<div class="col-sm-4">
	    		<div class="input-group mb-2 mr-sm-2 mb-sm-0">
					<div class="input-group-addon">+852</div>
	    			<input value="{{ old('title', $resume->phone) }}" type="text" class="form-control" id="phone" name="phone" placeholder="WhatsApp">
	    		</div>
	    	</div>
	    	<div class="col-sm-4">
	    		<div class="form-group">
	    			<input value="{{ old('title', $resume->wechat) }}" type="text" class="form-control" id="wechat" name="wechat" placeholder="WeChat">
	    		</div>
	    	</div>
	    	<div class="col-sm-4">
	    		<div class="form-group">
	    			<input value="{{ old('title', $resume->qq) }}" type="text" class="form-control" id="qq" name="qq" placeholder="QQ">
	    		</div>
	    	</div>
		</div>
	</div>
</div>
<br>