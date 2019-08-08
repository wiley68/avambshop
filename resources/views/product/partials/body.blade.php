<script>
function changeGalleryPicture(url, code, picnomber){
    $('#product_image').css("background-image", "url("+url+"/dist/img/gallery_product/gallery"+picnomber+"_"+code+".jpg)");
    $('#product_image_body').css("background-image", "url("+url+"/dist/img/gallery_product/gallery"+picnomber+"_"+code+".jpg)");
};
function changeGalleryPictureFirst(url, code){
    $('#product_image').css("background-image", "url("+url+"/dist/img/products/product_"+code+".jpg)");
    $('#product_image_body').css("background-image", "url("+url+"/dist/img/products/product_"+code+".jpg)");
};
</script>
<?php use App\Http\Controllers\FirmsController;?>
<?php
	$shirina = "";
	$shirina_q = 70;
	$dalzina = "";
	$dalzina_q = 1000;
	$visocina = "";
	$visocina_q = 1000;
	$quantity = "";
	switch ($product->typeprice) {
		case '0':
		$typeprice = "";
		$shirina = "disabled";
		$shirina_q = 0;
		$dalzina = "disabled";
		$dalzina_q = 0;
		$visocina = "disabled";
		$visocina_q = 0;
		break;
		case 'm2':
		$typeprice = _('квадратен метър');
		$shirina = "disabled";
		$shirina_q = 0;
		$dalzina = "disabled";
		$dalzina_q = 0;
		$visocina = "disabled";
		$visocina_q = 0;
		break;
		case 'lm':
		$typeprice = _('линеен метър');
		$shirina = "disabled";
		$shirina_q = 0;
		$dalzina = "disabled";
		$dalzina_q = 0;
		$visocina = "disabled";
		$visocina_q = 0;
		break;
		case 'kg':
		$typeprice = _('килограм');
		$shirina = "disabled";
		$shirina_q = 0;
		$dalzina = "disabled";
		$dalzina_q = 0;
		$visocina = "disabled";
		$visocina_q = 0;
		break;
		case 'l':
		$typeprice = _('литър');
		$shirina = "disabled";
		$shirina_q = 0;
		$dalzina = "disabled";
		$dalzina_q = 0;
		$visocina = "disabled";
		$visocina_q = 0;
		break;
		case 'komplekt':
		$typeprice = _('комплект');
		$shirina = "disabled";
		$shirina_q = 0;
		$dalzina = "disabled";
		$dalzina_q = 0;
		$visocina = "disabled";
		$visocina_q = 0;
		break;
		case 'br':
		$typeprice = _('брой');
		$shirina = "disabled";
		$shirina_q = 0;
		$dalzina = "disabled";
		$dalzina_q = 0;
		$visocina = "disabled";
		$visocina_q = 0;
		break;
		case 'h':
		$typeprice = _('час');
		$shirina = "disabled";
		$shirina_q = 0;
		$dalzina = "disabled";
		$dalzina_q = 0;
		$visocina = "disabled";
		$visocina_q = 0;
		break;
		case 'f':
		$typeprice = _('конфигурация');
		$quantity = "disabled";
		break;
		case 't':
		$typeprice = _('конфигурация');
		$shirina = "disabled";
		$shirina_q = 0;
		$quantity = "disabled";
		break;
	}
	
	//send json data
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_URL, env('APP_SITE') . '/api/getprice.php');
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "code=6jqnh5qx24y4ibic&productcode=" . $product->code . "&h=" . $visocina_q . "&l=" . $dalzina_q . "&p=" . $shirina_q);
	$response_body = curl_exec($ch);
    curl_close($ch);
    //with or without dds
    if ($settings[0]->dds == 'Yes'){
        $real_price = floatval(json_decode($response_body)->new_price) * ( 1.00 + floatval($settings[0]->ddspurcent) / 100);
    }else{
        $real_price = floatval(json_decode($response_body)->new_price);
    }
	$real_kg = floatval(json_decode($response_body)->new_kg);
