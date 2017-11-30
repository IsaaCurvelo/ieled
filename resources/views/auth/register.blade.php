@extends('layout.principal')

@section('title')
	Criar conta
@endsection

@section('content')
<div class="container" style="margin-top: 20px;">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-primary">

				<div class="panel-heading">
					<h3 style = "margin:0" >Criar conta IELED</h3>
				</div>



				<div class="panel-body">
					<form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">

						{{-- creates a input hidden and sets the token --}}
						{{ csrf_field() }}

						<div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
							<label for="name" class="col-md-4 control-label">Nome(obrigatório)</label>

							<div class="col-md-8">
								<div class = 'input-group'>
									<span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
									<input id="name" type="text" class="form-control" name="name" placeholder="nome..." value="{{ old('name') }}" required autofocus>
								</div>

								@if ($errors->has('name'))
									<span class="help-block">
										<strong>{{ $errors->first('name') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
							<label for="email" class="col-md-4 control-label">E-mail(obrigatório)</label>

							<div class="col-md-8">
								<div class = 'input-group'>
									<span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
									<input id="email" type="email" class="form-control" name="email" placeholder="exemplo@email.com" value="{{ old('email') }}" required>
								</div>

								@if ($errors->has('email'))
									<span class="help-block">
										<strong>{{ $errors->first('email') }}</strong>
									</span>
									<a href="{{ url('/password/reset') }}">não lembro a senha </a> ou <a href="{{ url('/resgatar-conta')}}"> quero reativar minha conta</a>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('telefone') ? ' has-error' : '' }}">
							<label for="telefone" class="col-md-4 control-label">Telefone(facultativo)</label>

							<div class="col-md-8">
								<div class = 'input-group'>
									<span class="input-group-addon"><span class="glyphicon glyphicon-phone"></span></span>
									<input id="telefone" type="telefone" class="form-control" name="telefone" value="{{ old('telefone') }}">
								</div>

								@if ($errors->has('telefone'))
									<span class="help-block">
										<strong>{{ $errors->first('telefone') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('orgao_investigador') ? ' has-error' : '' }}">
							<label for="orgao_investigador" class="col-md-4 control-label">Órgão Investigador *</label>

							<div class="col-md-8">

								<div class = 'input-group'>
									<span class="input-group-addon"><span class="glyphicon glyphicon-home"></span></span>
									<input id="orgao_investigador" type="orgao_investigador" class="form-control" name="orgao_investigador" value="{{ old('orgao_investigador') }}" required>
								</div>

								@if ($errors->has('orgao_investigador'))
									<span class="help-block">
										<strong>{{ $errors->first('orgao_investigador') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
							<label for="password" class="col-md-4 control-label">Senha para acesso</label>

							<div class="col-md-8">
								<div class = 'input-group'>
									<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
									<input id="password" type="password" class="form-control" name="password" required placeholder="senha...">
								</div>

								@if ($errors->has('password'))
									<span class="help-block">
										<strong>{{ $errors->first('password') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
							<label for="password-confirm" class="col-md-4 control-label">Confirme a senha</label>

							<div class="col-md-8">
								<div class = 'input-group'>
									<span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
									<input id="password-confirm" type="password" class="form-control" name="password_confirmation" required placeholder="confimação de senha...">
								</div>

								@if ($errors->has('password_confirmation'))
									<span class="help-block">
										<strong>{{ $errors->first('password_confirmation') }}</strong>
									</span>
								@endif
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-8 col-md--4 col-md-offset-4">
								<button type="submit" class="btn btn-success pull-right">
									<span class= 'glyphicon glyphicon-user'></span>
									cadastrar
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


@section('scripts')
	<!--JQUERTY-UI-->
	<link rel="stylesheet" href="{{asset('jquery-ui/jquery-ui.min.css')}}">
	<script src="{{asset('jquery-ui/external/jquery/jquery.js')}}"></script>
	<script src="{{asset('jquery-ui/jquery-ui.min.js')}}"></script>
	<!--JQUERY-UI-->

	<script src="{{asset('js/masks.js')}}" type="text/javascript"></script>

	<script type="text/javascript">

		$(document).ready(function() {
			$("#telefone").mask("(00)00000-0000", {placeholder: "(xx)9xxxx-xxxx"});
			buscar( function(resposta ) {
				var options = JSON.parse(resposta);
				
				$( "#orgao_investigador" ).autocomplete( {
					source: options
				});
			});
		});

	function buscar(callback){
		var method = "GET";
		var url = "{{action('OrgaoInvestigadorController@nomesOrgaos')}}";

	

		var xhttp;
		if (window.XMLHttpRequest) {
			xhttp = new XMLHttpRequest();
		}
		else {
			// para IE6, IE5
			xhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

		xhttp.onreadystatechange = function () {
			if (xhttp.readyState == 4 && xhttp.status == 200) {
				var textoResposta = xhttp.responseText;
				// console.log(textoResposta);
				callback(textoResposta);  
			}
		}

		xhttp.open(method, url, true);
		xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
		//~ console.log("params:  " + params);
		xhttp.send();
	}
	</script>
@endsection

