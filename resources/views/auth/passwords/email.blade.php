@extends('layout.principal')

@section('title')
  Esqueci minha senha
@endsection

<!-- Main Content -->
@section('content')
<div class="container" style="margin-top: 20px;">
  <div class="row">
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-primary">
          <div class="panel-heading">Resetar senha</div>
          <div class="panel-body">
            @if (session('status'))
              <div class="alert alert-success">
                {{ session('status') }}
              </div>
            @endif

            <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
              {{ csrf_field() }}

              <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">
                	Endereço de e-mail
                </label>

                <div class="col-md-6">
                  <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                  @if ($errors->has('email'))
                    <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                  <button type="submit" class="btn btn-default">
                  	<span class="glyphicon glyphicon-send"></span>
                    Enviar reset de senha
                  </button>
                </div>
              </div>

            </form>

          </div>
        </div>
    </div>
  </div>
</div>
@endsection
