<?php use App\Http\Controllers\PropertiesController;?>
<?php use App\Http\Controllers\FirmsController;?>
<?php use App\Http\Controllers\WebsettingsController;?>
<?php $properties = PropertiesController::getAllProperties();?> 
<?php $settings = WebsettingsController::getAllSettings(); ?>
<?php
	//send json data
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, env('APP_SITE') . '/api/getprice.php');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "code=6jqnh5qx24y4ibic&productcode=" . $product->code . "&h=1000&l=1000&p=70");
	$response_body = curl_exec($ch);
    curl_close($ch);
    //with or without dds
    if ($settings[0]->dds == 'Yes'){
        $real_price = floatval(json_decode($response_body)->new_price) * ( 1.00 + floatval($settings[0]->ddspurcent) / 100);
    }else{
        $real_price = floatval(json_decode($response_body)->new_price);
    }
?>
	<?php $firm1 = FirmsController::getFirmById($product->firm_id);?> 
	<div class="card border-info mb-3 shadow-lg bg-white rounded">
		<div class="photo text-center containerdiv" style="height:260px;margin:2px;overflow:hidden;">
			<a href="/product?pid={{ $product->code }}" title="Разгледай подробно продукта {{ $product->name }}"> 
				<img src="{{ env('APP_SITE') }}/dist/img/products/product_{{ substr($product->code, -4) }}.jpg" class="img-thumbnail" alt="{{ $product->code }}" onerror="this.src='{{ env('APP_SITE') }}/dist/img/products/product_.jpg'" /> 
			</a>
			<img class="cornerimage" border="0" src="{{ env('APP_SITE') }}/dist/img/logo_{{ $product->firm_id }}.jpg" alt="{{ $firm1[0]->firm }}" title="{{ $firm1[0]->firm }}" style="position:absolute;width:30px;top:5px;right:5px;z-index:2;border:1px solid silver;">
		</div>
		<div class="card-body">
			<a href="/product?pid={{ $product->code }}" title="Разгледай подробно продукта {{ $product->name }}"><p class="card-title text-truncate"><strong>{{ $product->name }}</strong></p></a>
			<small class="text-muted"><?php echo mb_strimwidth($product->description, 0, 80, "..."); ?></small>
		</div>
		<ul class="list-group list-group-flush">
			<li class="list-group-item">{{ $product->code }}</li>
		</ul>
		<div class="card-footer">
			@if($product->real_price != '0.00')
				<h5 class="font-weight-bold float-right">{{ number_format($real_price, 2, ".", "") }} <small class="text-muted">{{ $properties[0]->currency }}&nbsp;@if($settings[0]->dds == 'No'){{ $settings[0]->text }}@endif</small></h5>
			@endif
		</div>
	</div>
