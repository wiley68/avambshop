<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AVAMB Shop') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	@if(Request::is('cart'))			
    <link href="{{ asset('css/cart.css') }}" rel="stylesheet">
	@endif	
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
		@include('inc.navbar')
		<div style="padding-bottom:55px;"></div>
		@if(Request::is('/'))			
			@include('inc.showcase')		
		@endif	
		<div style="padding-bottom:10px;"></div>
		<div class="container">		
		<div class="row">			
			@if(Request::is('login') OR Request::is('password/reset') OR Request::is('register') OR Request::is('product') OR Request::is('cart') OR Request::is('order') OR Request::is('order/submit'))
			<div class="col-lg-12 col-md-12">
				@yield('content')			
			</div>			
			@elseif(Request::is('products') OR Request::is('products/by_firm') OR Request::is('products/search') OR Request::is('firms'))
			<div class="col-lg-3 col-md-3">				
				@include('inc.sidebar')			
			</div>			
			<div class="col-lg-9 col-md-9">
				@include('inc.messages')				
				@yield('content')			
			</div>					
			@else
			<div class="col-lg-9 col-md-9">				
				@include('inc.messages')				
				@yield('content')			
			</div>			
			<div class="col-lg-3 col-md-3">				
				@include('inc.index-sidebar')			
			</div>		
			@endif		
		</div>				
		</div>
		
		@include('inc.footer')

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
	@yield('scripts')
</body>
</html>
