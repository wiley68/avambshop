<?php use App\Http\Controllers\ProductsController;?>
<?php use App\Http\Controllers\FirmsController;?>
@extends('layouts/app')

@section('content')
	<?php 
	$allproducts = ProductsController::getProductsByFirm($firm->id); 
	$index = 0;
	$curindex = 0;
	foreach ($allproducts as $prod){
		$products[$index][$curindex++] = $prod;
		if ($curindex > 2){
			$index++;
			$curindex = 0;
		}
	}
	?>
<div calss="row">
		@include('products.partials.breadcrumb')
		@if(isset($products))
			@each('products.partials.row', $products, 'product', 'products.partials.row-empty')
		@else
			@include('products.partials.row-empty')	
		@endif
			
		@if($allproducts->hasPages())
		<div class="pagination-center">
			{{ $allproducts->links('vendor.pagination.bootstrap-4') }}
		</div>
		@endif
</div>

@endsection

@section('sidebar')
<div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
	<div class="card-header">{{ $firm->firm }}</div>
	<div class="card-body">
		<h5 class="card-title">{{ $firm->firm_name }}</h5>
		<p class="card-text">{{ $firm->city }}, {{ $firm->address1 }}<br />Тел: {{ $firm->firm_phone1 }}<br />E-Mail: {{ $firm->firm_mail }}<br />WEB: {{ $firm->site }}</p>
	</div>
</div>
@parent
@endsection

@section('scripts')
    <script src="{{ asset('/js/products.js') }}"></script>
@stop

