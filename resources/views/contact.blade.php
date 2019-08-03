<?php use App\Http\Controllers\WebpagesController;?>
<?php $contact = WebpagesController::getContactPage();?> 
@extends('layouts/app')

@section('content')	
	@if(null !== (app('request')->input('status')))
	<div class="alert alert-success" role="alert">
		Вие успешно изпратихте вашето съобщение!
	</div>
	@endif
	<h1>{{ $contact->name }}</h1>
	<p>{{ $contact->text }}</p>
	<hr />
	{!! Form::open(['url' => 'contact/submit']) !!}    
	<div class="form-group">		
		{{Form::label('name', 'Name')}}		
		{{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Впиши името си'])}}	
	</div>    
	<div class="form-group">		
		{{Form::label('email', 'E-Mail Address')}}		
		{{Form::text('email', '', ['class' => 'form-control', 'placeholder' => 'example@gmail.com'])}}	
	</div>    
	<div class="form-group">		
		{{Form::label('message', 'Message')}}		
		{{Form::textarea('message', '', ['class' => 'form-control', 'placeholder' => 'Enter message'])}}	
	</div>	
	<div>	
		{{Form::submit('Изпрати', ['class' => 'btn btn-primary'])}}	
	</div>	
	{!! Form::close() !!}
@endsection