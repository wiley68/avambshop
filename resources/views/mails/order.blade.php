<?php use App\Http\Controllers\WebpaymentsController;?>
<?php use App\Http\Controllers\FirmsController;?>
<?php use App\Http\Controllers\ProductsController;?>
Здравейте <i>{{ $order->receiver }}</i>,
@if($order->isadmin == 'No')
<p>Вие направихте поръчка през нашия магазин. {{$order->app_name}}</p>
@else
<p>Направиха поръчка през Вашия магазин. {{$order->app_name}}</p>
@endif
 
<div>
<p><b>Поръчка номер:</b>&nbsp;{{ $order->order_id }}</p>
<p><b>Направена на:</b>&nbsp;{{ $order->order_date }}</p>

<p><b>Обща стойност на поръчката:</b>&nbsp;{{ $order->allprice }}</p>
<p><b>Начин на плащане:</b>&nbsp;{{ WebpaymentsController::getPaymentsById($order->payment)[0]->name }}</p>

@if (WebpaymentsController::getPaymentsById($order->payment)[0]->isbank == 'Yes')
<p><b>Нашите банкови данни</b></p>
<p><b>Фирма:</b>&nbsp;{{FirmsController::getFirmById($order->firm_id)[0]->firm}}</p>
<p><b>Банка:</b>&nbsp;{{WebpaymentsController::getPaymentsById($order->payment)[0]->bank_name}}</p>
<p><b>IBAN:</b>&nbsp;{{WebpaymentsController::getPaymentsById($order->payment)[0]->iban}}</p>
<p><b>BIC:</b>&nbsp;{{WebpaymentsController::getPaymentsById($order->payment)[0]->bic}}</p>
@endif

<p><b>Данни на поръчката</b></p>
<table cellspacing="0" cellpadding="0" width="100%" border="1">
	<tr>
		<th>Продукт</th>
		<th>Общо</th> 
	</tr>

	@if (isset($order->items) AND sizeof($order->items) > 0)
	@foreach ($order->items as $item)
	<tr>
		<td>{{ProductsController::getProductById($item['product_code'])->name}} x {{$item['product_quantity']}}</td>
		<td>{{$item['total_price']}}</td>
	</tr>
	@endforeach
	@endif
	
	<tr>
		<td>Междинна сума</td>
		<td>{{ $order->allprice }}</td>
	</tr>
	<tr>
		<td>Начин на плащане</td>
		<td>{{ WebpaymentsController::getPaymentsById($order->payment)[0]->name }}</td>
	</tr>
	<tr>
		<td>Общо</td>
		<td>{{ $order->allprice }}</td>
	</tr>
</table>
</div>

Благодарим Ви,
<br/>
<i>{{ $order->sender }}</i>