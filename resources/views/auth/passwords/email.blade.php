@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
	<div class="col"></div>
        <div class="col-8">
            <div class="card border-info mb-3">
                <div class="card-header">Смяна на паролата</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

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

                        <div class="form-group">
                            <div class="col-8">
                                <button type="submit" class="btn btn-info">
                                    Изпрати заявка за смяна на паролата
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
