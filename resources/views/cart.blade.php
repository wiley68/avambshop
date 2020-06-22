<?php use App\Http\Controllers\FirmsController;?>
@extends('layouts/app')

@section('content')
<script type="text/javascript">
	//<![CDATA[
	function refreshCart(row, firm_id, del){
		var CSRF_TOKEN = $("meta[name=csrf-token]").attr("content");
		//change item_total_price
		var object_item_quantity = $("#item_quantity_"+row+"_"+firm_id);
		var object_item_price = $("#item_price_"+row+"_"+firm_id);
		var object_item_total_price = $("#item_total_price_"+row+"_"+firm_id);
		object_item_total_price.html((parseFloat(object_item_price.html()) * parseFloat(object_item_quantity.val())).toFixed(2));
		//change grand_total_price
		var total_price = 0;
		var object_total_price = $("#total_price_"+firm_id);
		var object_grand_total_price = $("#grand_total_price");
		$("span[name='item_total_price_"+firm_id+"']")
		.each(function() {
			total_price += parseFloat($(this).html());
		});
		object_total_price.html(total_price.toFixed(2));
		var grand_total_price = 0;
		$("span[name='total_price']")
		.each(function() {
			grand_total_price += parseFloat($(this).html());
		});
		object_grand_total_price.html(grand_total_price.toFixed(2));
		
		$.ajax({
			url: '/cart/change_cart',
			type: 'POST',
			data: {
				_token: CSRF_TOKEN, 
				cart_item_id:row,
				cart_item_firm_id:firm_id,
				cart_item_quantity:object_item_quantity.val(),
				cart_item_delete:del
			},
			dataType: 'JSON',
			success: function (data) { 
				if (del == 'Yes'){
					location.reload();
				}
			}
		}); 
	};
	//]]>
</script>

<h1>Количка</h1>
<hr />

