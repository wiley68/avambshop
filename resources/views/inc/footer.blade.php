<?php use App\Http\Controllers\FirmsController;?>
<?php use App\Http\Controllers\WebfootersController;?>
<?php $footer = WebfootersController::getWebfooter(); ?>
<footer id="footer">
	<div class="container">
		<div class="row">
			<div class="col-sm">
				<a href="/"><h2 class="text-center;">{{ $footer->name }}</h2></a><br />
				<p>{!! html_entity_decode($footer->text) !!}</p>
			</div>
			<div class="col-sm">
				<div class="card text-white mb-3" style="max-width: 18rem;background-color:#00b3ff;">
					<h4 class="card-header"><a href="/firms" title="Покажи всички фирми в каталога.">Търговци</a></h4>
					<div class="card-body">
						@if(count(FirmsController::getFirmRandom(4)) > 0)
							@foreach(FirmsController::getFirmRandom(4) as $firm)
								<a href="{{ route('products.by_firm', ['id' => $firm->id]) }}">{{ $firm->firm }}</a><br />
							@endforeach
						@endif
					</div>
				</div>
			</div>
			<div class="col-sm">
				<div class="card text-white mb-3" style="max-width: 18rem;background-color:#00b3ff;">
					<h4 class="card-header">Информация</h4>
					<div class="card-body">
						<a href="/terms">Общи условия</a><br />
						<a href="/politika">Политика на поверителност</a><br />
						<a href="/dostavka">Доставка и плащане</a><br />
						<a href="/vrashtane">Връщане на продукт</a>
					</div>
				</div>
			</div>
			<div class="col-sm">
				<div class="card text-white mb-3" style="max-width: 18rem;background-color:#00b3ff;">
					<h4 class="card-header">Как да ни намерите</h4>
					<div class="card-body">
						<span class="card-text">{{ $footer->phone }}</span><br />
						<span class="card-text">{{ $footer->mail }}</span><br />
						<span class="card-text">{{ $footer->city }}</span><br />
						<span class="card-text">{{ $footer->address }}</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<p class="text-center">Copyright 2018 &copy; <a href="https://avamb-logiciel.com" target="_blanc">AVAMB Logiciel</a> | Powered by <a href="https://avalonbg.com" target="_blanc">Avalon</a></p>		
</footer>		
