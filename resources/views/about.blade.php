<?php use App\Http\Controllers\WebpagesController;?>
<?php $about = WebpagesController::getAboutPage();?> 
@extends('layouts/app')

@section('content')
	<h1>{{ $about->name }}</h1>
	<p>{!! html_entity_decode($about->text) !!}</p>
@endsection