<?php use App\Http\Controllers\WebpaymentsController;?>
<?php use App\Http\Controllers\WebdeliveriesController;?>
<?php use App\Http\Controllers\SubdeliveriesController;?>
<?php use App\Http\Controllers\FirmsController;?>
<?php use Illuminate\Contracts\Auth\Guard;?>
<?php $currentUser = app('Illuminate\Contracts\Auth\Guard')->user(); ?>
<?php use App\Http\Controllers\PropertiesController;?>
<?php $properties = PropertiesController::getAllProperties();?>

<script>
function deliverieMethodsMouseUp(id, oldvalue){
	let old_price = Number.parseFloat($("#span_grand_total_delivery").html());
	const newvalue = Number.parseFloat($('input[id='+id+']').attr( "data-value" ));
	const new_price = old_price - oldvalue + newvalue;
	$("#span_grand_total_delivery").html(new_price.toFixed(2));
	const grand_total_price = Number.parseFloat($("#span_grand_total_price").html());
	const grand_total_order = new_price + grand_total_price;
	$("#span_grand_total_order").html(grand_total_order.toFixed(2));
}
function getValueByChecked(name){
	return Number.parseFloat(document.querySelector('input[name="'+name+'"]:checked').getAttribute("data-value"));
}
</script>

@extends('layouts/app')

@section('content')
<input type="hidden" id="eik_if" value="<?php echo (isset($currentUser)) ? $currentUser->eik : ''; ?>" />
<input type="hidden" id="firmname_if" value="<?php echo (isset($currentUser)) ? $currentUser->firmname : ''; ?>" />
<input type="hidden" id="dds_nomer_if" value="<?php echo (isset($currentUser)) ? $currentUser->dds_nomer : ''; ?>" />
<input type="hidden" id="firmcity_if" value="<?php echo (isset($currentUser)) ? $currentUser->firmcity : ''; ?>" />
<input type="hidden" id="firmaddress_if" value="<?php echo (isset($currentUser)) ? $currentUser->firmaddress : ''; ?>" />
<input type="hidden" id="mol_if" value="<?php echo (isset($currentUser)) ? $currentUser->mol : ''; ?>" />
<h1><em>Поръчка</em></h1>

@php
    $product_typeprice = false;
@endphp
@if (isset($cart_session) AND sizeof($cart_session['firms']) > 0)
@foreach($cart_session['firms'] as $firm)
@if (sizeof($firm['items']) > 0)
    @php
        foreach ($firm['items'] as $item) {
            if (($item['product_typeprice'] == 'f') || ($item['product_typeprice'] == 't')){
                $product_typeprice = true;
            }
        }
    @endphp
@endif
@endforeach
    @if ($product_typeprice)
        <input type="hidden" id="product_typeprice" value="1">
        <hr />
        <p style="color:red;font-weight:bold;font-size:18px;">Внимание!!!</p>
        <p style="color:red;font-size:14px;">
            Вие направихте поръчка, в която има продукт, който трябва да се изработи индивидуално за Вас.<br />
            Служител от фирмата производител ще се свърже с Вас за потвърждение.
        </p>
        <button type="button" id="btn_ok" class="btn btn-warning">Разбрах</button>
    @else
        <input type="hidden" id="product_typeprice" value="0">
    @endif
@endif

