<?php use App\Http\Controllers\PropertiesController;?>
<?php use App\Http\Controllers\FirmsController;?>
<?php use App\Http\Controllers\WebsettingsController;?>
<?php $properties = PropertiesController::getAllProperties();?> 
<?php $settings = WebsettingsController::getAllSettings(); ?>
<?php
	//calulate price
	if (array_key_exists(0, $product)){
		//send json data
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, env('APP_SITE') . '/api/getprice.php');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "code=6jqnh5qx24y4ibic&productcode=" . $product[0]->code . "&h=1000&l=1000&p=70");
		$response_body_0 = curl_exec($ch);
		curl_close($ch);
        //with or without dds
        if ($settings[0]->dds == 'Yes'){
            $real_price_0 = floatval(json_decode($response_body_0)->new_price) * ( 1.00 + floatval($settings[0]->ddspurcent) / 100);
			$dds_text_0 = '(цена с ДДС)';
		}else{
			$real_price_0 = floatval(json_decode($response_body_0)->new_price);
			$dds_text_0 = '(цена без ДДС)';
        }
		$real_kg_0 = floatval(json_decode($response_body_0)->new_kg);
	}
	if (array_key_exists(1, $product)){
		//send json data
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, env('APP_SITE') . '/api/getprice.php');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "code=6jqnh5qx24y4ibic&productcode=" . $product[1]->code . "&h=1000&l=1000&p=70");
		$response_body_1 = curl_exec($ch);
		curl_close($ch);
        //with or without dds
        if ($settings[0]->dds == 'Yes'){
            $real_price_1 = floatval(json_decode($response_body_1)->new_price) * ( 1.00 + floatval($settings[0]->ddspurcent) / 100);
			$dds_text_1 = '(цена с ДДС)';
		}else{
			$real_price_1 = floatval(json_decode($response_body_1)->new_price);
			$dds_text_1 = '(цена без ДДС)';
        }
		$real_kg_1 = floatval(json_decode($response_body_1)->new_kg);
	}
	if (array_key_exists(2, $product)){
		//send json data
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, env('APP_SITE') . '/api/getprice.php');
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "code=6jqnh5qx24y4ibic&productcode=" . $product[2]->code . "&h=1000&l=1000&p=70");
		$response_body_2 = curl_exec($ch);
		curl_close($ch);
        //with or without dds
        if ($settings[0]->dds == 'Yes'){
            $real_price_2 = floatval(json_decode($response_body_2)->new_price) * ( 1.00 + floatval($settings[0]->ddspurcent) / 100);
			$dds_text_2 = '(цена с ДДС)';
		}else{
			$real_price_2 = floatval(json_decode($response_body_2)->new_price);
			$dds_text_2 = '(цена без ДДС)';
        }
		$real_kg_2 = floatval(json_decode($response_body_2)->new_kg);
	}
