<?php use App\Http\Controllers\WebpagesController;?>
<?php $vrashtane = WebpagesController::getVrashtanePage();?>
@extends('layouts/app')

@section('content')
	<h1>{{ $vrashtane->name }}</h1>
	<p>{{ $vrashtane->text }}</p>
@endsection