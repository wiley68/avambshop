<?php use App\Http\Controllers\ProductsController;?>
<?php use App\Http\Controllers\WebadsController;?>

<?php $products = ProductsController::getProductsRandom(3); ?>
<?php 
	$ad1 = WebadsController::getAd1(); 
	$ad2 = WebadsController::getAd2(); 
	$ad3 = WebadsController::getAd3();
?>
@section('sidebar')
<div class="card bg-light mb-3 shadow-lg rounded">
	<div class="card-header">Продукти</div>
	<div class="card-body text-center">
		<h5 class="card-title">Интересни предложения</h5>
		@foreach($products as $product)
		<div class="photo" style="padding:5px;">
			<a href="/product?pid={{ $product->code }}" title="{{ $product->name }}"> <img src="{{ env('APP_SITE') }}/dist/img/products/product_{{ substr($product->code, -4) }}.jpg" style="width:200px;border:2px solid #1D5C80;" alt="Product Image" onerror="this.src='{{ env('APP_SITE') }}/dist/img/products/product_.jpg'" /> </a>
		</div>		
		@endforeach
	</div>
</div>
<div class="card bg-light mb-3 shadow-lg rounded">
	<div class="card-header">Информация</div>
	<div class="card-body">
		<h5 class="card-title">Информация за магазина</h5>
		<a href="/terms">Общи условия</a><br />
		<a href="/politika">Политика на поверителност</a><br />
		<a href="/dostavka">Доставка и плащане</a><br />
		<a href="/vrashtane">Връщане на продукт</a><br />
	</div>
</div>
<div class="card bg-light mb-3 shadow-lg rounded">
	<div class="card-header">Партньори</div>
	<div class="card-body">
		@if($ad1->name)
			<h5 class="card-title">{{ $ad1->name }}</h5>
		@endif
		@if($ad1->text)
			<p>{!! html_entity_decode($ad1->text) !!}</p>
		@endif
		@if($ad1->picture)
			@if(($ad1->picture) == 1)
				@if(($ad1->url) != '')
					<a href="{{ $ad1->url }}" target="_blanc" ><img src="{{ env('APP_SITE') }}/dist/img/logo_ad/ad_1.jpg" style="width:200px;" alt="{{ $ad1->name }}"></a>
				@else
					<img src="{{ env('APP_SITE') }}/dist/img/logo_ad/ad_1.jpg" style="width:200px;" alt="{{ $ad1->name }}">
				@endif
			@endif
		@endif
	</div>
	@if((($ad2->name) != '') || (($ad2->text) != '') || (($ad2->picture) != 0))
		<hr />
	@endif
	<div class="card-body">
		@if($ad2->name)
			<h5 class="card-title">{{ $ad2->name }}</h5>
		@endif
		@if($ad2->text)
			<p>{!! html_entity_decode($ad2->text) !!}</p>
		@endif
		@if($ad2->picture)
			@if(($ad2->picture) == 1)
				@if(($ad2->url) != '')
					<a href="{{ $ad2->url }}" target="_blanc" ><img src="{{ env('APP_SITE') }}/dist/img/logo_ad/ad_2.jpg" style="width:200px;" alt="{{ $ad2->name }}"></a>
				@else
					<img src="{{ env('APP_SITE') }}/dist/img/logo_ad/ad_2.jpg" style="width:200px;" alt="{{ $ad2->name }}">
				@endif
			@endif
		@endif
	</div>
	@if((($ad3->name) != '') || (($ad3->text) != '') || (($ad3->picture) != 0))
		<hr />
	@endif
	<div class="card-body">
		@if($ad3->name)
			<h5 class="card-title">{{ $ad3->name }}</h5>
		@endif
		@if($ad3->text)
			<p>{!! html_entity_decode($ad3->text) !!}</p>
		@endif
		@if($ad3->picture)
			@if(($ad3->picture) == 1)
				@if(($ad3->url) != '')
					<a href="{{ $ad3->url }}" target="_blanc" ><img src="{{ env('APP_SITE') }}/dist/img/logo_ad/ad_3.jpg" style="width:200px;" alt="{{ $ad3->name }}"></a>
				@else
					<img src="{{ env('APP_SITE') }}/dist/img/logo_ad/ad_3.jpg" style="width:200px;" alt="{{ $ad3->name }}">
				@endif
			@endif
		@endif
	</div>
</div>
@show