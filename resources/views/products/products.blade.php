<?php use App\Http\Controllers\ProductsController;?>
<?php use App\Http\Controllers\FirmsController;?>
@extends('layouts/app')

@section('content')
<?php  
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
@if(!empty($products))
<div calss="row">
		@include('products.partials.breadcrumb')
		@each('products.partials.row', $products, 'product', 'products.partials.row-empty')
		
		@if($allproducts->hasPages())
		<div class="pagination-center">
			{{ $allproducts->links('vendor.pagination.bootstrap-4') }}
		</div>
		@endif
</div>
@endif

@endsection

@section('sidebar')
<div class="card bg-light mb-3 shadow-lg rounded">
	<div class="card-header">Филтър за продукти</div>
	<div class="card-body">
		<h5 class="card-title">По производители:</h5>
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
