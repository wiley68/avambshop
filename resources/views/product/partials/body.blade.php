<?php use App\Product; ?>
<script>
function changeGalleryPicture(url, code, picnomber){
    $('#product_image').css("background-image", "url("+url+"/dist/img/gallery_product/gallery"+picnomber+"_"+code+".jpg)");
    $('#product_image_body').css("background-image", "url("+url+"/dist/img/gallery_product/gallery"+picnomber+"_"+code+".jpg)");
};
function changeGalleryPictureFirst(url, code){
    $('#product_image').css("background-image", "url("+url+"/dist/img/products/product_"+code+".jpg)");
    $('#product_image_body').css("background-image", "url("+url+"/dist/img/products/product_"+code+".jpg)");
};
function buyOption (real_price, productName, product_typeprice, product_description, product_currency, product_code, h, l, p, real_kg, firm_id) {
    $.ajax({
        url: '/product/set_session',
        type: 'POST',
        data: {
            _token: $('meta[name="csrf-token"]').attr('content'),
            total_price: real_price,
            product_name: productName,
            product_quantity: $("#product_quantity").val(),
            product_typeprice: product_typeprice,
            product_description: product_description,
            product_currency: product_currency,
            product_code: product_code,
            product_h: h,
            product_l: l,
            product_p: p,
            product_real_kg: real_kg,
            product_firm_id: firm_id
        },
        dataType: 'JSON',
        success: function (data) {
            if ($("#cart_mini").is(":visible")) {
                var curr_count = parseInt($("#count_cart_items").html());
                curr_count++;
                $("#count_cart_items").html(curr_count.toString());
            } else {
                $("#count_cart_items").html("1");
            }
            window.scrollTo(0, 0);
            $("#message_div").show("slow", function () {
                $("#message_div").html("Успешно добавихте продукта. Можете да продължите с разглеждането на <a href='/' title='Онлайн магазин AVAMB.'>магазина</a> ни, или да закупите продуктите във вашата <a href='/cart' title='Вижте съдържанието на Вашата Количка.'>Количка</a>.");
            });
        }
    });
};
</script>
<?php use App\Http\Controllers\FirmsController;?>
<?php
	$shirina = "";
	$shirina_q = 0;
	$dalzina = "";
	$dalzina_q = 0;
	$visocina = "";
	$visocina_q = 0;
    $quantity = "";
    $txt_velicini = "";
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
		case 'km':
		$typeprice = _('километър');
		$shirina = "disabled";
		$shirina_q = 0;
		$dalzina = "disabled";
		$dalzina_q = 0;
		$visocina = "disabled";
		$visocina_q = 0;
		break;
		case 'f':
		$typeprice = 'конфигурация';
        $quantity = "disabled";
        $pos_p = strpos(strtolower($product->formula), 'p');
        if ($pos_p === false){
            $shirina = "disabled";
		    $shirina_q = 0;
        }
        $txt_velicini = "Попълнете величините в белите карета.";
		break;
		case 't':
		$typeprice = 'конфигурация';
		$shirina = "disabled";
		$shirina_q = 0;
        $quantity = "disabled";
        $txt_velicini = "Попълнете величините в белите карета.";
		break;
		default:
		$typeprice = _('брой');
		$shirina = "disabled";
		$shirina_q = 0;
		$dalzina = "disabled";
		$dalzina_q = 0;
		$visocina = "disabled";
		$visocina_q = 0;
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
        $dds_text = '(цена с ДДС)';
    }else{
        $real_price = floatval(json_decode($response_body)->new_price);
        $dds_text = '(цена без ДДС)';
    }
	$real_kg = floatval(json_decode($response_body)->new_kg);
