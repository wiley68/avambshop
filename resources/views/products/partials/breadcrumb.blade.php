<nav aria-label="breadcrumb">
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="/">Начало</a></li>
		@if(Request::is('products'))
			<li class="breadcrumb-item active" aria-current="page">Продукти</li>
		@endif
		@if(Route::is('products.by_firm'))
			<li class="breadcrumb-item"><a href="/products">Продукти</a></li>
			<li class="breadcrumb-item active" aria-current="page">{{ $firm->firm }}</li>
		@endif
		@if(Route::is('products.by_category'))
			<li class="breadcrumb-item"><a href="/products">Продукти</a></li>
			<li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
		@endif
		@if(Request::is('products/search'))
			<li class="breadcrumb-item"><a href="/products">Продукти</a></li>
			<li class="breadcrumb-item active" aria-current="page">Търсена дума: {{ $termin }}</li>
		@endif
	</ol>
</nav>