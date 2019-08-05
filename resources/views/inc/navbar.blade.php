<?php use App\Http\Controllers\FirmsController;?>
<?php use App\Http\Controllers\CategoriesProductsController;?>
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-dark">
	<div class="container">
		<a class="navbar-brand" href="/">AVAMB Shop</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item {{ Request::is('/') ? 'active' : '' }}"><a class="nav-link" href="/">Начало <span class="sr-only">(current)</span></a></li>
				<li class="nav-item dropdown {{ Request::is('products/by_category') ? 'active' : '' }}">
					<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Категории <span class="caret"></span></a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item {{ (Request::is('products/by_category')) ? 'active' : '' }}" href="/products">Всички продукти</a>
                        @if(count(CategoriesProductsController::getCategories()) > 0)
							@foreach(CategoriesProductsController::getCategories() as $category)
								<a class="dropdown-item {{ (Request::is('products/by_category') AND (request()->get('category_id') == $category->id)) ? 'active' : '' }}" href="{{ route('products.by_category', ['id' => $category->id]) }}">{{ $category->name }}</a>
							@endforeach
						@endif
					</div>
				</li>
				<li class="nav-item dropdown {{ Request::is('products/by_firm') ? 'active' : '' }}">
					<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Производители <span class="caret"></span></a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						@if(count(FirmsController::getFirms()) > 0)
							@foreach(FirmsController::getFirms() as $firm)
								<a class="dropdown-item {{ (Request::is('products/by_firm') AND (request()->get('firm_id') == $firm->id)) ? 'active' : '' }}" href="{{ route('products.by_firm', ['id' => $firm->id]) }}">{{ $firm->firm }}</a>
							@endforeach
						@endif
					</div>
				</li>
			</ul>
			<form class="form-inline my-2 my-lg-0" enctype="multipart/form-data" action="{{ route('products.search') }}" method="post" name="search_products" id="search_products" novalidate>	
				{{ csrf_field() }}	
				<input class="form-control mr-sm-2" name="termin" type="search" placeholder="Въведете търсения израз" aria-label="Search">
				<button class="btn btn-outline-success my-2 my-sm-0" type="submit">Търси</button>
			</form>
			<ul class="navbar-nav ml-auto">
				<!-- Authentication Links -->
				@guest
				<li class="nav-item {{ Request::is('login') ? 'active' : '' }}"><a class="nav-link" href="{{ route('login') }}">Вход</a></li>
				<li class="nav-item {{ Request::is('register') ? 'active' : '' }}"><a class="nav-link" href="{{ route('register') }}">Регистрация</a></li>
				@else
				<li class="nav-item dropdown">
					<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
						{{ Auth::user()->name }} <span class="caret"></span>
					</a>
					
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item {{ (Request::is('profile')) ? 'active' : '' }}" href="/profile">Моят профил</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
							Изход
						</a>
						
						<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
							{{ csrf_field() }}
						</form>
					</div>
				</li>
				@endguest
				<li class="nav-item dropdown {{ (Request::is('about') OR Request::is('contact') OR Request::is('sitemap') OR Request::is('terms') OR Request::is('politika') OR Request::is('dostavka') OR Request::is('vrashtane')) ? 'active' : '' }}">
					<a href="/" class="nav-link dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Информация <span class="caret"></span></a>
					<div class="dropdown-menu" aria-labelledby="navbarDropdown">
						<a class="dropdown-item {{ Request::is('about') ? 'active' : '' }}" href="/about">За нас</a>
						<a class="dropdown-item {{ Request::is('contact') ? 'active' : '' }}" href="/contact">За контакт</a>
						<a class="dropdown-item {{ Request::is('sitemap') ? 'active' : '' }}" href="/sitemap">Карта на сайта</a>
						<div class="dropdown-divider"></div>
						<a class="dropdown-item {{ Request::is('terms') ? 'active' : '' }}" href="/terms">Общи условия</a>
						<a class="dropdown-item {{ Request::is('politika') ? 'active' : '' }}" href="/politika">Политика на поверителност</a>
						<a class="dropdown-item {{ Request::is('dostavka') ? 'active' : '' }}" href="/dostavka">Доставка и плащане</a>
						<a class="dropdown-item {{ Request::is('vrashtane') ? 'active' : '' }}" href="/vrashtane">Връщане на продукт</a>
					</div>
				</li>
			</ul>
		</div>
	</div>
</nav>

<!-- Cart -->
@if(Session::has('cart_session'))
	<?php 
		$count_items = 0;
		$sess = Session::get('cart_session');
		if (isset($sess['firms'])){
			foreach ($sess['firms'] as $firm){
				$count_items += sizeof($firm['items']);
			}
		}
	?>
@if (($count_items > 0) AND (!Request::is('cart')) AND (!Request::is('order')) AND (!Request::is('order/submit')))
<div id="cart_mini" class="tbi_float" onclick="location.href='/cart'">
	<table cellspacing="0" cellpadding="0" width="100%" border="0">
		<tr>
			<td style="width:50%;"><img src="/img/cart.png" class="tbi-my-float"></td>
			<td style="text-align:center;"><span id="count_cart_items" class="tbi-text-float">{{$count_items}}</span></td>
		</tr>
	</table>
</div>
@endif
@endif
