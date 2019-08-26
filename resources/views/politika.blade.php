<?php use App\Http\Controllers\WebpagesController;?>
<?php $politika = WebpagesController::getPolitikaPage();?> 
@extends('layouts/app')

@section('content')
	<h1>{{ $politika->name }}</h1>
	<p>{!! html_entity_decode($politika->text) !!}</p>
@endsection