<?php use App\Firm; ?>
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
            <td>{{ $status }}</td>
            <td><a title="Можете да прегледате подробни данни за поръчката." href="{{ route('user-order', ['id' => $order->id]) }}">Преглед</a>&nbsp;|&nbsp;<a title="Можете да изтриете тази поръчка." href="{{ route('delete-order', ['id' => $order->id]) }}">Изтриване</a></td>
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