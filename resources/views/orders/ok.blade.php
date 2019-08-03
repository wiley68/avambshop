<?php use App\Http\Controllers\WebpaymentsController;?>
<?php use App\Http\Controllers\WebdeliveriesController;?>
<?php use App\Http\Controllers\FirmsController;?>
<?php use App\Http\Controllers\ProductsController;?>
<?php use App\Http\Controllers\PropertiesController;?>
<?php use App\Http\Controllers\SubwebordersController;?>
<?php use App\Http\Controllers\SubdeliveriesController;?>
<?php $properties = PropertiesController::getAllProperties();?>
@extends('layouts/app')

@section('content')
@if (isset($orders))
<h1><em>Получена поръчка</em></h1>
<hr />
<p>Благодарности. Вашата поръчка беше получена.</p>
@foreach ($orders as $order)
<div class="row">
	<div class="col-md-2" style="border-right: 1px dashed #DCDCDC;">
		<div class="small text-muted">НОМЕР НА ПОРЪЧКАТА:</div>
		<div><strong>{{$order['order']->id}}</strong></div>
	</div>
	<div class="col-md-2" style="border-right: 1px dashed #DCDCDC;">
		<div class="small text-muted">ДАТА:</div>
		<div><strong><?php echo date("d.m.Y H:i:s"); ?></strong></div>	
	</div>
	<div class="col-md-2" style="border-right: 1px dashed #DCDCDC;">
		<div class="small text-muted">ОБЩО:</div>
		<div><strong>{{number_format($order['order']->allprice, 2, ".", "")}}</strong></div>		
	</div>
	<div class="col-md-3">
		<div class="small text-muted">НАЧИН НА ПЛАЩАНЕ:</div>
		<div><strong>{{WebpaymentsController::getPaymentsById($order['order']->payment)[0]->name}}</strong></div>
		@if (WebpaymentsController::getPaymentsById($order['order']->payment)[0]->isbank == 'Yes')
		<div>{{FirmsController::getFirmById($order['order']->firm_id)[0]->firm}}</div>			
		<div class="small text-muted">БАНКА: {{WebpaymentsController::getPaymentsById($order['order']->payment)[0]->bank_name}}</div>
		<div class="small text-muted">IBAN: {{WebpaymentsController::getPaymentsById($order['order']->payment)[0]->iban}}</div>
		<div class="small text-muted">BIC: {{WebpaymentsController::getPaymentsById($order['order']->payment)[0]->bic}}</div>
		@endif
	</div>
	<div class="col-md-3">
		<div class="small text-muted">НАЧИН НА ДОСТАВКА:</div>
		<div><strong>{{WebdeliveriesController::getDeliveriesById($order['order']->delivery)[0]->name}}</strong></div>			
	</div>
</div>
<div style="padding-bottom:30px;"></div>
<div class="row">
	<div class="col-md-12">
	<div class="card bg-default mb-3">
		<div class="card-header">Вашата поръчка от фирма: {{FirmsController::getFirmById($order['order']->firm_id)[0]->firm}}</div>
		<ul class="list-group list-group-flush">
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-6"><strong>Продукт</strong></div>
					<div class="col-md-6"><strong>Общо</strong></div>
				</div>
			</li>
			@if (isset($order['suborder']) AND sizeof($order['suborder']) > 0)
			<?php $total_price = 0; ?>
			@foreach($order['suborder'] as $item)
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-6">{{ProductsController::getProductById($item['product_code'])->name}} <strong>x {{$item['quantity']}}</strong></div>
					<div class="col-md-6">{{number_format($item['price'], 2, ".", "")}} {{$properties[0]->currency}}</div>
				</div>
			</li>
			<?php $total_price += floatval($item['price']); ?>
			@endforeach
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-6"><strong>Междинна сума</strong></strong></div>
					<div class="col-md-6"><strong>{{number_format($total_price, 2, ".", "")}} {{$properties[0]->currency}}</strong></div>
				</div>
			</li>
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-6"><strong>Начин на плащане</strong></strong></div>
					<div class="col-md-6"><strong>{{WebpaymentsController::getPaymentsById($order['order']->payment)[0]->name}}</strong></div>
				</div>
			</li>
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-6"><strong>Начин на доставка</strong></strong></div>
                    <?php
                        $sub_weborders = SubwebordersController::getSubwebordersByWeborderId($order['order']->id);
                        $order_kg = 0;
                        foreach ($sub_weborders as $sub_weborder){
                            $order_kg += floatval($sub_weborder['kg']);
                        }
                        $price_deliveries = SubdeliveriesController::getSubdeliveriesByDelivery($order['order']->delivery, $order_kg);
                        if (sizeof($price_deliveries) > 0){
                            $price_delivery = floatval($price_deliveries[0]->price);
                        }else{
                            $price_delivery = 0.00;
                        }
                    ?>
					<div class="col-md-6"><strong>{{WebdeliveriesController::getDeliveriesById($order['order']->delivery)[0]->name}}</strong>&nbsp;(Доставка +{{ number_format($price_delivery, 2, ".", "") }}&nbsp;{{$properties[0]->currency}})</div>
				</div>
			</li>
			<li class="list-group-item">
				<div class="row">
					<div class="col-md-6"><strong>Общо</strong></strong></div>
					<div class="col-md-6"><strong>{{number_format($total_price + $price_delivery, 2, ".", "")}} {{$properties[0]->currency}}</strong></div>
				</div>
			</li>
			@endif
		</ul>
	</div>
	</div>
</div>
<hr />
<div style="padding-bottom:30px;"></div>
@endforeach
<h3>Ще се свържем с Вас за потвърждение на поръчката.</h3>
@endif
@endsection