?>
<br />
<div id="message_div" class="alert alert-success" role="alert"></div>
<input type="hidden" id="app_site" value="{{ env('APP_SITE') }}" />
<input type="hidden" id="dds" value="{{ $settings[0]->dds }}">
<input type="hidden" id="dds_purcent" value="{{ $settings[0]->ddspurcent }}">
<div class="card">
    <div class="row">
        <!-- pictures -->
        <aside class="col-sm-5 border-right">
            <article class="gallery-wrap">
                <a href="#" data-toggle="modal" data-target="#modalPicture">
                    <div id="product_image" class="img-big-wrap"
                        style="background-image:url({{ env('APP_SITE') }}/dist/img/products/product_{{ substr($product->code, -4) }}.jpg);">
                    </div> <!-- slider-product.// -->
                </a>
                <div class="modal fade" id="modalPicture" tabindex="-1" role="dialog" aria-labelledby="productName"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="productName">{{ $product->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div id="product_image_body" class="img-big-wrap"
                                    style="background-image:url({{ env('APP_SITE') }}/dist/img/products/product_{{ substr($product->code, -4) }}.jpg)">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr />
                <div class="img-small-wrap">
                    <div class="item-gallery"> <img
                            onclick="changeGalleryPictureFirst('{{ env('APP_SITE') }}', '{{ substr($product->code, -4) }}');"
                            src="{{ env('APP_SITE') }}/dist/img/products/product_{{ substr($product->code, -4) }}.jpg"
                            onerror="this.src='{{ env('APP_SITE') }}/dist/img/products/product_.jpg'"> </div>
                    @if ($firm1->first()->isspec > 0)
                    @if ($product->gallery1 != 0)
                    <div class="item-gallery"> <img
                            onclick="changeGalleryPicture('{{ env('APP_SITE') }}', '{{ $product->code }}', '1');"
                            src="{{ env('APP_SITE') }}/dist/img/gallery_product/gallery1_{{ $product->code }}.jpg"
                            onerror="this.src='{{ env('APP_SITE') }}/dist/img/products/product_.jpg'"> </div>
                    @endif
                    @if ($product->gallery2 != 0)
                    <div class="item-gallery"> <img
                            onclick="changeGalleryPicture('{{ env('APP_SITE') }}', '{{ $product->code }}', '2');"
                            src="{{ env('APP_SITE') }}/dist/img/gallery_product/gallery2_{{ $product->code }}.jpg"
                            onerror="this.src='{{ env('APP_SITE') }}/dist/img/products/product_.jpg'"> </div>
                    @endif
                    @if ($product->gallery3 != 0)
                    <div class="item-gallery"> <img
                            onclick="changeGalleryPicture('{{ env('APP_SITE') }}', '{{ $product->code }}', '3');"
                            src="{{ env('APP_SITE') }}/dist/img/gallery_product/gallery3_{{ $product->code }}.jpg"
                            onerror="this.src='{{ env('APP_SITE') }}/dist/img/products/product_.jpg'"> </div>
                    @endif
                    @if ($product->gallery4 != 0)
                    <div class="item-gallery"> <img
                            onclick="changeGalleryPicture('{{ env('APP_SITE') }}', '{{ $product->code }}', '4');"
                            src="{{ env('APP_SITE') }}/dist/img/gallery_product/gallery4_{{ $product->code }}.jpg"
                            onerror="this.src='{{ env('APP_SITE') }}/dist/img/products/product_.jpg'"> </div>
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
                        <span id="real_price" class="font-weight-bold text-primary"
                            style="font-style:italic;">{{ number_format($real_price, 2, ".", "") }}</span> <span
                            id="product_currency" class="text-primary"
                            style="font-size:65%;"><em>{{ $properties[0]->currency }}&nbsp;{{ $dds_text }}</em></span>
                    </span>
                </p>

                <dl id="product_description" class="item-property">
                    <dt>Описание:</dt>
                    <dd>
                        <p><?php echo mb_strimwidth($product->description, 0, 120, "..."); ?></p>
                    </dd>
                </dl>
                <dl id="product_code" class="param param-feature">
                    <dt>Модел №:</dt>
                    <dd>{{ $product->code }}</dd>
                </dl>
                <dl class="param param-feature">
                    <dt>Доставчик:</dt>
                    <dd><a href="{{ route('products.by_firm', ['id' => $product->firm_id]) }}"
                            title="Всички продукти от {{ FirmsController::getFirmById($product->firm_id)[0]->firm }}">{{ FirmsController::getFirmById($product->firm_id)[0]->firm }}</a>
                    </dd>
                </dl>
                <hr>
                <div class="row">
                    <div class="col-sm-6">
                        <dl class="param param-inline">
                            <dt>Количество: </dt>
                            <dd>
                                <div class="row">
                                    <div class="col-4 text-left">
                                        <input id="product_quantity" class="form-control text-primary" {{ $quantity }}
                                            style="width:84px;font-size:28px;font-weight:bold;" type="text"
                                            onkeyup="this.value=this.value.replace(/[^0-9.]/g,'');" value="1" />
                                    </div>
                                    <div class="col text-left d-flex align-items-end">
                                        {{ $typeprice }}
                                    </div>
                                    <input type="hidden" id="product_typeprice" value="{{ $product->typeprice }}">
                                </div>
                            </dd>
                        </dl>
                    </div>
                    <div class="col-sm-2">
                        <dl class="param param-inline">
                            <dt>Вис.(H)</dt>
                            <dd>
                                <input id="h" class="form-control text-primary" {{ $visocina }}
                                    style="width:84px;font-size:20px;font-weight:bold;" type="text"
                                    onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="{{ $visocina_q }}" />
                            </dd>
                            <dt>mm</dt>
                        </dl>
                    </div>
                    <div class="col-sm-2">
                        <dl class="param param-inline">
                            <dt>Шир.(L)</dt>
                            <dd>
                                <input id="l" class="form-control text-primary" {{ $dalzina }}
                                    style="width:84px;font-size:20px;font-weight:bold;" type="text"
                                    onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="{{ $dalzina_q }}" />
                            </dd>
                            <dt>mm</dt>
                        </dl>
                    </div>
                    <div class="col-sm-2">
                        <dl class="param param-inline">
                            <dt>Дълб.(P)</dt>
                            <dd>
                                <input id="p" class="form-control text-primary" {{ $shirina }}
                                    style="width:84px;font-size:20px;font-weight:bold;" type="text"
                                    onkeyup="this.value=this.value.replace(/[^0-9]/g,'');" value="{{ $shirina_q }}" />
                            </dd>
                            <dt>mm</dt>
                        </dl>
                    </div>
                </div>
                @if ($txt_velicini != "")
                <div class="row">
                    <div class="col-sm-12" style="font-size:18px;color:red;">
                        {{ $txt_velicini }}
                    </div>
                </div>                    
                @endif
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
        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#opisanie" role="tab" aria-controls="opisanie"
            aria-selected="true">Описание</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#specification" role="tab"
            aria-controls="specification" aria-selected="false">Спецификация</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="options-tab" data-toggle="tab" href="#options" role="tab" aria-controls="options"
            aria-selected="false">Опции към продукта</a>
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
                <li class="list-group-item">Можете да изтеглите спецификация на продукта от тук, Документ 1: <a
                        href="{{ env('APP_SITE') }}/dist/img/specifikacii/spec1_{{ $product->code }}.pdf"
                        target="_blank" class="btn btn-sm btn-primary text-uppercase"> ИЗТЕГЛИ СПЕЦИФИКАЦИЯ </a></li>
                @endif
                @if ($product->spec2 > 0)
                <li class="list-group-item">Можете да изтеглите спецификация на продукта от тук, Документ 2: <a
                        href="{{ env('APP_SITE') }}/dist/img/specifikacii/spec2_{{ $product->code }}.pdf"
                        target="_blank" class="btn btn-sm btn-primary text-uppercase"> ИЗТЕГЛИ СПЕЦИФИКАЦИЯ </a></li>
                @endif
                @if ($product->spec3 > 0)
                <li class="list-group-item">Можете да изтеглите спецификация на продукта от тук, Документ 3: <a
                        href="{{ env('APP_SITE') }}/dist/img/specifikacii/spec3_{{ $product->code }}.pdf"
                        target="_blank" class="btn btn-sm btn-primary text-uppercase"> ИЗТЕГЛИ СПЕЦИФИКАЦИЯ </a></li>
                @endif
                @if ($product->spec4 > 0)
                <li class="list-group-item">Можете да изтеглите спецификация на продукта от тук, Документ 4: <a
                        href="{{ env('APP_SITE') }}/dist/img/specifikacii/spec4_{{ $product->code }}.pdf"
                        target="_blank" class="btn btn-sm btn-primary text-uppercase"> ИЗТЕГЛИ СПЕЦИФИКАЦИЯ </a></li>
                @endif
                @endif
            </ul>
        </div>
        <hr />
    </div>
    <div class="tab-pane fade" id="options" role="tabpanel" aria-labelledby="option-tab">
        <div class="card-body text-secondary">
            <table id="dtVerticalScrollExample" class="table table-striped table-bordered table-sm" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th class="th-sm"></th>
                        <th class="th-sm">Код на продукта</th>
                        <th class="th-sm">Име на продукта</th>
                        <th class="th-sm">Един. цена</th>
                        <th class="th-sm">Управление</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subproducts as $subitem)
                    @php
                    $subproduct = Product::where(['code' => $subitem->subproducts_code])->first();
                    if (empty($subproduct)){
                        break;
                    }
                    $shirina_q = 70;
                    $dalzina_q = 1000;
                    $visocina_q = 1000;
                    $quantity = "";
                    switch ($subproduct->typeprice) {
                    case '0':
                    $shirina_q = 0;
                    $dalzina_q = 0;
                    $visocina_q = 0;
                    break;
                    case 'm2':
                    $shirina_q = 0;
                    $dalzina_q = 0;
                    $visocina_q = 0;
                    break;
                    case 'lm':
                    $shirina_q = 0;
                    $dalzina_q = 0;
                    $visocina_q = 0;
                    break;
                    case 'kg':
                    $shirina_q = 0;
                    $dalzina_q = 0;
                    $visocina_q = 0;
                    break;
                    case 'l':
                    $shirina_q = 0;
                    $dalzina_q = 0;
                    $visocina_q = 0;
                    break;
                    case 'komplekt':
                    $shirina_q = 0;
                    $dalzina_q = 0;
                    $visocina_q = 0;
                    break;
                    case 'br':
                    $shirina_q = 0;
                    $dalzina_q = 0;
                    $visocina_q = 0;
                    break;
                    case 'h':
                    $shirina_q = 0;
                    $dalzina_q = 0;
                    $visocina_q = 0;
                    break;
                    case 'km':
                    $shirina_q = 0;
                    $dalzina_q = 0;
                    $visocina_q = 0;
		            break;
                    case 'f':
                    $quantity = "disabled";
                    break;
                    case 't':
                    $shirina_q = 0;
                    $quantity = "disabled";
                    break;
                    default:
                    $shirina_q = 0;
                    $dalzina_q = 0;
                    $visocina_q = 0;
                    }

                    //send json data
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($ch, CURLOPT_URL, env('APP_SITE') . '/api/getprice.php');
                    curl_setopt($ch, CURLOPT_POST, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, "code=6jqnh5qx24y4ibic&productcode=" . $subproduct->code .
                    "&h=" . $visocina_q . "&l=" . $dalzina_q . "&p=" . $shirina_q);
                    $response_body = curl_exec($ch);
                    curl_close($ch);
                    //with or without dds
                    if ($settings[0]->dds == 'Yes'){
                        $real_price = floatval(json_decode($response_body)->new_price) * ( 1.00 + floatval($settings[0]->ddspurcent) / 100);
                        $dds_text = '(цена с ДДС)';
                    }else{
                        $real_price = floatval(json_decode($response_body)->new_price);
                        $dds_text = '(цена без ДДС)';
                    }
                    $real_kg = floatval(json_decode($response_body)->new_kg);
                    @endphp
                    <tr>
                        <td><a href="/product?pid={{ $subproduct->code }}" title="{{ $subproduct->name }}"><img
                                    style="max-width:60px;"
                                    src="{{ env('APP_SITE') }}/dist/img/products/product_{{ substr($subproduct->code, -4) }}.jpg"
                                    onerror="this.src='{{ env('APP_SITE') }}/dist/img/products/product_.jpg'"></a></td>
                        <td><a href="/product?pid={{ $subproduct->code }}"
                                title="{{ $subproduct->name }}">{{ $subproduct->code }}</a></td>
                        <td><a href="/product?pid={{ $subproduct->code }}"
                                title="{{ $subproduct->name }}">{{ $subproduct->name }}</a></td>
                        <td>{{ number_format($real_price, 2, ".", "") }}&nbsp;{{ $properties[0]->currency }}&nbsp;{{ $dds_text }}</td>
                        <td><button class="btn btn-primary text-uppercase"
                            onclick="buyOption('{{ number_format($real_price, 2, '.', '') }}', '{{ $subproduct->name }}', '{{ $subproduct->typeprice }}', '{{ $subproduct->description }}', '{{ $properties[0]->currency }}', '{{ $subproduct->code }}', '{{ $visocina_q }}', '{{ $dalzina_q }}', '{{ $shirina_q }}', '{{ $real_kg }}', '{{ $subproduct->firm_id }}');"
                            > КУПИ </button></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
        <hr />
    </div>
</div>
<!-- tab block -->