<div class="container">
	@if (isset($cart_session) AND sizeof($cart_session['firms']) > 0)
	<?php $grand_total_price = 0; ?>
	<?php $count_cart_firms = 0; ?>
	
	@foreach($cart_session['firms'] as $firm)
	
	<div class="card">
		<div class="card-header">
			<h4>Количка на Фирма - {{ FirmsController::getFirmById($firm['firm_id'])[0]->firm }}</h4>
		</div>
		
		<table id="cart" class="table table-hover table-condensed">
			<thead>
				<tr>
					<th style="width:50%">Продукт</th>
					<th style="width:10%">Цена</th>
					<th style="width:10%">м.е.</th>
					<th style="width:8%">Количество</th>
					<th style="width:18%" class="text-center">Общо</th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				<?php $total_price = 0; ?>
				<?php $count_cart = 0; ?>
				@foreach($firm['items'] as $item)
				<?php
					if(isset($item['product_name'])){
						$item_product_name = $item['product_name'];
					}else{
						$item_product_name = "";
					}
					if(isset($item['product_description'])){
						$item_product_description = $item['product_description'];
					}else{
						$item_product_description = "";
					}
					if(isset($item['product_quantity'])){
						$item_product_quantity = $item['product_quantity'];
					}else{
						$item_product_quantity = 1;
					}
					if(isset($item['product_h'])){
						$item_product_h = $item['product_h'];
					}else{
						$item_product_h = 0;
					}
					if(isset($item['product_l'])){
						$item_product_l = $item['product_l'];
					}else{
						$item_product_l = 0;
					}
					if(isset($item['product_p'])){
						$item_product_p = $item['product_p'];
					}else{
						$item_product_p = 0;
					}
					if(isset($item['product_real_kg'])){
						$item_product_real_kg = number_format(floatval($item['product_real_kg']), 2, ".", "");
					}else{
						$item_product_real_kg = 0;
					}
					if(isset($item['total_price'])){
						$item_total_price = $item['total_price'];
						$item_price = number_format(floatval($item_total_price) / floatval($item_product_quantity), 2, ".", "");
						$total_price += floatval($item_total_price);
					}else{
						$item_total_price = "0";
						$item_price = "0";
						$total_price = "0";
					}
					if(isset($item['product_currency'])){
						$item_product_currency = $item['product_currency'];
					}else{
						$item_product_currency = "лв";
					}
					if(isset($item['product_code'])){
						$item_product_code = $item['product_code'];
					}else{
						$item_product_code = "";
					}
					switch ($item['product_typeprice']) {
						case '0':
							$typeprice = "";
						break;
						case 'm2':
							$typeprice = _('квадратен метър');
						break;
						case 'lm':
							$typeprice = _('линеен метър');
						break;
						case 'kg':
							$typeprice = _('килограм');
						break;
						case 'l':
							$typeprice = _('литър');
						break;
						case 'komplekt':
							$typeprice = _('комплект');
						break;
						case 'br':
							$typeprice = _('брой');
						break;
						case 'h':
							$typeprice = _('час');
						break;
						case 'km':
							$typeprice = _('километър');
						break;
						case 'f':
							$typeprice = 'изделие';
						break;
						case 't':
							$typeprice = 'изделие';
						break;
						default:
							$typeprice = _('брой');
						break;
					}
				?>
				<tr>
					<td data-th="Продукт">
						<div class="row">
							<div class="col-sm-3 hidden-xs"><img src="{{ env('APP_SITE') }}/dist/img/products/product_{{ substr($item_product_code, -4) }}.jpg" alt="{{$item_product_name}}" style="max-width:100px;" class="img-responsive" onerror="this.src='{{ env('APP_SITE') }}/dist/img/products/product_.jpg'" /></div>
							<div class="col-sm-9">
								<h4 class="nomargin"><a href="/product?pid={{$item_product_code}}" title="{{$item_product_name}}">{{$item_product_name}}</a></h4>
								<p>{{$item_product_description}}
									@if ($item_product_h != 0)
									<br />Височина (h): {{$item_product_h}} мм.
									@endif
									@if ($item_product_l != 0)
									<br />Дължина (l): {{$item_product_l}} мм.
									@endif
									@if ($item_product_p != 0)
									<br />Широчина (p): {{$item_product_p}} мм.
									@endif
									@if ($item_product_real_kg != 0)
									<br />Тегло: {{$item_product_real_kg}} kg.
									@endif
								</p>
								<p class="small"><em>SKU: {{$item_product_code}}</em></p>
							</div>
						</div>
					</td>
					<td data-th="Цена"><span id="item_price_<?php echo $count_cart; ?>_<?php echo $count_cart_firms; ?>">{{$item_price}}</span> {{$item_product_currency}}</td>
					<td data-th="м.е.">{{$typeprice}}</td>
					<td data-th="Количество">
						<input type="number" min="1" id="item_quantity_<?php echo $count_cart; ?>_<?php echo $count_cart_firms; ?>" class="form-control text-center" value="{{$item_product_quantity}}" onchange="refreshCart('{{$count_cart}}', '{{$count_cart_firms}}', 'No');" >
					</td>
					<td data-th="Общо" class="text-center"><span name="item_total_price_<?php echo $count_cart_firms; ?>" id="item_total_price_<?php echo $count_cart; ?>_<?php echo $count_cart_firms; ?>">{{number_format($item_total_price, 2, ".", "")}}</span> {{$item_product_currency}}</td>
					<td class="actions" data-th="">
						<button class="btn btn-danger btn-sm" title="Изтрий продукта" onclick="refreshCart('{{$count_cart}}', '{{$count_cart_firms}}', 'Yes');"><i class="fa fa-trash-o"></i></button>								
					</td>
				</tr>
				<?php $count_cart++ ?>
				@endforeach	
			</tbody>
			<tfoot>
				<?php $grand_total_price += $total_price; ?>
				<tr class="visible-xs">
					<td class="text-center"><strong>Обща цена в количката: <span name="total_price" id="total_price_<?php echo $count_cart_firms; ?>">{{number_format($total_price, 2, ".", "")}}</span> {{$item_product_currency}}</strong></td>
				</tr>
			</tfoot>
		</table>
	</div>
	<div style="padding-bottom:10px;"></div>
	<?php $count_cart_firms++ ?>	
	@endforeach
	<div style="padding-bottom:20px;"></div>
	<div class="row">
		<div class="col-md-12 text-right">
			<h3>Общо за плащане: <span id="grand_total_price">{{number_format($grand_total_price, 2, ".", "")}}</span> {{$item_product_currency}}</h3>
		</div>
		<div class="col-md-6">
			<a href="/products" class="btn btn-warning btn-block"><i class="fa fa-angle-left"></i> Продължи с пазаруването</a>
		</div>
		<div class="col-md-6">
			<a href="/order" class="btn btn-success btn-block">Приключване на поръчката <i class="fa fa-angle-right"></i></a>
		</div>
	</div>
	@else
	<div class="alert alert-info" role="alert">Вашата количка е празна. Все още нямате избрани продукти.</div>
	@endif
</div>

@endsection
