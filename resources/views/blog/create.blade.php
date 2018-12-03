<div class="container" style="width: 90%">
	<div class="row">
    	<div class="col-md-12">
			<h3 style="color: grey; font-weight: 300">新增貼文</h3>
			<hr>
			<form class="job-form" action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data">
				{{ csrf_field() }}
				<div class="row">
					<div class="col-md-12">
					    <input type="text" value="" id="title" name="title" placeholder="標題" required>
					</div>
				</div>

				<div class="row" style="margin-top: 10px">
					<div class="col-md-2">
					    <input class="form-check-input" type="checkbox" id="is_travel" name="is_travel" value="1"> 旅遊
					</div>
					<div class="col-md-2">
					    <input class="form-check-input" type="checkbox" id="is_japan" name="is_japan" value="1"> 日本
					</div>
					<div class="col-md-2">
					    <input class="form-check-input" type="checkbox" id="is_korea" name="is_korea" value="1"> 韓國
					</div>
					<div class="col-md-2">
					    <input class="form-check-input" type="checkbox" id="is_taiwan" name="is_taiwan" value="1"> 台灣
					</div>
					<div class="col-md-2">
					    <input class="form-check-input" type="checkbox" id="is_food" name="is_food" value="1"> 美食
					</div>
					<div class="col-md-2">
					    <input class="form-check-input" type="checkbox" id="is_fashion" name="is_fashion" value="1"> 潮流
					</div>
				</div>

				<div class="row" style="margin-top: 35px">
					<div class="col-md-12">
					    <textarea style="width: 100%; padding: 10px; border-color: #AAA" type="text" value="" id="content" name="content" placeholder="內容" rows="20" required></textarea>
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-12">
						<input id="blogImgs" name="blogImgs[]" type="file" class="file" multiple data-show-upload="false" data-show-caption="true">
					</div>
				</div>
				<br>
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<br>
						<button type="submit" class="btn btn-info btn-outline btn-lg btn-block">馬上添加</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>