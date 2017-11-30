@extends('layout.principal')

@section('title')
  Login
@endsection

@section('content')
<div class="container" style="margin-top: 20px;">
  <div class="row">

    @if(isset($old))
      <div class = "alert alert-info">
        Antes é necessário que você faça o login...
      </div>
    @endif
    
    <div class="col-md-8 col-md-offset-2">
      <div class="panel panel-success">

        <div class="panel-heading">
        	<h3 style = "margin:0" >Entrar</h3>
        </div>

        <div class="panel-body">
          <form class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
            {{ csrf_field() }}

            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <label for="email" class="col-md-4 control-label">
              	E-mail
              </label>

              <div class="col-md-6">
              	<div class = 'input-group'>
	              	<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
	                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                  @if ($errors->has('email'))
                    <span class="help-block">
                      <strong>{{ $errors->first('email') }}</strong>
                    </span>
                  @endif
              </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              <label for="password" class="col-md-4 control-label">Senha</label>

              <div class="col-md-6">
              	<div class = 'input-group'>
	            		<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                  <input id="password" type="password" class="form-control" name="password" required>

                </div>
                
                @if ($errors->has('password'))
                      <span class="help-block">
                          <strong>{{ $errors->first('password') }}</strong>
                      </span>
                @endif
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-6 col-md-offset-4">
                <div class="checkbox">
                  <label>
                    <input type="checkbox" name="remember"> Lembrar de mim
                  </label>
                </div>
              </div>
            </div>

            <div class="form-group">
              <div class="col-md-8 col-md-offset-4">
                <button type="submit" class="btn btn-primary">
                	<span class="glyphicon glyphicon-user"></span>
                	Entrar
                </button>

                <a class="btn btn-link" href="{{ url('/password/reset') }}">
                  Esqueceu sua senha?
                </a>
              </div>

            </div>
          </form>


          <a href="{{url('register')}}" class="col-md-6 col-md-offset-3"> Ainda não tem uma conta IELED? Crie agora!</a>

        </div>
      </div>
    </div>
  </div>
</div>
@endsection
