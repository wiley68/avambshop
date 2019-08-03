<?php use App\Http\Controllers\WebpagesController;?>
<?php $politika = WebpagesController::getPolitikaPage();?> 
@extends('layouts/app')

@section('content')
	<h1>{{ $politika->name }}</h1>
	<p>{{ $politika->text }}</p>
@endsection