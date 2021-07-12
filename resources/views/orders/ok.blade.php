<?php use App\Http\Controllers\WebpaymentsController; ?>
<?php use App\Http\Controllers\WebdeliveriesController; ?>
<?php use App\Http\Controllers\FirmsController; ?>
<?php use App\Weborder; ?>
<?php use App\Subweborder; ?>
<?php use App\Http\Controllers\ProductsController; ?>
<?php use App\Http\Controllers\PropertiesController; ?>
<?php $properties = PropertiesController::getAllProperties(); ?>
<?php use App\Http\Controllers\WebsettingsController; ?>

<?php $settings = WebsettingsController::getAllSettings(); ?>
@php
if ($settings[0]->dds == 'Yes') {
    $dds_text = '(цена с ДДС)';
} else {
    $dds_text = '(цена без ДДС)';
}
@endphp
@extends('layouts/app')

@section('content')
    @if (isset($orders))
        @php
            $orders_arr = explode('_', $orders);
        @endphp
        <h1><em>Получена поръчка</em></h1>
        <hr />
        <p>Благодарности. Вашата поръчка беше получена.</p>
        @foreach ($orders_arr as $order_id)
            @php
                $order = Weborder::where('id', $order_id)->first();
            @endphp
            <div id="print_div_{{ $order->id }}">
                <div class="row">
                    <div class="col-md-2" style="border-right: 1px dashed #DCDCDC;">
                        <div class="small text-muted"><strong>НОМЕР НА ПОРЪЧКАТА:</strong></div>
                        <div>{{ $order->id }}</div>
                    </div>
                    <div class="col-md-2" style="border-right: 1px dashed #DCDCDC;">
                        <div class="small text-muted"><strong>ДАТА:</strong></div>
                        <div><?php echo date('d.m.Y H:i:s'); ?></div>
                    </div>
                    <div class="col-md-2" style="border-right: 1px dashed #DCDCDC;">
                        <div class="small text-muted"><strong>ОБЩО {{ $dds_text }}:</strong></div>
                        <div>{{ number_format($order->allprice, 2, '.', '') }}</div>
                    </div>
                    <div class="col-md-3">
                        <div class="small text-muted"><strong>НАЧИН НА ПЛАЩАНЕ:</strong></div>
                        <div>{{ WebpaymentsController::getPaymentsById($order->payment)[0]->name }}</div>
                        @if (WebpaymentsController::getPaymentsById($order->payment)[0]->isbank == 'Yes')
                            <div>{{ FirmsController::getFirmById($order->firm_id)[0]->firm }}</div>
                            <div class="small text-muted">БАНКА:
                                {{ WebpaymentsController::getPaymentsById($order->payment)[0]->bank_name }}</div>
                            <div class="small text-muted">IBAN:
                                {{ WebpaymentsController::getPaymentsById($order->payment)[0]->iban }}</div>
                            <div class="small text-muted">BIC:
                                {{ WebpaymentsController::getPaymentsById($order->payment)[0]->bic }}</div>
                        @endif
                    </div>
                    <div class="col-md-3">
                        <div class="small text-muted"><strong>НАЧИН НА ДОСТАВКА:</strong></div>
                        <div>{{ WebdeliveriesController::getDeliveriesById($order->delivery)[0]->name }}</div>
                    </div>
                </div>
                <div style="padding-bottom:30px;"></div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card bg-default mb-3">
                            <div class="card-header">Вашата поръчка от фирма:
                                {{ FirmsController::getFirmById($order->firm_id)[0]->firm }}&nbsp;(<a target="_blank"
                                    href="{{ route('order.print', ['id' => $order->id]) }}">Принтирай
                                    поръчката</a>)</div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-8"><strong>Продукт</strong></div>
                                        <div class="col-md-1"><strong>Общо</strong></div>
                                        <div class="col-md-3"><strong>Снимка</strong></div>
                                    </div>
                                </li>
                                <?php
                                $total_price = 0;
                                $suborders = Subweborder::where('order_id', $order->id)->get();
                                ?>
                                @foreach ($suborders as $suborder)
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <p class="head">
                                                    {{ ProductsController::getProductById($suborder->product_code)->name }}
                                                    x {{ $suborder->quantity }}</p>
                                                @if ((!empty($suborder->h) && $suborder->h != '0') || (!empty($suborder->l) && $suborder->l != '0') || (!empty($suborder->p) && $suborder->p != '0'))
                                                    <p class="subhead">
                                                        @if (!empty($suborder->h) && $suborder->h != '0')
                                                            Височина: {{ $suborder->h }} mm&nbsp;&nbsp;
                                                        @endif
                                                        @if (!empty($suborder->l) && $suborder->l != '0')
                                                            Ширина: {{ $suborder->l }} mm&nbsp;&nbsp;
                                                        @endif
                                                        @if (!empty($suborder->p) && $suborder->p != '0')
                                                            Дълбочина: {{ $suborder->p }} mm
                                                        @endif
                                                    </p>
                                                @endif
                                                {!! html_entity_decode(ProductsController::getProductById($suborder->product_code)->description) !!}
                                            </div>
                                            <div class="col-md-1">{{ number_format($suborder->price, 2, '.', '') }}
                                                {{ $properties[0]->currency }}</div>
                                            <div class="col-md-3">
                                                <img src="{{ env('APP_SITE') }}/dist/img/products/product_{{ substr($suborder->product_code, -4) }}.jpg"
                                                    class="img-thumbnail" alt="{{ $suborder->product_code }}"
                                                    onerror="this.src='{{ env('APP_SITE') }}/dist/img/products/product_.jpg'" />
                                            </div>
                                        </div>
                                    </li>
                                    <?php $total_price += floatval($suborder->price); ?>
                                @endforeach
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-6"><strong>Начин на плащане</strong></strong></div>
                                        <div class="col-md-6">
                                            {{ WebpaymentsController::getPaymentsById($order->payment)[0]->name }}
                                            @if ($order->status == 'platena' && WebpaymentsController::getPaymentsById($order->payment)[0]->isbank == 'Card')
                                                (Поръчката е платена с PayPal ID: {{ $order->paypal_id }})
                                            @endif
                                        </div>
                                    </div>
                                </li>
                                @php
                                    $price_eur = number_format(floatval($total_price + $order->price_delivery) / 1.95583, 2, '.', '');
                                    $paypal_status = WebpaymentsController::getPaymentsById($order->payment)[0]->paypal_status;
                                    if ($paypal_status == 0) {
                                        $paypal_client_id = WebpaymentsController::getPaymentsById($order->payment)[0]->sandbox_client_id;
                                    } else {
                                        $paypal_client_id = WebpaymentsController::getPaymentsById($order->payment)[0]->paypal_client_id;
                                    }
                                @endphp
                                @if ($order->status == 'obrabotka' && WebpaymentsController::getPaymentsById($order->payment)[0]->isbank == 'Card' && $paypal_client_id != '')
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-md-6"><strong>Можете да платите с Кредитна
                                                    карта</strong></strong>
                                            </div>
                                            <div class="col-md-6">
                                                <form class="form-inline my-2 my-lg-0" enctype="multipart/form-data"
                                                    action="{{ route('user-order') }}" method="post" name="user_order"
                                                    id="user_order" novalidate>
                                                    {{ csrf_field() }}
                                                    <input name="id" id="id" type="hidden" value="{{ $order->id }}">
                                                    <button class="btn btn-primary text-uppercase" type="submit">Към плащане
                                                        с Кредитна карта&nbsp;&raquo;</button>
                                                </form>
                                            </div>
                                        </div>
                                    </li>
                                @endif
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-6"><strong>Начин на доставка</strong></strong></div>
                                        <div class="col-md-6">
                                            {{ WebdeliveriesController::getDeliveriesById($order->delivery)[0]->name }}&nbsp;(Доставка
                                            +{{ number_format($order['price_delivery'], 2, '.', '') }}&nbsp;{{ $properties[0]->currency }})
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-md-6"><strong>Обща {{ $dds_text }}</strong></div>
                                        <div class="col-md-6">
                                            <strong>{{ number_format($total_price + $order->price_delivery, 2, '.', '') }}
                                                {{ $properties[0]->currency }}</strong>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
                <hr />
                <div style="padding-bottom:30px;"></div>
            </div>
        @endforeach
        <h3>Ще се свържем с Вас за потвърждение на поръчката.</h3>
    @endif
@endsection
