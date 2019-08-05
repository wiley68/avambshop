<?php use App\Http\Controllers\ProductsController;?>
<?php use App\Http\Controllers\CategoriesProductsController;?>
@extends('layouts/app')

@section('content')
	<?php 
	$allproducts = ProductsController::getProductsByCategory($category->id); 
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

@section('scripts')
    <script src="{{ asset('/js/products.js') }}"></script>
@stop

