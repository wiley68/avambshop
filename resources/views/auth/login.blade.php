@extends('layouts/app')

@section('content')
<div class="container">
    <div class="row">
		<div class="col"></div>
        <div class="col-8">
            <div class="card border-info mb-3">
                <div class="card-header">Вход в магазина</div>
                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
						
						<div class="form-group row">
							<label for="email" class="col-sm-4 col-form-label">E-Mail Адрес:</label>							
                            <div class="col-sm-8">
								<input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}" required autofocus>
                                @if ($errors->has('email'))
								<span class="help-block">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
                                @endif
							</div>
						</div>
						
                        <div class="form-group row">
                            <label for="password" class="col-sm-4 col-form-label">Парола:</label>					
                            <div class="col-sm-8">
								<input type="password" class="form-control" id="password" name="password" required>
                                @if ($errors->has('password'))
								<span class="help-block">
									<strong>{{ $errors->first('password') }}</strong>
								</span>
                                @endif
							</div>
						</div>
						
                        <div class="form-check">
							<input class="form-check-input" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
							<label class="form-check-label" for="remember">
								Запомни
							</label>
						</div>
						<div style="padding-bottom:20px;"></div>
						<button type="submit" class="btn btn-info">Вход</button>
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            Забравена парола?
						</a>
					</form>
				</div>
			</div>
		</div>
		<div class="col"></div>
		
	</div>
</div>
@endsection