<hr />
<div class="container" id="order_div">
	@if (isset($cart_session) AND sizeof($cart_session['firms']) > 0)
	
	{!! Form::open(['url' => 'order/submit']) !!} 
	<div class="row">
		<div class="col-md-6">
			<h3>Адресни данни</h3>
			<div>
			{{Form::label('name', 'Име*')}}		
			{{Form::text('name', (isset($currentUser)) ? $currentUser->name : '', ['class' => 'form-control', 'placeholder' => 'Впиши имената си', 'required' => 'required', 'maxlength' => '191'])}}
			{{ Form::hidden('user_id', isset($currentUser) ? $currentUser->id : 0) }}
			</div>
			<div>
			{{Form::label('address', 'Адрес*')}}		
			{{Form::text('address', (isset($currentUser)) ? $currentUser->address : '', ['class' => 'form-control', 'placeholder' => 'Впиши адрес за получаване', 'required' => 'required', 'maxlength' => '128'])}}	
			</div>
			<div>
			{{Form::label('city', 'Населено място*')}}		
			{{Form::text('city', (isset($currentUser)) ? $currentUser->city : '', ['class' => 'form-control', 'placeholder' => 'Впиши населено място', 'required' => 'required', 'maxlength' => '128'])}}	
			</div>
			<div>
			{{Form::label('postalcod', 'Пощенски код*')}}		
			{{Form::number('postalcod', (isset($currentUser)) ? $currentUser->postalcod : '', ['class' => 'form-control', 'min' => '0', 'max' => '9999', 'placeholder' => 'Впиши пощенски код', 'required' => 'required', 'maxlength' => '4'])}}	
			</div>
			<div>
			{{Form::label('phone', 'Телефон*')}}		
			{{Form::text('phone', (isset($currentUser)) ? $currentUser->phone : '', ['class' => 'form-control', 'placeholder' => 'Впиши телефона си', 'required' => 'required', 'maxlength' => '45'])}}	
			</div>
			<div style="padding-bottom:20px;">
			{{Form::label('email', 'Email адрес*')}}		
			{{Form::email('email', (isset($currentUser)) ? $currentUser->email : '', ['class' => 'form-control', 'placeholder' => 'Впиши e-mail', 'required' => 'required', 'maxlength' => '191'])}}	
			</div>
			<h3>Допълнителна информация</h3>
			<div>
			{{Form::label('description', 'Бележки към поръчката (незадължително)')}}		
			{{Form::textarea('description', '', ['class' => 'form-control', 'rows' => 4, 'style' => 'resize:none', 'placeholder' => 'Бележки към поръчката (относно доставката и др.)'])}}	
			</div>
		</div>
		<div class="col-md-6">
			<h3>Незадължителна информация</h3>
			<div>
			{{Form::label('isfirma', 'Желаете ли издаване на фактура за фирма:&nbsp;')}}		
			{{Form::checkbox('isfirma', 'Yes', false, ['class' => 'form-control'])}}
			</div>
			<div id="firm_info">
			<div>
			{{Form::label('eik', 'ЕИК')}}		
			{{Form::text('eik', '', ['class' => 'form-control', 'placeholder' => 'Впиши ЕИК', 'maxlength' => '24'])}}	
			</div>
			<div>
			{{Form::label('firmname', 'Име на фирма')}}		
			{{Form::text('firmname', '', ['class' => 'form-control', 'placeholder' => 'Впиши име на фирма', 'maxlength' => '128'])}}	
			</div>
			<div>
			{{Form::label('dds_nomer', 'ДДС номер')}}		
			{{Form::text('dds_nomer', '', ['class' => 'form-control', 'placeholder' => 'Впиши ДДС номер', 'maxlength' => '24'])}}	
			</div>
			<div>
			{{Form::label('firmcity', 'Населено място')}}		
			{{Form::text('firmcity', '', ['class' => 'form-control', 'placeholder' => 'Впиши населено място', 'maxlength' => '128'])}}	
			</div>
			<div>
			{{Form::label('firmaddress', 'Адрес')}}		
			{{Form::text('firmaddress', '', ['class' => 'form-control', 'placeholder' => 'Впиши адрес', 'maxlength' => '128'])}}	
			</div>
			<div>
			{{Form::label('mol', 'МОЛ')}}		
			{{Form::text('mol', '', ['class' => 'form-control', 'placeholder' => 'Впиши МОЛ', 'maxlength' => '128'])}}	
			</div>
			</div>
		</div>
	</div>
	<hr />
	
	<?php $error_methods_delivery = ""; ?>
	<?php $error_methods_payment = ""; ?>
	<?php $grand_total_price = 0; ?>
	<?php $grand_total_delivery = 0; ?>
	<?php $grand_total_delivery_id = ""; ?>
	@foreach($cart_session['firms'] as $firm)
	<div class="card">
		<div class="card-header">
			<h4>Стока на Фирма - {{ FirmsController::getFirmById($firm['firm_id'])[0]->firm }}</h4>
		</div>
		<div class="card-body">
		
			<!-- Opisanie na produktite -->
			<div class="row" style="border-bottom:1px solid #DCDCDC;font-weight:bold;">
				<div class="col-md-6">Продукт</div>
				<div class="col-md-6">Общо</div>
			</div>
			@if (sizeof($firm['items']) > 0)
			<?php $total_price = 0; ?>
			<?php $total_kg = 0; ?>
			<?php $price_currency = "лв"; ?>

			@foreach($firm['items'] as $item)
			<?php
			if ($item['product_name'] == ""){
				$product_name = $item['product_code'];
			}else{
				$product_name = $item['product_name'];
			}
			?>
			<div class="row" style="padding-bottom:3px;">
				<div class="col-md-6">{{$product_name}} <strong>x {{$item['product_quantity']}}</strong></div>
				<div class="col-md-6">{{number_format($item['total_price'], 2, ".", "")}} {{$item['product_currency']}}</div>
			</div>
			<?php $total_price += floatval($item['total_price']); ?>
			<?php $total_kg += floatval($item['product_real_kg']) * floatval($item['product_quantity']); ?>
			<?php $price_currency = $item['product_currency']; ?>
			@endforeach

			<div class="row">
				<div class="col-md-6"><strong>Общо</strong></strong></div>
				<div class="col-md-6"><strong>{{number_format($total_price, 2, ".", "")}} {{$price_currency}}</strong></div>
			</div>
			<input type="hidden" name="grand_total_price{{$firm['firm_id']}}" value="{{number_format($total_price, 2, '.', '')}}" />
			<?php $grand_total_price += $total_price; ?>
			@endif
			<!-- Metodi na dostavka -->
			<div class="row" style="border-bottom:1px solid #DCDCDC;font-weight:bold;">
				<div class="col-md-6">Метод на доставка</div>
				<div class="col-md-6">Избери</div>
			</div>
			<?php $deliveries = WebdeliveriesController::getDeliveriesByFirm($firm['firm_id']); ?>
			<?php $first_delivery = 0; ?>
			@if (sizeof($deliveries) > 0)
			@foreach ($deliveries as $deliverie)
			<?php 
			$subdeliveries = SubdeliveriesController::getSubdeliveriesByDelivery($deliverie->id, $total_kg); 
			if (sizeof($subdeliveries) > 0){
				$transport_price = $subdeliveries[0]['price'];
			}else{
				$transport_price = -1;
			}
			?>
			@if ($transport_price != -1)
			<div class="row">
				<div class="col-md-6">
					{{$deliverie->name}}<br />
					<small class="text-muted">{{$deliverie->description}}</small>
				</div>
				<div class="form-check col-md-6">
					<input class="form-check-input" type="radio" onfocus="deliverieMethodsMouseUp(this.id, getValueByChecked(this.name));" data-value="{{$transport_price}}" name="deliverieMethods{{$firm['firm_id']}}" id="deliverieMethods{{$deliverie->id}}" value="{{$deliverie->id}}" <?php if ($first_delivery == 0){echo 'checked';}else{if ($deliverie->isdefault == 'Yes'){echo 'checked';}} ?>>
					<label class="form-check-label" for="deliverieMethods{{$deliverie->id}}">
						Избери доставката ({{$transport_price}} {{$properties[0]->currency}})
					</label>
				</div>
			</div>
			<?php 
				$first_delivery_price = 0;
				$deliverie_price = 0;
				if ($first_delivery == 0){
					$first_delivery_price = $transport_price;
				} 
				if ($deliverie->isdefault == 'Yes'){
					$deliverie_price = $transport_price;
				} 
			?>
            <?php
                if ($deliverie->isdefault == 'Yes'){
                    if ($deliverie_price > 0){
                        $grand_total_delivery += floatval($deliverie_price);
                    }else{
                        $grand_total_delivery += floatval($first_delivery_price);
                    }    
                }
			?>
			<?php $first_delivery++; ?>
			@endif
			@endforeach
			@else
				<?php $error_methods_delivery = "Липсва метод на доставка! Няма да можете да закупите тази стока!"; ?>
				<span style="color:red;">{{$error_methods_delivery}}</span>
			@endif
			<!-- Metodi na plashtane -->			
			<div class="row" style="border-bottom:1px solid #DCDCDC;font-weight:bold;padding-top:10px;">
				<div class="col-md-6">Метод на плащане</div>
				<div class="col-md-6">Избери</div>
			</div>
			<?php $payments = WebpaymentsController::getPaymentsByFirm($firm['firm_id']); ?>
			<?php $first_payment = 0; ?>
			@if (sizeof($payments) > 0)
			@foreach ($payments as $payment)
			<div class="row">
				<div class="col-md-6">
					{{$payment->name}}<br />
					<small class="text-muted">{{$payment->description}}</small>
				</div>
				<div class="form-check col-md-6">
					<input class="form-check-input" type="radio" name="paymentMethods{{$firm['firm_id']}}" id="paymentMethods_{{$payment->id}}" value="{{$payment->id}}" <?php if ($first_payment == 0){echo 'checked';}else{if ($payment->isdefault == 'Yes'){echo 'checked';}} ?>>
					<label class="form-check-label" for="paymentMethods_{{$payment->id}}">
						Избери плащането
					</label>
				</div>
			</div>
			<?php $first_payment++; ?>
			@endforeach
			@else
				<?php $error_methods_payment = "Липсва метод на плащане! Няма да можете да закупите тази стока!"; ?>
				<span style="color:red;">{{$error_methods_payment}}</span>
			@endif
			
		</div>
		
	</div>
	<hr />
	@endforeach
	
	@if ($error_methods_delivery == "" && $error_methods_payment == "")
	<input type="hidden" id="isok" value="Yes" />
	@else
	<input type="hidden" id="isok" value="No" />		
	@endif
	
	<h4>Обобщена поръчка</h4>
	<strong>Цена на стоките: <span id="span_grand_total_price">{{number_format($grand_total_price, 2, ".", "")}}</span> {{$properties[0]->currency}}</strong><br />
	<strong>Цена за доставка на стоките: <span id="span_grand_total_delivery">{{number_format($grand_total_delivery, 2, ".", "")}}</span> {{$properties[0]->currency}}</strong>
	<h4>Обща цена на поръчката: <span id="span_grand_total_order">{{number_format($grand_total_price + $grand_total_delivery, 2, ".", "")}}</span> {{$properties[0]->currency}}</h4>
	<hr />
	<p>Вашите лични данни ще бъдат използвани за обработка на Вашата поръчка, както и за други цели, описани в нашата <a href="/politika" target="_blank" title="Политика за поверителност">Политика за поверителност</a>.</p>
	<div class="form-check">
		{{Form::checkbox('saglasie', '', false, ['class' => 'form-check-input', 'required' => 'required'])}}
		<label class="form-check-label" for="saglasie">
			Прочетох и се съгласявам с <a href="/terms" target="_blank" title="Общите условията на уебсайта">Общите условията на уебсайта</a> *
		</label>
	</div>
	<div class="row" style="padding-top:20px;">
		<div class="col-md-12">
			{{Form::submit('Поръчване', ['class' => 'btn btn-primary', 'id' => 'submit_btn'])}}	
			<a href="cart" type="button" class="btn btn-default">Промени поръчката</a>
		</div>
	</div>
	{!! Form::close() !!}
		
	@else
		<div class="alert alert-info" role="alert">Вашата количка е празна. Все още нямате избрани продукти.</div>
	@endif
</div>

@endsection

@section('scripts')
    <script src="{{ asset('/js/order.js') }}"></script>
    <script>
        if ($("#product_typeprice").val() == "1"){
            $("#order_div").hide();
        }else{
            $("#order_div").show();
        }
        $("#btn_ok").click(function(){
            $("#order_div").show();
        });
    </script>
@stop