<form id="search-form" class="search-top-form right-search-top" action="{{ route('job.search') }}" method="GET">
	<div class="row">
		<div class="hidden-xs col-sm-3 col-md-3">
			<input type="text" value="{{ request('title') }}" id="title" name="title" placeholder="職位 / 公司名稱 . . .">
		</div>
		<div class="col-xs-5 col-sm-3 col-md-3">
			<select onchange="this.form.submit()" id="location" name="location">
				@foreach (App\Job::$country as $key => $element)
					<option value="{{ $key }}" {{ request('location') == $key ? 'selected' : ''}}>{{ $element }}</option>
				@endforeach
			</select>
		</div>
		<div class="col-xs-5 col-sm-3 col-md-3">
			<select onchange="this.form.submit()" id="category" name="category">
				<option value="">職位類別 . . .</option>
				@foreach (App\Job::$category as $key => $element)
					<option value="{{ $key }}" {{ request('category') == $key ? 'selected' : ''}}>{{ $element }}</option>
				@endforeach
			</select>
		</div>
		<div class="hidden-xs col-sm-2 col-md-2">
			<button type="submit" style="border-radius:2px !important; width:100%" class="container btn btn-info btn-block">搜索</button>
		</div>
		<div class="col-xs-2 col-sm-1 col-md-1" style="text-align: left; margin-top: 5px">
			<i id="slide-out-arrow" style="cursor:pointer; color: white; font-size: 30px;" class="noselect material-icons">keyboard_arrow_{{ $slideOutSearch ? 'up' : 'down' }}</i>
		</div>
	</div>

	<div id="slide-in-content" style="display: {{ $slideOutSearch ? '' : 'none'}};" class="row">
		<div class="col-xs-5 col-sm-3 col-md-3">
			<input type="integer" value="{{ request('salary') }}" id="salary" name="salary" placeholder="最低工資 . . .">
		</div>
		<div class="col-xs-5 col-sm-3 col-md-3">
			<select onchange="this.form.submit()" id="experience" name="experience">
				<option value="">工作經驗 . . .</option>
				@foreach (App\Job::$experience as $key => $element)
					<option value="{{ $key }}" {{ request('experience') == $key ? 'selected' : ''}}>{{ $element }}</option>
				@endforeach
			</select>
		</div>
		<div class="col-xs-5 col-sm-3 col-md-3">
			<select onchange="this.form.submit()" id="type" name="type">
				<option value="">聘用形式 . . .</option>
				@foreach (App\Job::$type as $key => $element)
					<option value="{{ $key }}" {{ request('type') == $key ? 'selected' : ''}}>{{ $element }}</option>
				@endforeach
			</select>
		</div>
		<div class="col-xs-5 col-sm-3 col-md-3">
			<select onchange="this.form.submit()" id="education" name="education">
				<option value="">教育程度 . . .</option>
				@foreach (App\Job::$education as $key => $element)
					<option value="{{ $key }}" {{ request('education') == $key ? 'selected' : ''}}>{{ $element }}</option>
				@endforeach
			</select>
		</div>
	</div>
</form>

