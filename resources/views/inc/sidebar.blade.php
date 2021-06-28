<?php use App\Http\Controllers\ProductsController;?>
<?php use App\Http\Controllers\WebadsController;?>

<?php $products = ProductsController::getProductsRandom(3); ?>
<?php 
	$ad1 = WebadsController::getAd1(); 
	$ad2 = WebadsController::getAd2(); 
	$ad3 = WebadsController::getAd3();
	$ad4 = WebadsController::getAd4(); 
	$ad5 = WebadsController::getAd5(); 
	$ad6 = WebadsController::getAd6();
	$ad7 = WebadsController::getAd7(); 
	$ad8 = WebadsController::getAd8(); 
	$ad9 = WebadsController::getAd9();
	$ad10 = WebadsController::getAd10();

?>
@section('sidebar')
<div class="card bg-light mb-3 shadow-lg rounded">
	<div class="card-header">Продукти</div>
	<div class="card-body text-center">
		<h5 class="card-title">Интересни предложения</h5>
		@foreach($products as $product)
		<div class="photo" style="padding:5px;">
			<a href="/product?pid={{ $product->code }}" title="{{ $product->name }}"> <img src="{{ env('APP_SITE') }}/dist/img/products/product_{{ substr($product->code, 3, 3) }}{{ substr($product->code, -4) }}.jpg" style="width:200px;border:2px solid #1D5C80;" alt="Product Image" onerror="this.src='{{ env('APP_SITE') }}/dist/img/products/product_.jpg'" /> </a>
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
	<?php 
		if($ad1->inner_page == 1){
	?>
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
	<?php 
		} 
		if($ad2->inner_page == 1){
	?>
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
	<?php 
		} 
		if($ad3->inner_page == 1){
	?>
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
	@if((($ad4->name) != '') || (($ad4->text) != '') || (($ad4->picture) != 0))
		<hr />
	@endif
	<?php 
		}
		if($ad4->inner_page == 1){
	?>
	<div class="card-body">
		@if($ad4->name)
			<h5 class="card-title">{{ $ad4->name }}</h5>
		@endif
		@if($ad4->text)
			<p>{!! html_entity_decode($ad4->text) !!}</p>
		@endif
		@if($ad4->picture)
			@if(($ad4->picture) == 1)
				@if(($ad4->url) != '')
					<a href="{{ $ad4->url }}" target="_blanc" ><img src="{{ env('APP_SITE') }}/dist/img/logo_ad/ad_4.jpg" style="width:200px;" alt="{{ $ad4->name }}"></a>
				@else
					<img src="{{ env('APP_SITE') }}/dist/img/logo_ad/ad_4.jpg" style="width:200px;" alt="{{ $ad4->name }}">
				@endif
			@endif
		@endif
	</div>
	@if((($ad5->name) != '') || (($ad5->text) != '') || (($ad5->picture) != 0))
		<hr />
	@endif
	<?php 
		}
		if($ad5->inner_page == 1){
	?>
		<div class="card-body">
		@if($ad5->name)
			<h5 class="card-title">{{ $ad5->name }}</h5>
		@endif
		@if($ad5->text)
			<p>{!! html_entity_decode($ad5->text) !!}</p>
		@endif
		@if($ad5->picture)
			@if(($ad5->picture) == 1)
				@if(($ad5->url) != '')
					<a href="{{ $ad5->url }}" target="_blanc" ><img src="{{ env('APP_SITE') }}/dist/img/logo_ad/ad_5.jpg" style="width:200px;" alt="{{ $ad5->name }}"></a>
				@else
					<img src="{{ env('APP_SITE') }}/dist/img/logo_ad/ad_5.jpg" style="width:200px;" alt="{{ $ad5->name }}">
				@endif
			@endif
		@endif
	</div>
	@if((($ad6->name) != '') || (($ad6->text) != '') || (($ad6->picture) != 0))
		<hr />
	@endif
	<?php 
		}
		if($ad6->inner_page == 1){
	?>
		<div class="card-body">
		@if($ad6->name)
			<h5 class="card-title">{{ $ad6->name }}</h5>
		@endif
		@if($ad6->text)
			<p>{!! html_entity_decode($ad6->text) !!}</p>
		@endif
		@if($ad6->picture)
			@if(($ad6->picture) == 1)
				@if(($ad6->url) != '')
					<a href="{{ $ad6->url }}" target="_blanc" ><img src="{{ env('APP_SITE') }}/dist/img/logo_ad/ad_6.jpg" style="width:200px;" alt="{{ $ad6->name }}"></a>
				@else
					<img src="{{ env('APP_SITE') }}/dist/img/logo_ad/ad_6.jpg" style="width:200px;" alt="{{ $ad6->name }}">
				@endif
			@endif
		@endif
	</div>
	@if((($ad7->name) != '') || (($ad7->text) != '') || (($ad7->picture) != 0))
		<hr />
	@endif
	<?php 
		}
		if($ad7->inner_page == 1){
	?>
		<div class="card-body">
		@if($ad7->name)
			<h5 class="card-title">{{ $ad7->name }}</h5>
		@endif
		@if($ad7->text)
			<p>{!! html_entity_decode($ad7->text) !!}</p>
		@endif
		@if($ad7->picture)
			@if(($ad7->picture) == 1)
				@if(($ad7->url) != '')
					<a href="{{ $ad7->url }}" target="_blanc" ><img src="{{ env('APP_SITE') }}/dist/img/logo_ad/ad_7.jpg" style="width:200px;" alt="{{ $ad7->name }}"></a>
				@else
					<img src="{{ env('APP_SITE') }}/dist/img/logo_ad/ad_7.jpg" style="width:200px;" alt="{{ $ad7->name }}">
				@endif
			@endif
		@endif
	</div>
	@if((($ad8->name) != '') || (($ad8->text) != '') || (($ad8->picture) != 0))
		<hr />
	@endif
	<?php 
		}
		if($ad8->inner_page == 1){
	?>
		<div class="card-body">
		@if($ad8->name)
			<h5 class="card-title">{{ $ad8->name }}</h5>
		@endif
		@if($ad8->text)
			<p>{!! html_entity_decode($ad8->text) !!}</p>
		@endif
		@if($ad8->picture)
			@if(($ad8->picture) == 1)
				@if(($ad8->url) != '')
					<a href="{{ $ad8->url }}" target="_blanc" ><img src="{{ env('APP_SITE') }}/dist/img/logo_ad/ad_8.jpg" style="width:200px;" alt="{{ $ad8->name }}"></a>
				@else
					<img src="{{ env('APP_SITE') }}/dist/img/logo_ad/ad_8.jpg" style="width:200px;" alt="{{ $ad8->name }}">
				@endif
			@endif
		@endif
	</div>
	@if((($ad9->name) != '') || (($ad9->text) != '') || (($ad9->picture) != 0))
		<hr />
	@endif
	<?php 
		}
		if($ad9->inner_page == 1){
	?>
		<div class="card-body">
		@if($ad9->name)
			<h5 class="card-title">{{ $ad9->name }}</h5>
		@endif
		@if($ad9->text)
			<p>{!! html_entity_decode($ad9->text) !!}</p>
		@endif
		@if($ad9->picture)
			@if(($ad9->picture) == 1)
				@if(($ad9->url) != '')
					<a href="{{ $ad9->url }}" target="_blanc" ><img src="{{ env('APP_SITE') }}/dist/img/logo_ad/ad_9.jpg" style="width:200px;" alt="{{ $ad9->name }}"></a>
				@else
					<img src="{{ env('APP_SITE') }}/dist/img/logo_ad/ad_9.jpg" style="width:200px;" alt="{{ $ad9->name }}">
				@endif
			@endif
		@endif
	</div>
	@if((($ad10->name) != '') || (($ad10->text) != '') || (($ad10->picture) != 0))
		<hr />
	@endif
	<?php 
		}
		if($ad10->inner_page == 1){
	?>
		<div class="card-body">
		@if($ad10->name)
			<h5 class="card-title">{{ $ad10->name }}</h5>
		@endif
		@if($ad10->text)
			<p>{!! html_entity_decode($ad10->text) !!}</p>
		@endif
		@if($ad10->picture)
			@if(($ad10->picture) == 1)
				@if(($ad10->url) != '')
					<a href="{{ $ad10->url }}" target="_blanc" ><img src="{{ env('APP_SITE') }}/dist/img/logo_ad/ad_10.jpg" style="width:200px;" alt="{{ $ad10->name }}"></a>
				@else
					<img src="{{ env('APP_SITE') }}/dist/img/logo_ad/ad_10.jpg" style="width:200px;" alt="{{ $ad10->name }}">
				@endif
			@endif
		@endif
	</div>
	<?php 
		}
	?>
</div>
@show