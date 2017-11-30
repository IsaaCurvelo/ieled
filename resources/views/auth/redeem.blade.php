@extends('layout.principal')

@section('title')
  Resgatar conta  IELED
@endsection

@section('content')
<div class="container" style="margin-top: 20px;">
  <div class="row">

    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-warning">

        <div class="panel-heading">
        	<h3 style = "margin:0" >Resgatar conta IELED</h3>
        </div>
        <div class="panel-body">
          <form class="form-horizontal" role="form" method="POST" action="{{action('Auth\RedeemAccountController@redeemAccount')}}">
            {{ csrf_field() }}

            <div class="form-group{{ isset($error) ? ' has-error' : '' }}">
              <label for="email" class="col-md-4 control-label">
                E-mail
              </label>

              <div class="col-md-6">
                <div class = 'input-group'>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                  <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                  @if (isset($email_error))
                    <span class="help-block">
                      <strong>{{ $email_error }}</strong>
                    </span>
                  @endif
              </div>
            </div>

            <div class="form-group{{ isset($error) ? ' has-error' : '' }}">
              <label for="password" class="col-md-4 control-label">Senha</label>

              <div class="col-md-6">
                <div class = 'input-group'>
                  <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                  <input id="password" type="password" class="form-control" name="password" required>

                </div>
                
                @if (isset($password_error))
                      <span class="help-block">
                          <strong>{{ $password_error }}</strong>
                      </span>
                @endif
              </div>
            </div>


            <div class="form-group">
              <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                  <span class="glyphicon glyphicon-repeat"></span>
                  resgatar
                </button>

                <a class="btn btn-link" href="{{ url('/password/reset') }}">
                  Quero resgatar a conta mas não lembro da senha.
                </a>
              </div>

            </div>
          </form>
        </div>


      </div>
    </div>
@endsection
