<?php use App\Http\Controllers\FirmsController;?>
<div class="card">
	<h5 class="card-header">{{ $firm->firm }}</h5>
	<div class="card-body">
		<div class="row">
			<div class="col-sm">
				@if(FirmsController::checkRemoteFile("{{ env('APP_SITE') }}/dist/img/logo_" . $firm->id . ".jpg"))
					<img class="card-img-top" src="{{ env('APP_SITE') }}/dist/img/logo_{{ $firm->id }}.jpg" alt="Card image cap">
				@else
					<img class="card-img-top" src="{{ env('APP_SITE') }}/dist/img/products/product_.jpg" alt="Card image cap">					
				@endif
			</div>
			<div class="col-9">
				<ul class="list-group list-group-flush">
					<li class="list-group-item"><span>Комерсиално име: </span>{{ $firm->firm_name }}</li>
					<li class="list-group-item"><span>Идентификационен номер: </span>{{ $firm->eik }}</li>
					<li class="list-group-item"><span>Адрес: </span>{{ $firm->address1 }}</li>
					<li class="list-group-item"><span>Град: </span>{{ $firm->city }}</li>
					<li class="list-group-item"><span>Фирмен телефон: </span>{{ $firm->firm_phone1 }}</li>
					<li class="list-group-item"><span>E-Mail адрес: </span>{{ $firm->firm_mail }}</li>
					<li class="list-group-item">
					<span>Документи: </span>

					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div style="padding-bottom:20px;"></div>
