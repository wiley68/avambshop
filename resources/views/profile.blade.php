@extends('layouts/app')

@section('content')

@guest
	{{!! redirect()->route('login'); !!}}
@else
	@if(null !== (app('request')->input('status')))
	<div class="alert alert-success" role="alert">
		Вие записахте успешно направените промени!
	</div>
	@endif
	<h1>Профил</h1>
	<hr />
	
	<form class="form-horizontal" method="POST" action="/profile/save">
		{{ csrf_field() }}
		<input id="id" type="hidden" name="id" value="{{ Auth::user()->id }}">
		<div class="form-group row">
            <label for="name" class="col-sm-4 col-form-label">Имена</label>

            <div class="col-sm-8">
                <input id="name" type="text" class="form-control" name="name" value="{{ Auth::user()->name }}" required autofocus>
            </div>
        </div>
		
		<div class="form-group row">
            <label for="email" class="col-sm-4 col-form-label">E-Mail Адрес</label>

            <div class="col-sm-8">
                <input id="email" type="email" class="form-control" name="email" value="{{ Auth::user()->email }}" required>
            </div>
        </div>

		<div class="form-group row">
            <label for="phone" class="col-sm-4 col-form-label">Телефон</label>

            <div class="col-sm-8">
                <input id="phone" type="text" class="form-control" name="phone" value="{{ Auth::user()->phone }}">
            </div>
        </div>

		<div class="form-group row">
            <label for="city" class="col-sm-4 col-form-label">Населено място</label>

            <div class="col-sm-8">
                <input id="city" type="text" class="form-control" name="city" value="{{ Auth::user()->city }}">
            </div>
        </div>

		<div class="form-group row">
            <label for="postalcod" class="col-sm-4 col-form-label">Пощенски код</label>

            <div class="col-sm-8">
                <input id="postalcod" type="text" maxlength="5" class="form-control" name="postalcod" value="{{ Auth::user()->postalcod }}">
            </div>
        </div>

		<div class="form-group row">
            <label for="address" class="col-sm-4 col-form-label">Адрес</label>

            <div class="col-sm-8">
                <input id="address" type="text" class="form-control" name="address" value="{{ Auth::user()->address }}">
            </div>
        </div>

		<div class="form-group row">
            <label for="isfirm" class="col-sm-4 col-form-label">Искате ли фактура на фирма?</label>

            <div class="col-sm-8">
                <input id="isfirma" type="checkbox" class="form-control" name="isfirma" <?php if (Auth::user()->isfirma == 'Yes'){echo 'checked';} ?>>
            </div>
        </div>
		
		<hr />
		<div id="isfirm_group">
			<div class="form-group row">
				<label for="firmname" class="col-sm-4 col-form-label">Име на фирмата</label>

				<div class="col-sm-8">
					<input id="firmname" type="text" class="form-control" name="firmname" value="{{ Auth::user()->firmname }}">
				</div>
			</div>
			
			<div class="form-group row">
				<label for="eik" class="col-sm-4 col-form-label">ЕИК</label>

				<div class="col-sm-8">
					<input id="eik" type="text" class="form-control" name="eik" value="{{ Auth::user()->eik }}">
				</div>
			</div>

			<div class="form-group row">
				<label for="dds_nomer" class="col-sm-4 col-form-label">ДДС Номер</label>

				<div class="col-sm-8">
					<input id="dds_nomer" type="text" class="form-control" name="dds_nomer" value="{{ Auth::user()->dds_nomer }}">
				</div>
			</div>
			
			<div class="form-group row">
				<label for="firmcity" class="col-sm-4 col-form-label">Населено място</label>

				<div class="col-sm-8">
					<input id="firmcity" type="text" class="form-control" name="firmcity" value="{{ Auth::user()->firmcity }}">
				</div>
			</div>
			
			<div class="form-group row">
				<label for="firmaddress" class="col-sm-4 col-form-label">Адрес</label>

				<div class="col-sm-8">
					<input id="firmaddress" type="text" class="form-control" name="firmaddress" value="{{ Auth::user()->firmaddress }}">
				</div>
			</div>
			
			<div class="form-group row">
				<label for="mol" class="col-sm-4 col-form-label">МОЛ</label>

				<div class="col-sm-8">
					<input id="mol" type="text" class="form-control" name="mol" value="{{ Auth::user()->mol }}">
				</div>
				<hr />
			</div>
			
		</div>

		<div class="form-group row">
            <div class="col-8">
                <button type="submit" class="btn btn-info">
                    Запиши
                </button>
            </div>
        </div>
	</form>	
	
@endguest

@endsection

@section('scripts')
    <script src="{{ asset('/js/profile.js') }}"></script>
@stop