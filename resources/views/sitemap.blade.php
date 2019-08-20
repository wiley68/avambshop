<?php use App\Http\Controllers\WebpagesController;?>
<?php $sitemap = WebpagesController::getSitemapPage();?> 
@extends('layouts/app')

@section('content')
	<h1>{{ $sitemap->name }}</h1>
	<p>{!! html_entity_decode($sitemap->text) !!}</p>
	<hr />
	<p><a href="/" title="Начална страница">Начална страница</a></p>
	<p><a href="/about" title="Страница с информация за нас">За нас</a></p>
	<p><a href="/contact" title="Страница с информация за контакт">За контакт</a></p>
	<p><a href="/sitemap" title="Страница с карта на сайта">Карта на сайта</a></p>
	<p><a href="/profile" title="Страница с информация за профила на купувача">Профил</a></p>
	<p><a href="/terms" title="Страница с информация за Общи условия">Общи условия</a></p>
	<p><a href="/politika" title="Страница с информация за Политика на поверителност">Политика на поверителност</a></p>
	<p><a href="/dostavka" title="Страница с информация за Доставка и плащане">Доставка и плащане</a></p>
	<p><a href="/vrashtane" title="Страница с информация за Връщане на продукт">Връщане на продукт</a></p>
	<p><a href="/products" title="Страница с информация за Всички продукти">Всички продукти</a></p>
	<p><a href="/firms" title="Страница с Фирми включени в каталога">Фирми включени в каталога</a></p>
	<p><a href="/cart" title="Страница с Кошницата">Кошница</a></p>
	<p><a href="/order" title="Страница с Поръчка">Поръчка</a></p>
@endsection