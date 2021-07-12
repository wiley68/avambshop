<?php use App\Firm; ?>
<?php use App\Http\Controllers\WebpaymentsController; ?>

@extends('layouts/app')

@section('content')

@guest
{{!! redirect()->route('login'); !!}}
@else
<h1>Моите поръчки</h1>
<hr />
<table id="dtVerticalScrollExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
    <thead>
        <tr>
            <th class="th-sm">№
            </th>
            <th class="th-sm">Дата
            </th>
            <th class="th-sm">Към фирма
            </th>
            <th class="th-sm">Обща цена ({{ $properties->currency }})
            </th>
            <th class="th-sm">Състояние
            </th>
            <th class="th-sm">Управление
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr>
            <td>{{ $order->id }}</td>
            @php
                $newDate = date("d.m.Y", strtotime($order->dateon));
            @endphp
            <td>{{ $newDate }}</td>
            <td>{{ Firm::where(['id' => $order->firm_id])->first()->firm }}</td>
            <td>{{ $order->allprice }}</td>
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
            <td>
                {{ $status }}
                @if ($order->status == 'platena' && WebpaymentsController::getPaymentsById($order->payment)[0]->isbank == 'Card')
                    (PayPal ID: {{ $order->paypal_id }})
                @endif
            </td>
            <td class="column-verticallineMiddle form-inline" style="vertical-align:middle;">
                <form class="form-inline my-2 my-lg-0" enctype="multipart/form-data"
                    action="{{ route('user-order') }}" method="post" name="user_order" id="user_order" novalidate>
                    {{ csrf_field() }}
                    <input name="id" id="id" type="hidden" value="{{ $order->id }}">
                    <button class="btn btn-sm btn-primary text-uppercase" type="submit">Преглед</button>
                </form>&nbsp;
                <form class="form-inline my-2 my-lg-0" enctype="multipart/form-data"
                    action="{{ route('delete-order') }}" method="post" name="delete-order" id="delete-order" novalidate>
                    {{ csrf_field() }}
                    <input name="id" id="id" type="hidden" value="{{ $order->id }}">
                    <button class="btn btn-sm btn-danger text-uppercase" type="submit">Изтриване</button>
                </form>
            </td>
        </tr>                
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th>№
            </th>
            <th>Дата
            </th>
            <th>Към фирма
            </th>
            <th>Обща цена ({{ $properties->currency }})
            </th>
            <th>Състояние
            </th>
            <th>Управление
            </th>
        </tr>
    </tfoot>
</table>
@endguest

@endsection