?>
<div id="message_div" class="alert alert-success" role="alert"></div>
<input type="hidden" id="app_site" value="{{ env('APP_SITE') }}" />
<div class="card">
	<div class="row">
		<!-- pictures -->
		<aside class="col-sm-5 border-right">
			<article class="gallery-wrap"> 
				<a href="#" data-toggle="modal" data-target="#modalPicture">
					<div id="product_image" class="img-big-wrap" style="background-image:url({{ env('APP_SITE') }}/dist/img/products/product_{{ substr($product->code, -4) }}.jpg);">
					</div> <!-- slider-product.// -->
				</a>
				<div class="modal fade" id="modalPicture" tabindex="-1" role="dialog" aria-labelledby="productName" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="productName">{{ $product->name }}</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<div id="product_image_body" class="img-big-wrap" style="background-image:url({{ env('APP_SITE') }}/dist/img/products/product_{{ substr($product->code, -4) }}.jpg)"></div>
							</div>
						</div>
					</div>
				</div>	
				<hr />
				<div class="img-small-wrap">
                    <div class="item-gallery"> <img onclick="changeGalleryPictureFirst('{{ env('APP_SITE') }}', '{{ substr($product->code, -4) }}');" src="{{ env('APP_SITE') }}/dist/img/products/product_{{ substr($product->code, -4) }}.jpg" onerror="this.src='{{ env('APP_SITE') }}/dist/img/products/product_.jpg'"> </div>
                    @if ($firm1->first()->isspec > 0)
                        @if ($product->gallery1 != 0)
                        <div class="item-gallery"> <img onclick="changeGalleryPicture('{{ env('APP_SITE') }}', '{{ $product->code }}', '1');" src="{{ env('APP_SITE') }}/dist/img/gallery_product/gallery1_{{ $product->code }}.jpg" onerror="this.src='{{ env('APP_SITE') }}/dist/img/products/product_.jpg'"> </div>
                        @endif
                        @if ($product->gallery2 != 0)
                        <div class="item-gallery"> <img onclick="changeGalleryPicture('{{ env('APP_SITE') }}', '{{ $product->code }}', '2');" src="{{ env('APP_SITE') }}/dist/img/gallery_product/gallery2_{{ $product->code }}.jpg" onerror="this.src='{{ env('APP_SITE') }}/dist/img/products/product_.jpg'"> </div>
                        @endif
                        @if ($product->gallery3 != 0)
                        <div class="item-gallery"> <img onclick="changeGalleryPicture('{{ env('APP_SITE') }}', '{{ $product->code }}', '3');" src="{{ env('APP_SITE') }}/dist/img/gallery_product/gallery3_{{ $product->code }}.jpg" onerror="this.src='{{ env('APP_SITE') }}/dist/img/products/product_.jpg'"> </div>
                        @endif
                        @if ($product->gallery4 != 0)
                        <div class="item-gallery"> <img onclick="changeGalleryPicture('{{ env('APP_SITE') }}', '{{ $product->code }}', '4');" src="{{ env('APP_SITE') }}/dist/img/gallery_product/gallery4_{{ $product->code }}.jpg" onerror="this.src='{{ env('APP_SITE') }}/dist/img/products/product_.jpg'"> </div>
                        @endif
                    @endif
				</div> <!-- slider-nav.// -->
			</article> <!-- gallery-wrap .end// -->
		</aside>
		<!-- pictures -->
		
		<!-- product block -->
		<input type="hidden" id="firm_id" name="firm_id" value="{{ $product->firm_id }}" />
		<input type="hidden" id="real_kg" name="real_kg" value="{{ $real_kg }}" />
		<aside class="col-sm-7">
			<article class="card-body p-5">
				<h3 class="title mb-3"><?php echo mb_strimwidth($product->name, 0, 120, "..."); ?></h3>
				<p class="price-detail-wrap"> 
					<span class="price h1"> 
						<span id="real_price" class="font-weight-bold text-primary" style="font-style:italic;">{{ number_format($real_price, 2, ".", "") }}</span> <span id="product_currency" class="text-primary" style="font-size:65%;"><em>{{ $properties[0]->currency }}&nbsp;@if($settings[0]->dds == 'No'){{ $settings[0]->text }}@endif</em></span>
					</span> 
				</p>
				
				<dl id="product_description" class="item-property">
					<dt>Описание:</dt>
					<dd><p><?php echo mb_strimwidth($product->description, 0, 120, "..."); ?></p></dd>
				</dl>
				<dl id="product_code" class="param param-feature">
					<dt>Модел №:</dt>
					<dd>{{ $product->code }}</dd>
				</dl>
				<dl class="param param-feature">
					<dt>Доставчик:</dt>
					<dd><a href="{{ route('products.by_firm', ['id' => $product->firm_id]) }}" title="Всички продукти от {{ FirmsController::getFirmById($product->firm_id)[0]->firm }}">{{ FirmsController::getFirmById($product->firm_id)[0]->firm }}</a></dd>
				</dl>				
				<hr>
				<div class="row">
					<div class="col-sm-6">
						<dl class="param param-inline">
							<dt>Количество: </dt>
							<dd>
								<div class="row">
									<div class="col-4 text-left">
										<input id="product_quantity" class="form-control text-primary" {{ $quantity }} style="width:84px;font-size:28px;font-weight:bold;" type="text" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="1" />
									</div>
									<div id="product_typeprice" class="col text-left d-flex align-items-end">
										{{ $typeprice }}
									</div>	
								</div>
							</dd>
						</dl>
					</div>
					<div class="col-sm-2">
						<dl class="param param-inline">
							<dt>Вис.</dt>
							<dd>
								<input id="h" class="form-control text-primary" {{ $visocina }} style="width:84px;font-size:20px;font-weight:bold;" type="text" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="{{ $visocina_q }}" />
							</dd>
							<dt>mm</dt>
						</dl>
					</div>
					<div class="col-sm-2">
						<dl class="param param-inline">
							<dt>Дъл.</dt>
							<dd>
								<input id="l" class="form-control text-primary" {{ $dalzina }} style="width:84px;font-size:20px;font-weight:bold;" type="text" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="{{ $dalzina_q }}" />
							</dd>
							<dt>mm</dt>
						</dl>
					</div>
					<div class="col-sm-2">
						<dl class="param param-inline">
							<dt>Шир.</dt>
							<dd>
								<input id="p" class="form-control text-primary" {{ $shirina }} style="width:84px;font-size:20px;font-weight:bold;" type="text" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="{{ $shirina_q }}" />
							</dd>
							<dt>mm</dt>
						</dl>
					</div>
				</div>
				<hr>
				<button id="btn_buy" class="btn btn-lg btn-primary text-uppercase"> КУПИ </button>
			</article>
		</aside>
		<!-- product block -->
		
	</div>
