@extends('layouts.app')

@section('content')
<div class="container" style="margin-top: -10px">
	<div class="row">
		<div class="col-md-6">
			<div class="card-custom">
				<h2>FreeRider是什麼？</h2>
				<p>放假去旅行，又或者工作出差，你係咪常有空手而回的經歷？又或者心愛嘅模型喺外地開售卻無暇前往購買？FreeRider為你提供一個 代購交易的平台，比去左旅行嘅你可以獲悉全球各地的人想要嘅外國產品，並將產品帶返來卑買家，從中獲取利益；比宅喺屋企嘅你可以 輕鬆購買世界各地嘅產品，並請旅行中的用戶外遊時將物品帶番比你，早上要求，晚上立刻到手！</p>
			</div>
		</div>
		<div class="col-md-6">
			<div class="card-custom">
				<h2>使用的步驟？</h2>
				<p>用戶只需登入我們嘅網站，就可以免費使用我地嘅平台，無限量地建立你所需要嘅物品嘅訂單，當去左旅行嘅其他人見到你所需要嘅物品 係海外以較便宜嘅價錢出現，就可以接取訂單賺取差價，你亦能以便宜於商鋪的價錢及運費或比網上訂購更快的速度獲取物品，實現互惠互利！ 而想幫人代購既話，只需要申請「成為 FreeRider」，就可以即刻接受係你旅遊目的地附近既訂單，在旅途中賺取你的旅遊費！</p>
			</div>
		</div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-6">
			<img class="d-block img-responsive" src="https://s3-us-west-2.amazonaws.com/freerider/system/intro/3.jpg" alt="Chicago">
		</div>
		<div class="col-md-6">
			<img class="d-block img-responsive" src="https://s3-us-west-2.amazonaws.com/freerider/system/intro/4.jpg" alt="Chicago">
		</div>
	</div>
	<br>
	<div class="row">
        <div class="col-md-12">
		    <div class="card">
			    <ul class="nav nav-tabs text-center" style="font-size: 15px" role="tablist">
			        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">我是買家</a></li>
			        <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">我是賣家</a></li>
			    </ul>

			    <!-- Tab panes -->
			    <div class="tab-content">
			        <div role="tabpanel" class="tab-pane active" id="home">
			        	<img class="d-block img-responsive" src="https://s3-us-west-2.amazonaws.com/freerider/system/intro/5.jpg" alt="Chicago">
			        </div>
			        <div role="tabpanel" class="tab-pane" id="profile">
			        	<img class="d-block img-responsive" src="https://s3-us-west-2.amazonaws.com/freerider/system/intro/6.jpg" alt="Chicago">
			        </div>
			    </div>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-8 col-md-offset-2">
		    <form action="{{ route('order.search') }}" method="GET">
		        <button type="submit" class="btn btn-info btn-outline btn-lg btn-block" style="border-radius: 0; font-size: 15px;">查看所有產品</button>
		    </form>
		</div>
	</div>
</div>
@endsection