<?php use App\Http\Controllers\WebpagesController;?>
<?php $dostavka = WebpagesController::getDostavkaPage();?>
@extends('layouts/app')

@section('content')
	<h1>{{ $dostavka->name }}</h1>
	<p>{!! html_entity_decode($dostavka->text) !!}</p>
@endsection