</div>

<!-- tab block -->
<div style="padding-bottom:15px;"></div>
<ul class="nav nav-tabs" id="myTab" role="tablist">
	<li class="nav-item">
		<a class="nav-link active" id="home-tab" data-toggle="tab" href="#opisanie" role="tab" aria-controls="opisanie" aria-selected="true">Описание</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" id="profile-tab" data-toggle="tab" href="#specification" role="tab" aria-controls="specification" aria-selected="false">Спецификация</a>
	</li>
</ul>
<div class="tab-content" id="myTabContent">
	<div class="tab-pane fade show active" id="opisanie" role="tabpanel" aria-labelledby="home-tab">
		<div class="card-body text-secondary">
			<h5 class="card-title">Описание на продукта: {{ $product->name }}</h5>
			<p class="card-text">{{ $product->description }}</p>
		</div>
		<hr />
	</div>
	<div class="tab-pane fade" id="specification" role="tabpanel" aria-labelledby="profile-tab">
		<div class="card-body text-secondary">
			<h5 class="card-title">Спецификация на продукта: {{ $product->name }}</h5>
			<ul class="list-group list-group-flush">
                @if ($firm1->first()->isspec > 0)
                    @if ($product->spec1 > 0)
                        <li class="list-group-item">Можете да изтеглите спецификация на продукта от тук, Документ 1: <a href="{{ env('APP_SITE') }}/dist/img/specifikacii/spec1_{{ $product->code }}.pdf" target="_blank" class="btn btn-sm btn-primary text-uppercase"> ИЗТЕГЛИ СПЕЦИФИКАЦИЯ </a></li>
                    @endif
                    @if ($product->spec2 > 0)
                        <li class="list-group-item">Можете да изтеглите спецификация на продукта от тук, Документ 2: <a href="{{ env('APP_SITE') }}/dist/img/specifikacii/spec2_{{ $product->code }}.pdf" target="_blank" class="btn btn-sm btn-primary text-uppercase"> ИЗТЕГЛИ СПЕЦИФИКАЦИЯ </a></li>
                    @endif
                    @if ($product->spec3 > 0)
                        <li class="list-group-item">Можете да изтеглите спецификация на продукта от тук, Документ 3: <a href="{{ env('APP_SITE') }}/dist/img/specifikacii/spec3_{{ $product->code }}.pdf" target="_blank" class="btn btn-sm btn-primary text-uppercase"> ИЗТЕГЛИ СПЕЦИФИКАЦИЯ </a></li>
                    @endif
                    @if ($product->spec4 > 0)
                        <li class="list-group-item">Можете да изтеглите спецификация на продукта от тук, Документ 4: <a href="{{ env('APP_SITE') }}/dist/img/specifikacii/spec4_{{ $product->code }}.pdf" target="_blank" class="btn btn-sm btn-primary text-uppercase"> ИЗТЕГЛИ СПЕЦИФИКАЦИЯ </a></li>
                    @endif
                @endif
			</ul>						
		</div>
		<hr />
	</div>
</div>
<!-- tab block -->

