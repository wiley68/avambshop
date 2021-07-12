<?php use App\Webpayment; ?>
<?php use App\Webdeliverie; ?>
<?php use App\Subweborder; ?>
<?php use App\Subdeliverie; ?>
<?php use App\Product; ?>
<?php use App\Http\Controllers\WebsettingsController; ?>
<?php $settings = WebsettingsController::getAllSettings(); ?>
@extends('layouts/app')

@section('content')

    @if (Auth::guest() && $order->user_id)
        <script>
            window.location = "/login";
        </script>
    @else
        <div id="print_div">
            <h1>Оферта №: {{ $order->id }}&nbsp;от фирма {{ $firm->firm }}</h1>
            <hr />
            <div class="card">
                <div class="card-header">
                    Основна информация
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-hover table-sm">
                        <tbody>
                            <tr>
                                <td>Дата и час</td>
                                @php
                                    $newDate = date('d.m.Y H:s:i', strtotime($order->dateon));
                                @endphp
                                <td>{{ $newDate }}</td>
                            </tr>
                            <tr>
                                <td>Статус</td>
                                @php
                                    switch ($order->status) {
                                        case 'obrabotka':
                                            $status = 'Обработка';
                                            break;
                                        case 'otkazana':
                                            $status = 'Отказана';
                                            break;
                                        case 'vyrnata':
                                            $status = 'Върната';
                                            break;
                                        case 'prikluchena':
                                            $status = 'Приключена';
                                            break;
                                        case 'platena':
                                            $status = 'Платена';
                                            break;
                                        default:
                                            $status = 'Обработка';
                                            break;
                                    }
                                @endphp
                                <td>{{ $status }}</td>
                            </tr>
                            <tr>
                                <td>Начин на плащане</td>
                                @php
                                    $payment = Webpayment::where(['id' => $order->payment])->first();
                                @endphp
                                <td>
                                    {{ $payment->name }}
                                    @if ($order->status == 'platena' && $payment->isbank == 'Card')
                                        (Поръчката е платена с PayPal ID: {{ $order->paypal_id }})
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td>Начин на доставка</td>
                                @php
                                    $delivery = Webdeliverie::where(['id' => $order->delivery])->first();
                                    $subweborders = Subweborder::where(['order_id' => $order->id])->get();
                                    $allkg = 0;
                                    foreach ($subweborders as $subweborder) {
                                        $allkg += floatval($subweborder->quantity) * floatval($subweborder->kg);
                                    }
                                    $deliveryprice = 0;
                                    $subdelivery = Subdeliverie::where(['delivery_id' => $order->delivery])
                                        ->where('fromkg', '<=', $allkg)
                                        ->where('tokg', '>', $allkg)
                                        ->first();
                                    if (!empty($subdelivery)) {
                                        $deliveryprice = $subdelivery->price;
                                    }
                                @endphp
                                <td>{{ $delivery->name }}&nbsp;+({{ $deliveryprice }}&nbsp;{{ $properties->currency }})
                                </td>
                            </tr>
                            <tr>
                                <td>Описание</td>
                                <td>{!! $order->description !!}</td>
                            </tr>
                            <tr>
                                <td>Крайна цена</td>
                                @php
                                    if ($settings[0]->dds == 'Yes') {
                                        $dds_text = '(цена с ДДС)';
                                    } else {
                                        $dds_text = '(цена без ДДС)';
                                    }
                                @endphp
                                <td>{{ number_format($order->allprice + $deliveryprice, 2, '.', '') }}&nbsp;{{ $properties->currency }}&nbsp;<strong>{{ $dds_text }}</strong>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <hr />
            <h5>Поръчани артикули</h5>
            <table id="dtVerticalScrollExample" class="table table-striped table-bordered table-sm" cellspacing="0"
                width="100%">
                <thead>
                    <tr>
                        <th class="th-sm">Продуктов код</th>
                        <th class="th-sm">Продукт</th>
                        <th class="th-sm">Кол.</th>
                        <th class="th-sm">Ед. цена</th>
                        <th class="th-sm">Крайна цена</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($subweborders as $suborder)
                        <tr>
                            @php
                                $product = Product::where(['code' => $suborder->product_code])->first();
                            @endphp
                            <td><a href="/product?pid={{ $product->code }}">{{ $suborder->product_code }}</a></td>
                            <td><a href="/product?pid={{ $product->code }}">{{ $product->name }}</a></td>
                            <td>{{ $suborder->quantity }}</td>
                            <td>{{ number_format($suborder->price / $suborder->quantity, 2, '.', '') }}&nbsp;{{ $properties->currency }}
                            </td>
                            <td>{{ number_format($suborder->price, 2, '.', '') }}&nbsp;{{ $properties->currency }}
                            </td>
                        </tr>
                        <tr>
                            <td>Описание</td>
                            <td colspan="4">{!! $product->description !!}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <hr />
            Крайна цена
            {{ number_format($order->allprice + $deliveryprice, 2, '.', '') }}&nbsp;{{ $properties->currency }}&nbsp;<strong>{{ $dds_text }}</strong>
        </div>
        @php
            $price_eur = number_format(floatval($order->allprice + $deliveryprice) / 1.95583, 2, '.', '');
            $paypal_status = $payment->paypal_status;
            if ($paypal_status == 0) {
                $paypal_client_id = $payment->sandbox_client_id;
            } else {
                $paypal_client_id = $payment->paypal_client_id;
            }
        @endphp
        <hr />
        <div class="d-flex justify-content-start">
            <a href="/orders" class="btn btn-info h-100 d-inline-block mr-2">Обратно в моите поръчки</a>
            <a target="_blank" href="{{ route('order.print', ['id' => $order->id]) }}"
                class="btn btn-info h-100 d-inline-block mr-2">Принтирай</a>
            @if ($order->status == 'obrabotka' && $payment->isbank == 'Card' && $paypal_client_id != '')
                <script src="https://www.paypal.com/sdk/js?client-id={{ $paypal_client_id }}&currency=EUR&locale=bg_BG"
                                data-order-id="{{ $order->id }}" data-page-type="cart">
                </script>

                <div id="paypal-button-container" class="flex-fill"></div>

                <!-- Add the checkout buttons, set up the order and approve the order -->
                <script>
                    paypal.Buttons({
                        style: {
                            color: 'blue',
                            shape: 'rect',
                            label: 'pay',
                            height: 36
                        },
                        createOrder: function(data, actions) {
                            return actions.order.create({
                                purchase_units: [{
                                    reference_id: "{{ $order->id }}",
                                    amount: {
                                        currency_code: "EUR",
                                        value: '{{ $price_eur }}'
                                    }
                                }]
                            });
                        },
                        onApprove: function(data, actions) {
                            return actions.order.capture().then(function(details) {
                                if (details.purchase_units[0].payments.captures[0].id != null) {
                                    paypal_id = details.purchase_units[0].payments.captures[0].id;
                                } else {
                                    paypal_id = "";
                                }
                                alert("Успешно платихте Вашата поръчка с номер: {{ $order->id }}. Номер на транзакция в PayPal: " +
                                    paypal_id);
                                $.ajax({
                                    type: 'GET',
                                    url: '/pay-order/{{ $order->id }}/' + paypal_id,
                                    success: function(data) {
                                        if (data.result == 'success') {
                                            window.location =
                                                '{{ redirect()->getUrlGenerator()->previous() }}';
                                        } else {
                                            window.location.reload();
                                        }
                                    }
                                });
                            });
                        }
                    }).render('#paypal-button-container');
                </script>
            @endif
        </div>
    @endguest

@endsection
