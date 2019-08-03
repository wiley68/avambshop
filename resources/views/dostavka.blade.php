<?php use App\Http\Controllers\WebpagesController;?>
<?php $dostavka = WebpagesController::getDostavkaPage();?>
@extends('layouts/app')

@section('content')
	<h1>{{ $dostavka->name }}</h1>
	<p>{{ $dostavka->text }}</p>
@endsection