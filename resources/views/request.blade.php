@extends('layouts/app')

@section('content')	
	<h1>Запитване за продукта: {{ $product_code }}</h1>
	<hr />
	{!! Form::open(['url' => 'request/submit']) !!}    
	<div class="form-group">		
		{{Form::label('name', 'Име')}}		
        {{Form::text('name', '', ['class' => 'form-control', 'placeholder' => 'Впиши името си'])}}
        <input type="hidden" value="{{ $product_code }}" />	
	</div>    
	<div class="form-group">		
		{{Form::label('email', 'E-Mail Адрес')}}		
		{{Form::text('email', '', ['class' => 'form-control', 'placeholder' => 'example@gmail.com'])}}	
	</div>    
	<div class="form-group">		
		{{Form::label('message', 'Съобщение')}}		
		{{Form::textarea('message', '', ['class' => 'form-control', 'placeholder' => 'Въведи съобщението си'])}}	
	</div>	
	<div>	
		{{Form::submit('Изпрати', ['class' => 'btn btn-primary'])}}	
	</div>	
	{!! Form::close() !!}
@endsection