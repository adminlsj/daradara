<div class="row">
	<div class="resume-input-margin-bottom col-xs-12 col-sm-2">
		<img src="https://s3.amazonaws.com/twobayjobs/avatars/originals/{{ Auth::user()->avatar->filename }}.jpg" style="width:100%; border-radius: 2px;">
	</div>
	<div class="col-xs-12 col-sm-10">
		<div class="row">
	    	<div class="col-sm-6">
				<div class="form-group">
					<input value="{{ old('name', $resume->name) }}" type="text" class="form-control" id="name" name="name" placeholder="名字">
				</div>
			</div>
			<div class="col-sm-6">
				<div class="form-group">
	    			<input value="{{ old('title', $resume->email) }}" type="email" class="form-control" id="email" name="email" placeholder="電郵地址">
	    		</div>
			</div>
		</div>

		<div class="row">
	    	<div class="resume-input-margin-bottom col-xs-12 col-sm-4">
	    		<div class="input-group mb-2 mr-sm-2 mb-sm-0">
					<div class="input-group-addon">+852</div>
	    			<input value="{{ old('title', $resume->phone) }}" type="text" class="form-control" id="phone" name="phone" placeholder="WhatsApp">
	    		</div>
	    	</div>
	    	<div class="resume-input-margin-bottom col-xs-12 col-sm-4">
	    		<div class="input-group mb-2 mr-sm-2 mb-sm-0">
					<div class="input-group-addon">微信</div>
	    			<input value="{{ old('title', $resume->wechat) }}" type="text" class="form-control" id="wechat" name="wechat" placeholder="帳號">
	    		</div>
	    	</div>
	    	<div class="resume-input-margin-bottom col-xs-12 col-sm-4">
	    		<div class="input-group mb-2 mr-sm-2 mb-sm-0">
					<div class="input-group-addon">QQ</div>
	    			<input value="{{ old('title', $resume->qq) }}" type="text" class="form-control" id="qq" name="qq" placeholder="帳號">
	    		</div>
	    	</div>
		</div>
	</div>
</div>
<br>
<div style="font-size: 25px">教育背景</div>
<br>
<div class="row">
	<div class="col-sm-9">
		<div class="form-group">
			<input value="{{ old('title', $resume->edu_title) }}" type="text" class="form-control" id="edu_title" name="edu_title" placeholder="修讀的相關學位課程 e.g. 經濟與金融學士學位">
		</div>
	</div>
	<div class="resume-input-margin-bottom col-sm-3">
		<div class="input-group mb-2 mr-sm-2 mb-sm-0">
			<div class="input-group-addon">GPA</div>
			<input value="{{ old('title', $resume->edu_gpa) }}" type="text" class="form-control" id="edu_gpa" name="edu_gpa" placeholder="GPA / CGPA">
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-6">
		<div class="form-group">
			<input value="{{ old('title', $resume->edu_university) }}" type="text" class="form-control" id="edu_university" name="edu_university" placeholder="學校名稱">
		</div>
	</div>
	<div class="col-xs-6 col-sm-3">
		<div class="form-group">
			<input value="{{ old('title', $resume->edu_start) }}" type="month" class="form-control" id="edu_start" name="edu_start" placeholder="Start Date">
		</div>
	</div>
	<div class="col-xs-6 col-sm-3">
		<div class="form-group">
			<input value="{{ old('title', $resume->edu_end) }}" type="month" class="form-control" id="edu_end" name="edu_end" placeholder="End Date">
		</div>
	</div>
</div>
<br>
<div style="font-size: 25px">工作經驗</div>
<br>
<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
			<input value="{{ old('title', $resume->work_title) }}" type="text" class="form-control" id="work_title" name="work_title" placeholder="職位頭銜 e.g. 市場推廣實習生">
		</div>
	</div>
</div>
<div class="row">
	<div class="col-xs-12 col-sm-6">
		<div class="form-group">
			<input value="{{ old('title', $resume->work_company) }}" type="text" class="form-control" id="work_company" name="work_company" placeholder="公司名稱">
		</div>
	</div>
	<div class="col-xs-6 col-sm-3">
		<div class="form-group">
			<input value="{{ old('title', $resume->work_start) }}" type="month" class="form-control" id="work_start" name="work_start" placeholder="Start Date">
		</div>
	</div>
	<div class="col-xs-6 col-sm-3">
		<div class="form-group">
			<input value="{{ old('title', $resume->work_end) }}" type="month" class="form-control" id="work_end" name="work_end" placeholder="End Date">
		</div>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
		    <textarea class="form-control" id="work_description" name="work_description" placeholder="(選填)  用幾句描述一下您的工作內容，讓對方知道您才適合這份工作！" rows="3">{{ old('title', $resume->work_description) }}</textarea>
		</div>
	</div>
</div>
<br>
<div style="font-size: 25px">技能 & 獎項</div>
<br>
<div class="row">
	<div class="col-sm-12">
		<div class="form-group">
		    <textarea class="form-control" id="other_description" name="other_description" placeholder="(選填)  告訴對方更多關於您的優點和技能，為您的簡歷加分！" rows="4">{{ old('title', $resume->other_description) }}</textarea>
		</div>
	</div>
</div>
<br>
<div style="font-size: 25px">上傳簡歷 &nbsp;<small>(PDF格式)</small></div>
<br>
<div class="row">
	<div class="col-sm-12">
		@if ($haveResumeImg)
			<div style="font-size: 15px">目前的簡歷：<a href="https://s3.amazonaws.com/twobayjobs/resumes/{{ $resume->id }}/{{ $resume->resumeImg->filename }}.pdf" target="_blank">{{ $resume->resumeImg->original_filename }}</a></div><br>
		@endif
		<input id="resumeImgs" name="resumeImgs[]" type="file" class="file" multiple data-show-upload="false" data-show-caption="true">
	</div>
</div>
<br>