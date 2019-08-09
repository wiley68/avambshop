<?php use App\Webpayment; ?>
<?php use App\Webdeliverie; ?>
<?php use App\Subweborder; ?>
<?php use App\Subdeliverie; ?>
<?php use App\Product; ?>
@extends('layouts/app')

@section('content')

@guest
{{!! redirect()->route('login'); !!}}
@else
<div id="print_div">
<h1>Поръчка №: {{ $order->id }}</h1>
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
                    $newDate = date("d.m.Y H:s:i", strtotime($order->dateon));
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
                    <td>{{ $payment->name }}</td>
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
                    $subdelivery = Subdeliverie::where(['delivery_id' => $order->delivery])->where('fromkg', '<=',
                        $allkg)->where('tokg', '>', $allkg)->first();
                        if (!empty($subdelivery)){
                        $deliveryprice = $subdelivery->price;
                        }
                        @endphp
                        <td>{{ $delivery->name }}&nbsp;+({{ $deliveryprice }}&nbsp;{{ $properties->currency }})</td>
                </tr>
                <td>Дата и час</td>
                @php
                $newDate = date("d.m.Y H:s:i", strtotime($order->dateon));
                @endphp
                <td>{{ $newDate }}</td>
                </tr>
                <tr>
                    <td>Описание</td>
                    <td>{!! $order->description !!}</td>
                </tr>
                <tr>
                    <td>Крайна цена</td>
                    <td>{{ number_format($order->allprice + $deliveryprice, 2, ".", "") }}&nbsp;{{ $properties->currency }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<hr />
<h5>Поръчани артикули</h5>
<table id="dtVerticalScrollExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
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
            <td>{{ number_format($suborder->price / $suborder->quantity, 2, ".", "") }}&nbsp;{{ $properties->currency }}</td>
            <td>{{ number_format($suborder->price, 2, ".", "") }}&nbsp;{{ $properties->currency }}</td>
        </tr>                
        <tr>
            <td>Описание</td>
            <td colspan="4">{!! $product->description !!}</td>
        </tr>                
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th class="th-sm">Продуктов код</th>
            <th class="th-sm">Продукт</th>
            <th class="th-sm">Кол.</th>
            <th class="th-sm">Ед. цена</th>
            <th class="th-sm">Крайна цена</th>
        </tr>
    </tfoot>
</table>
</div>
<hr />
<a href="/orders" class="btn btn-info">Обратно в моите поръчки</a>
<button id="print_order" class="btn btn-info">Принтирай</button>
@endguest

@endsection

@section('scripts')
<script>
function PrintElem(elem)
{
    var mywindow = window.open('', 'PRINT');

    mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}
$("#print_order").click(function(e){
    PrintElem('print_div');
});
</script>
@stop