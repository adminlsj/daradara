<form style="position:absolute; top: 20%; left: 5%; width: 90%" class="search-home-form" action="{{ route('job.search') }}" method="GET">
	<div class="row">
		<div class="col-xs-12">
			<input type="text" value="{{ request('title') }}" id="title" name="title" placeholder="職位 / 公司名稱 . . .">
		</div>
	</div>

	<div class="row">
		<div class="col-xs-6">
			<select id="location" name="location">
				<option value="">選擇地點 . . .</option>
				@foreach (App\Job::$country as $key => $element)
					<option value="{{ $key }}" {{ request('location') == $key ? 'selected' : ''}}>{{ $element }}</option>
				@endforeach
			</select>
		</div>
		<div class="col-xs-6">
			<select id="category" name="category">
				<option value="">職位類別 . . .</option>
				@foreach (App\Job::$category as $key => $element)
					<option value="{{ $key }}" {{ request('category') == $key ? 'selected' : ''}}>{{ $element }}</option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="row">
		<div class="col-xs-6">
			<input type="integer" value="{{ request('salary') }}" id="salary" name="salary" placeholder="最低工資 . . .">
		</div>
		<div class="col-xs-6">
			<select id="experience" name="experience">
				<option value="">工作經驗 . . .</option>
				@foreach (App\Job::$experience as $key => $element)
					<option value="{{ $key }}" {{ request('experience') == $key ? 'selected' : ''}}>{{ $element }}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6">
			<select id="type" name="type">
				<option value="">聘用形式 . . .</option>
				@foreach (App\Job::$type as $key => $element)
					<option value="{{ $key }}" {{ request('type') == $key ? 'selected' : ''}}>{{ $element }}</option>
				@endforeach
			</select>
		</div>
		<div class="col-xs-6">
			<select id="education" name="education">
				<option value="">教育程度 . . .</option>
				@foreach (App\Job::$education as $key => $element)
					<option value="{{ $key }}" {{ request('education') == $key ? 'selected' : ''}}>{{ $element }}</option>
				@endforeach
			</select>
		</div>
	</div>

	<div class="row sidenav" style="margin-top: 10px; border-radius: 5px !important">
		<div class="col-xs-6 col-xs-offset-3">
			<button type="submit" class="btn btn-info btn-block">搜索</button>
		</div>
	</div>
</form>

