<?php use App\Http\Controllers\FirmsController;?>
<?php use App\Http\Controllers\ProductsController;?>
<?php use App\Http\Controllers\WebhomesController;?>
<?php 
	
	$allproducts = ProductsController::getProductsRandom(9); 
	$index = 0;
	$curindex = 0;
	foreach ($allproducts as $prod){
		$products[$index][$curindex++] = $prod;
		if ($curindex > 2){
			$index++;
			$curindex = 0;
		}
	}
	$home = WebhomesController::getWebhome(); 
?>
@extends('layouts/app')

@section('content')
<h1>{{ $home->name }}</h1>
<p>{!! html_entity_decode ($home->text) !!}</p>
<hr />
<h2>Актуални предложения <small class="text-muted">в нашия магазин</small></h2>
@if(!empty($products))
@each('products.partials.row', $products, 'product', 'products.partials.row-empty')
@endif
@endsection

@section('sidebar')
<div class="card bg-light mb-3 shadow-lg rounded">
	<div class="card-header"><a href="firms" title="Покажи всички фирми в каталога.">Търговци</a></div>
	<div class="card-body">
		<h5 class="card-title">Препоръчани търговци</h5>
		@if(count(FirmsController::getFirms()) > 0)
			@foreach(FirmsController::getFirms() as $firm)
				<a href="{{ route('products.by_firm', ['id' => $firm->id]) }}" title="Покажи всички стоки на този търговец">{{ $firm->firm }}</a><br />
			@endforeach
		@endif
	</div>
</div>
@parent
@endsection

@section('scripts')
    <script src="{{ asset('/js/products.js') }}"></script>
@stop