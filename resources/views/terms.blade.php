<?php use App\Http\Controllers\WebpagesController;?>
<?php $term = WebpagesController::getTermsPage();?> 
@extends('layouts/app')

@section('content')
	<h1>{{ $term->name }}</h1>
	<p>{{ $term->text }}</p>
@endsection