<?php use App\Http\Controllers\ProductsController;?>
<?php use App\Http\Controllers\PropertiesController;?>
<?php use App\Http\Controllers\WebsettingsController;?>
<?php use App\Http\Controllers\FirmsController;?>
@extends('layouts/app')

@section('content')
<?php 
	$product = ProductsController::getProductById(request()->get('pid'));
    $properties = PropertiesController::getAllProperties();
    $settings = WebsettingsController::getAllSettings();
	$products = ProductsController::getProductsByFirmRandom($product->firm_id, $product->code, 4);
	$firm1 = FirmsController::getFirmById($product->firm_id);
?>
<div calss="row">
	<div class="container">
		@include('product.partials.breadcrumb')
		@include('product.partials.body')
		<h3><a href="/products/by_firm?firm_id={{ $product->firm_id }}" title="Всички продукти от {{ $firm1[0]->firm }}">{{ $firm1[0]->firm }}</a><small class="text-muted">: други предложения</small></h3>
		<div style="padding-bottom:10px;"></div>
		<div class="card-deck">
		@each('product.partials.related', $products, 'product', 'product.partials.row-empty')
		</div>
		<div style="padding-bottom:10px;"></div>
		@include('product.partials.other')
	</div>
</div>

@endsection

@section('scripts')
    <script src="{{ asset('/js/product.js') }}"></script>
@stop