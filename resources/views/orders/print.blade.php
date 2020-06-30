<?php use App\Product;?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
 <title></title>
</head>
<body>
    <div>
        <div style="width: 100%;text-align:center;">
            <h1>
                Поръчка № {{ $order->id }}<br />
                към фирма:<br />
                {{ $firm->firm }}
            </h1>
        </div>
        <br/><br/>
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%;text-align: left;">
                    Дата: <strong>{{ $order->created_at->format('Y.m.d - H:i:s') }}</strong>
                </td>
                <td style="width: 50%;text-align: right;">
                    Общо (цена с ДДС): <strong>{{ $order->allprice }} лв.</strong>
                </td>
            </tr>
        </table>
        <br/><br/>
        <table style="width: 100%;">
            <tr>
                <td style="width: 70%;text-align: left;padding: 10px;">
                    Продукт
                </td>
                <td style="width: 10%;text-align: left;padding: 10px;">
                    Общо
                </td>
                <td style="width: 20%;text-align: center;padding: 10px;">
                    Снимка
                </td>
            </tr>
            @foreach ($suborders as $suborder)
            @php
                $product = Product::where(['code' => $suborder->product_code])->firstOrFail();
                $product_me = $product->typeprice;
                switch ($product_me) {
		            case '0':
		                $product_me_txt = "";
            		break;
		            case 'm2':
		                $product_me_txt = 'квадратен метър';
            		break;
		            case 'lm':
		                $product_me_txt = 'линеен метър';
            		break;
		            case 'kg':
		                $product_me_txt = 'килограм';
            		break;
		            case 'l':
		                $product_me_txt = 'литър';
            		break;
		            case 'komplekt':
		                $product_me_txt = 'комплект';
            		break;
		            case 'br':
		                $product_me_txt = 'брой';
            		break;
		            case 'h':
		                $product_me_txt = 'час';
                	break;
		            case 'km':
		                $product_me_txt = 'километър';
            		break;
		            case 'f':
		                $product_me_txt = 'конфигурация';
                        $pos_h = strpos(strtolower($product->formula), 'h');
                        if ($pos_h !== false){
                            $visocina = "Височина: " . $suborder->h . " mm ";
                        }else{
                            $visocina = "";
                        }
                        $pos_l = strpos(strtolower($product->formula), 'l');
                        if ($pos_l !== false){
                            $shirina = "Ширина: " . $suborder->l . " mm ";
                        }else{
                            $shirina = "";
                        }
                        $pos_p = strpos(strtolower($product->formula), 'p');
                        if ($pos_p !== false){
                            $dalbocina = "Дълбочина: " . $suborder->p . " mm";
                        }else{
                            $dalbocina = "";
                        }
            		break;
            		case 't':
		                $product_me_txt = 'конфигурация';
            		break;
		            default:
		                $product_me_txt = 'брой';
            		break;
	            }
            @endphp
            <tr>
                <td style="padding: 10px;width: 60%;vertical-align: top;text-align: left;border-left:1px solid silver;border-top:1px solid silver;border-bottom:1px solid silver;">
                    <span style="font-weight: bold;text-decoration: underline;">{{ $product->name }}</span><br /><br />
                    {{ $product_me_txt }}&nbsp;{{ $suborder->quantity }}<br /><br />
                    {{ $visocina }}{{  $shirina }}{{ $dalbocina }}<br /><br />
                    {{ $product->description }}
                </td>
                <td style="padding: 10px;width: 10%;vertical-align: top;text-align: left;border-left:1px solid silver;border-top:1px solid silver;border-bottom:1px solid silver;">
                    {{ $suborder->price }}&nbsp;лв.
                </td>
                <td style="padding: 10px;width: 30%;vertical-align: top;text-align: center;
                    border-left:1px solid silver;border-top:1px solid silver;
                    border-bottom:1px solid silver;border-right:1px solid silver;">
                    <img style="max-width: 200px;" src="{{ env('APP_SITE') }}/dist/img/products/product_{{ substr($product->code, -4) }}.jpg" />
                </td>
            </tr>                
            @endforeach
            <tr>
                <td style="padding: 10px;width: 60%;">
                </td>
                <td colspan="2" style="padding: 10px;width: 40%;">
                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width: 60%;vertical-align: top;text-align: left;border-left:1px solid silver;border-top:1px solid silver;border-bottom:1px solid silver;">
                    <span style="font-weight: bold;">Обща (цена с ДДС)</span>
                </td>
                <td colspan="2" style="padding: 10px;width: 40%;vertical-align: top;text-align: left;border-bottom:1px solid silver;border-top:1px solid silver;border-right:1px solid silver;">
                    <strong>{{ $order->allprice }} лв.</strong>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width: 60%;">
                </td>
                <td colspan="2" style="padding: 10px;width: 40%;">
                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width: 40%;vertical-align: top;text-align: left;border-left:1px solid silver;border-top:1px solid silver;border-bottom:1px solid silver;">
                    <span style="font-weight: bold;">Допълнителна информация:</span>
                </td>
                <td colspan="2" style="padding: 10px;width: 60%;vertical-align: top;text-align: left;border-bottom:1px solid silver;border-top:1px solid silver;border-right:1px solid silver;">
                    {!! $order->description !!}
                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width: 60%;">
                </td>
                <td colspan="2" style="padding: 10px;width: 40%;">
                </td>
            </tr>
            <tr>
                <td style="padding: 10px;width: 50%;">
                    <span style="font-weight: bold;">Начин на плащане</span><br /><br />
                    {{ $payment->name }}<br /><br />
                    @if ($payment->isbank == "Yes")
                    БАНКА:&nbsp;{{ $payment->bank_name }}<br /> 
                    IBAN:&nbsp;{{ $payment->iban }}<br />
                    BIC:&nbsp;{{ $payment->bic }} 
                    @endif
                </td>
                <td colspan="2" style="padding: 10px;width: 50%;text-align: right;">
                    <span style="font-weight: bold;">Начин на доставка</span><br /><br />
                    {{ $delivery->name }}
                </td>
            </tr>
        </table>
        <br /><br />
        <div style="width: 100%;text-align:center;">
            <h3>Ще се свържем с Вас за потвърждение на поръчката.</h3>
        </div>
    </div>
</body>
</body>
</html>