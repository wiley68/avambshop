@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
	<div class="col"></div>
        <div class="col-8">
            <div class="card border-info mb-3">
                <div class="card-header">Регистрация в магазина</div>

                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}

                        <div class="form-group row">
                            <label for="name" class="col-sm-4 col-form-label">Имена</label>

                            <div class="col-sm-8">
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label">E-Mail Адрес</label>

                            <div class="col-sm-8">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-sm-4 col-form-label">Парола</label>

                            <div class="col-sm-8">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-sm-4 col-form-label">Потвърди паролата</label>

                            <div class="col-sm-8">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-8">
                                <button type="submit" class="btn btn-info">
                                    Регистрирай
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
		<div class="col"></div>
    </div>
</div>
@endsection
