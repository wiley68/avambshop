<?php use App\Http\Controllers\FirmsController;?>
<?php use App\Http\Controllers\ProductsController;?>
<?php use App\Http\Controllers\WebslidersController;?>
<?php 
	$slide1 = WebslidersController::getSlide1(); 
	$slide2 = WebslidersController::getSlide2(); 
	$slide3 = WebslidersController::getSlide3();
?>
<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
	<ol class="carousel-indicators">
		<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
		<li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
		<li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
	</ol>
	<div class="carousel-inner">
		<div class="carousel-item active">
			<img class="d-block w-100" src="{{ env('APP_SITE') }}/dist/img/slides/slide_1.jpg?auto=yes&bg=777&fg=555&text=First slide" alt="First slide" onerror="this.src='/img/pic1.jpg'">
			<div class="carousel-caption d-none d-md-block">
				<h2><span class="badge badge-primary">{{ $slide1->name }}</span></h2>
				<h4><span class="badge badge-primary">{{ $slide1->text }}</span></h4>
				@if($slide1->button_text)
					<a href="{{ $slide1->button_link }}" class="btn btn-success">{{ $slide1->button_text }}</a>
				@endif
			</div>
		</div>
		<div class="carousel-item">
			<img class="d-block w-100" src="{{ env('APP_SITE') }}/dist/img/slides/slide_2.jpg?auto=yes&bg=666&fg=444&text=Second slide" alt="Second slide" onerror="this.src='/img/pic2.jpg'">
			<div class="carousel-caption d-none d-md-block">
				<h2><span class="badge badge-primary">{{ $slide2->name }}</span></h2>
				<h4><span class="badge badge-primary">{{ $slide2->text }}</span></h4>
				@if($slide2->button_text)
					<a href="{{ $slide2->button_link }}" class="btn btn-success">{{ $slide2->button_text }}</a>
				@endif
			</div>
		</div>
		<div class="carousel-item">
			<img class="d-block w-100" src="{{ env('APP_SITE') }}/dist/img/slides/slide_3.jpg?auto=yes&bg=555&fg=333&text=Third slide" alt="Third slide" onerror="this.src='/img/pic3.jpg'">
			<div class="carousel-caption d-none d-md-block">
				<h2><span class="badge badge-primary">{{ $slide3->name }}</span></h2>
				<h4><span class="badge badge-primary">{{ $slide3->text }}</span></h4>
				@if($slide3->button_text)
					<a href="{{ $slide3->button_link }}" target="_blank" class="btn btn-success">{{ $slide3->button_text }}</a>
				@endif
			</div>
		</div>
	</div>
	<a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">Предходен</span>
	</a>
	<a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="sr-only">Следващ</span>
	</a>
</div>