?>
<div class="card-deck">
	<?php if (array_key_exists(0, $product)){ ?>
    <?php
	switch ($product[0]->typeprice) {
		case '0':
		$typeprice0 = "";
		break;
		case 'm2':
		$typeprice0 = _('квадратен метър');
		break;
		case 'lm':
		$typeprice0 = _('линеен метър');
		break;
		case 'kg':
		$typeprice0 = _('килограм');
		break;
		case 'l':
		$typeprice0 = _('литър');
		break;
		case 'komplekt':
		$typeprice0 = _('комплект');
		break;
		case 'br':
		$typeprice0 = _('брой');
		break;
		case 'h':
		$typeprice0 = _('час');
		break;
		case 'km':
		$typeprice0 = _('километър');
		break;
		case 'f':
		$typeprice0 = _('конфигурация');
		break;
		case 't':
		$typeprice0 = _('конфигурация');
		break;
		default:
		$typeprice0 = _('брой');
		break;
	}
    ?>
	<?php $firm1 = FirmsController::getFirmById($product[0]->firm_id);?>
	<input type="hidden" id="product_type_price_{{ $product[0]->code }}" value="{{$product[0]->typeprice}}" />
	<input type="hidden" id="product_currency_{{ $product[0]->code }}" value="{{$properties[0]->currency}}" />
	<input type="hidden" id="product_firm_id_{{ $product[0]->code }}" value="{{$product[0]->firm_id}}" />
	<input type="hidden" id="real_kg_{{ $product[0]->code }}" value="{{$real_kg_0}}" />
	<div class="card border-info mb-3 shadow-lg bg-white rounded">
		<div class="photo text-center containerdiv" style="height:260px;margin:2px;overflow:hidden;">
			<a href="/product?pid={{ $product[0]->code }}" title="Разгледай подробно продукта {{ $product[0]->name }}"> 
				<img src="{{ env('APP_SITE') }}/dist/img/products/product_{{ substr($product[0]->code, -4) }}.jpg" class="img-thumbnail" alt="{{ $product[0]->code }}" onerror="this.src='{{ env('APP_SITE') }}/dist/img/products/product_.jpg'" /> 
			</a>
			<img class="cornerimage" border="0" src="{{ env('APP_SITE') }}/dist/img/logo_{{ $product[0]->firm_id }}.jpg" alt="{{ $firm1[0]->firm }}" title="{{ $firm1[0]->firm }}" style="position:absolute;width:30px;top:5px;right:5px;z-index:2;border:1px solid silver;">
		</div>
		<div class="card-body">
			<a href="/product?pid={{ $product[0]->code }}" title="Разгледай подробно продукта {{ $product[0]->name }}"><p class="card-title text-truncate"><strong id="product_name_{{ $product[0]->code }}">{{ $product[0]->name }}</strong></p></a>
			<small class="text-muted"><span id="product_description_{{ $product[0]->code }}"><?php echo mb_strimwidth($product[0]->description, 0, 80, "..."); ?></span>&nbsp;<span>(Цена за: {{ $typeprice0 }})</span></small>
		</div>
		<ul class="list-group list-group-flush">
			<li class="list-group-item">{{ $product[0]->code }}</li>
		</ul>
		<div class="card-footer">
			@if($real_price_0 == '0.00')
				<a href="{{ route('request-product', ['id' => $product[0]->code]) }}" class="btn btn-outline-info float-left shadow-sm">Запитай</a>				
			@else
				<button name="btn_buy" id="{{ $product[0]->code }}" class="btn btn-primary float-left shadow-sm">Купи</button>
				<h5 class="font-weight-bold float-right"><span id="real_price_{{ $product[0]->code }}">{{ number_format($real_price_0, 2, ".", "") }}</span> <span style="font-size: 10px;" class="text-muted">{{ $properties[0]->currency }}&nbsp;{{ $dds_text_0 }}</span></h5>
			@endif
		</div>
	</div>
	<?php } ?>
	<?php if (array_key_exists(1, $product)){ ?>
    <?php
	switch ($product[1]->typeprice) {
		case '0':
		$typeprice1 = "";
		break;
		case 'm2':
		$typeprice1 = _('квадратен метър');
		break;
		case 'lm':
		$typeprice1 = _('линеен метър');
		break;
		case 'kg':
		$typeprice1 = _('килограм');
		break;
		case 'l':
		$typeprice1 = _('литър');
		break;
		case 'komplekt':
		$typeprice1 = _('комплект');
		break;
		case 'br':
		$typeprice1 = _('брой');
		break;
		case 'h':
		$typeprice1 = _('час');
		break;
		case 'km':
		$typeprice1 = _('километър');
		break;
		case 'f':
		$typeprice1 = _('конфигурация');
		break;
		case 't':
		$typeprice1 = _('конфигурация');
		break;
		default:
		$typeprice1 = _('брой');
		break;
	}
    ?>
	<?php $firm2 = FirmsController::getFirmById($product[1]->firm_id);?> 
	<input type="hidden" id="product_type_price_{{ $product[1]->code }}" value="{{$product[1]->typeprice}}" />
	<input type="hidden" id="product_currency_{{ $product[1]->code }}" value="{{$properties[0]->currency}}" />
	<input type="hidden" id="product_firm_id_{{ $product[1]->code }}" value="{{$product[1]->firm_id}}" />
	<input type="hidden" id="real_kg_{{ $product[1]->code }}" value="{{$real_kg_1}}" />
	<div class="card border-info mb-3 shadow-lg bg-white rounded">
		<div class="photo text-center" style="height:260px;margin:2px;overflow:hidden;">
			<a href="/product?pid={{ $product[1]->code }}" title="Разгледай подробно продукта {{ $product[1]->name }}"> 
				<img src="{{ env('APP_SITE') }}/dist/img/products/product_{{ substr($product[1]->code, -4) }}.jpg" class="img-thumbnail" alt="{{ $product[1]->code }}" onerror="this.src='{{ env('APP_SITE') }}/dist/img/products/product_.jpg'" /> 
			</a>
			<img class="cornerimage" border="0" src="{{ env('APP_SITE') }}/dist/img/logo_{{ $product[1]->firm_id }}.jpg" alt="{{ $firm2[0]->firm }}" title="{{ $firm2[0]->firm }}" style="position:absolute;width:30px;top:5px;right:5px;z-index:2;border:1px solid silver;">
		</div>
		<div class="card-body">
			<a href="/product?pid={{ $product[1]->code }}" title="Разгледай подробно продукта {{ $product[1]->name }}"><p class="card-title text-truncate"><strong>{{ $product[1]->name }}</strong></p></a>
			<small class="text-muted"><span id="product_description_{{ $product[1]->code }}"><?php echo mb_strimwidth($product[1]->description, 0, 80, "..."); ?></span>&nbsp;<span>(Цена за: {{ $typeprice1 }})</span></small>
		</div>
		<ul class="list-group list-group-flush">
			<li class="list-group-item">{{ $product[1]->code }}</li>
		</ul>
		<div class="card-footer">
			@if($real_price_1 == '0.00')
				<a href="{{ route('request-product', ['id' => $product[1]->code]) }}" class="btn btn-outline-info float-left shadow-sm">Запитай</a>				
			@else
				<button name="btn_buy" id="{{ $product[1]->code }}" class="btn btn-primary float-left shadow-sm">Купи</button>
				<h5 class="font-weight-bold float-right"><span id="real_price_{{ $product[1]->code }}">{{ number_format($real_price_1, 2, ".", "") }}</span> <span style="font-size: 10px;" class="text-muted">{{ $properties[0]->currency }}&nbsp;{{ $dds_text_1 }}</span></h5>
			@endif
		</div>
	</div>
	<?php }else{ ?>
	<div class="card mb-3 border-light bg-white">
	</div>
	<?php } ?>
	<?php if (array_key_exists(2, $product)){ ?>
    <?php
	switch ($product[2]->typeprice) {
		case '0':
		$typeprice2 = "";
		break;
		case 'm2':
		$typeprice2 = _('квадратен метър');
		break;
		case 'lm':
		$typeprice2 = _('линеен метър');
		break;
		case 'kg':
		$typeprice2 = _('килограм');
		break;
		case 'l':
		$typeprice2 = _('литър');
		break;
		case 'komplekt':
		$typeprice2 = _('комплект');
		break;
		case 'br':
		$typeprice2 = _('брой');
		break;
		case 'h':
		$typeprice2 = _('час');
		break;
		case 'km':
		$typeprice2 = _('километър');
		break;
		case 'f':
		$typeprice2 = _('конфигурация');
		break;
		case 't':
		$typeprice2 = _('конфигурация');
		break;
		default:
		$typeprice2 = _('брой');
		break;
	}
    ?>
	<?php $firm3 = FirmsController::getFirmById($product[2]->firm_id);?> 
	<input type="hidden" id="product_type_price_{{ $product[2]->code }}" value="{{$product[2]->typeprice}}" />
	<input type="hidden" id="product_currency_{{ $product[2]->code }}" value="{{$properties[0]->currency}}" />
	<input type="hidden" id="product_firm_id_{{ $product[2]->code }}" value="{{$product[2]->firm_id}}" />
	<input type="hidden" id="real_kg_{{ $product[2]->code }}" value="{{$real_kg_2}}" />
	<div class="card border-info mb-3 shadow-lg bg-white rounded">
		<div class="photo text-center" style="height:260px;margin:2px;overflow:hidden;">
			<a href="/product?pid={{ $product[2]->code }}" title="Разгледай подробно продукта {{ $product[2]->name }}"> 
				<img src="{{ env('APP_SITE') }}/dist/img/products/product_{{ substr($product[2]->code, -4) }}.jpg" class="img-thumbnail" alt="{{ $product[2]->code }}" onerror="this.src='{{ env('APP_SITE') }}/dist/img/products/product_.jpg'" /> 
			</a>
			<img class="cornerimage" border="0" src="{{ env('APP_SITE') }}/dist/img/logo_{{ $product[2]->firm_id }}.jpg" alt="{{ $firm3[0]->firm }}" title="{{ $firm3[0]->firm }}" style="position:absolute;width:30px;top:5px;right:5px;z-index:2;border:1px solid silver;">
		</div>
		<div class="card-body">
			<a href="/product?pid={{ $product[2]->code }}" title="Разгледай подробно продукта {{ $product[2]->name }}"><p class="card-title text-truncate"><strong>{{ $product[2]->name }}</strong></p></a>
			<small class="text-muted"><span id="product_description_{{ $product[2]->code }}"><?php echo mb_strimwidth($product[2]->description, 0, 80, "..."); ?></span>&nbsp;<span>(Цена за: {{ $typeprice2 }})</span></small>
		</div>
		<ul class="list-group list-group-flush">
			<li class="list-group-item">{{ $product[2]->code }}</li>
		</ul>
		<div class="card-footer">
			@if($real_price_2 == '0.00')
				<a href="{{ route('request-product', ['id' => $product[2]->code]) }}" class="btn btn-outline-info float-left shadow-sm">Запитай</a>				
			@else
				<button name="btn_buy" id="{{ $product[2]->code }}" class="btn btn-primary float-left shadow-sm">Купи</button>
				<h5 class="font-weight-bold float-right"><span id="real_price_{{ $product[2]->code }}">{{ number_format($real_price_2, 2, ".", "") }}</span> <span style="font-size: 10px;" class="text-muted">{{ $properties[0]->currency }}&nbsp;{{ $dds_text_2 }}</span></h5>
			@endif
		</div>
	</div>
	<?php }else{ ?>
	<div class="card mb-3 border-light bg-white">
	</div>
	<?php } ?>
</div>
<div style="padding-bottom:10px;"></div>
