<?php use App\Http\Controllers\FirmsController;?>
<?php use App\Http\Controllers\ftp;?>
@extends('layouts/app')

@section('content')
<?php 
	$firms = FirmsController::getPaginatedFirms(); 
?>
<div calss="row">
		<h1>Фирми включени в каталога:</h1>
		<hr />
		@each('firms.partials.row', $firms, 'firm', 'firms.partials.row-empty')
		
		@if($firms->hasPages())
		<div class="pagination-center">
			{{ $firms->links('vendor.pagination.bootstrap-4') }}
		</div>
		@endif
</div>

@endsection
