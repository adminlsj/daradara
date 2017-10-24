<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <div style="margin-bottom: 73px;">@include('layouts.nav')</div>
        
        <div id="left" style="margin-top: -12px; background-color: white; border-top: solid 1px #E6E6E6">
		    @include('order.search-left')
		</div>
		<div id="right" style="margin-top: -12px; border-top: solid 1px #E6E6E6; padding-top: 20px;">
            <div class="container" style="width: 100%">
    		    @foreach ($orders as $order)
                    <div class="col-md-3" style="padding: 0; padding-left: 5px; margin-bottom: 18px;">
        	            @include('order.single-order', ['order' => $order, 'radius' => 'border-radius: 2px'])
                    </div>
    	        @endforeach

    			<div class="text-center">{{ $orders->appends(['name' => request('name'), 'category' => request('category'), 'country' => request('country'), 'price' => request('price'), 'endDate' => request('endDate')])->links() }}</div>
            </div>
		</div>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
