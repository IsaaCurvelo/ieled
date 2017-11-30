@extends('layout.principal')

@section('title')
	Configurações
@endsection

@section('styles')

	<link rel="stylesheet" type="text/css" href="{{ asset('css/custom/dashboard-configuracoes.css') }}">

@endsection

@section('content')


	@if(old('mensagem'))
		<div class = 'alert alert-{{old('classe')}}' style="margin-top: 13px;">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			{{old('mensagem')}}
		</div>
	@endif



	{{-- MODAL NOME --}}


	<div id="modal-form-nome" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">

				<div class="row" style="width: 100%; margin-bottom: 0; padding-top: 5px;">
					
					<a type="button" class="close" data-dismiss="modal" >&times;</a>


				</div>
				
				<div class="modal-body" style="padding-top: 0">

					<form id="form-nome"  class="form-inline" style="display: inline;" method="POST" action="{{action('ConfiguracoesController@alterarNome')}}">
						{{csrf_field()}}
						<div class="form-group">
							<label for="nome">Novo nome: </label>
							<input type="text" class="form-control" id="nome" name="nome" placeholder="Ex.: Francisco das Chagas">
						</div>
						
						<button type="submit" class="btn btn-success">
						<span class="glyphicon glyphicon-ok"></span>
							confirmar
						</button>
					</form>

				</div>


			
			</div>

		</div>
	</div>


	{{-- /MODAL --}}





	{{-- MODAL ORGAO-INVESTIGADOR --}}


	<div id="modal-form-orgao-investigador" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">

				<div class="row" style="width: 100%; margin-bottom: 0; padding-top: 5px;">
					
					<a type="button" class="close" data-dismiss="modal" >&times;</a>


				</div>
				
				<div class="modal-body" style="padding-top: 0">

					<form id="form-orgao-investigador"  class="form-inline" style="display: inline;" method="POST" action="{{action('ConfiguracoesController@alterarOrgao')}}">
						{{csrf_field()}}
						<div class="form-group typeahead">
							<label for="orgao-investigador">Novo órgão investigador: </label>
							<input type="text" class="form-control" id="orgao-investigador" name="orgao-investigador" placeholder="Ex.: MPC-MA">
						</div>
						
						<button type="submit" class="btn btn-success">
						<span class="glyphicon glyphicon-ok"></span>
							confirmar
						</button>
					</form>

				</div>


			
			</div>

		</div>
	</div>


	{{-- /MODAL --}}





	{{-- MODAL EMAIL --}}


	<div id="modal-form-email" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">

				<div class="row" style="width: 100%; margin-bottom: 0; padding-top: 5px;">
					
					<a type="button" class="close" data-dismiss="modal" >&times;</a>


				</div>
				
				<div class="modal-body" style="padding-top: 0">

					<form id="form-email"  class="form-inline" style="display: inline;" method="POST" method="POST" action="{{action('ConfiguracoesController@alterarEmail')}}">
						{{csrf_field()}}
						<div class="form-group">
							<label for="email">Novo email: </label>
							<input type="email" class="form-control" id="email" name="email" placeholder="Ex.: francisco.das.chagas@email.com">
						</div>
						
						<button type="submit" class="btn btn-success">
						<span class="glyphicon glyphicon-ok"></span>
							confirmar
						</button>
					</form>

				</div>


			
			</div>

		</div>
	</div>


	{{-- /MODAL --}}



	{{-- MODAL TELEFONE --}}


	<div id="modal-form-telefone" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">

				<div class="row" style="width: 100%; margin-bottom: 0; padding-top: 5px;">
					
					<a type="button" class="close" data-dismiss="modal" >&times;</a>


				</div>
				
				<div class="modal-body" style="padding-top: 0">

					<form id="form-telefone"  class="form-inline" style="display: inline;" method="POST" action="{{action('ConfiguracoesController@alterarTelefone')}}">
						{{csrf_field()}}
						<div class="form-group">
							<label for="telefone">Novo telefone: </label>
							<input type="telefone" class="form-control" id="telefone" name="telefone">
						</div>
						
						<button type="submit" class="btn btn-success">
						<span class="glyphicon glyphicon-ok"></span>
							confirmar
						</button>
					</form>

				</div>


			
			</div>

		</div>
	</div>


	{{-- /MODAL --}}









	
	<ul  class="nav nav-tabs" style="margin-top: 30px;">

			<h2 class="titulo-pagina">Configurações</h2>

			<li class="pull-right active" ><a>conta</a></li>

			<li class="pull-right"><a href="{{action('ConfiguracoesController@inscricoes')}}">inscrições</a></li>

			<li class="pull-right"><a href="{{action('ConfiguracoesController@notificacoes')}}">notificações</a></li>

	</ul>



	<div class="row">

		<div class="container">


			<div class="bs-callout bs-callout-primary">
				
				<div class="extra-info">

					<h4 id = "contato-detalhes"> <strong> Informações da conta:</strong></h4>

					<table class="table" style="margin-top: 13px;">
						
						<tr>

							<td>

								<strong>nome</strong>: {{auth()->user()->name}}
								
							</td>

							<td>
								
								<a style="margin-left: 7px;" href="" title="clique para editar" data-toggle="modal" data-target="#modal-form-nome">
									<span class="glyphicon glyphicon-pencil"></span>
								</a>

							</td>

					  	</tr>



						<tr>

							<td>

								<strong>órgão investigador</strong>: {{auth()->user()->orgao_investigador->nome}}
								
							</td>

							<td>
								
								<a style="margin-left: 7px;" href="" title="clique para editar" data-toggle="modal" data-target="#modal-form-orgao-investigador" onclick="buscar();">
									<span class="glyphicon glyphicon-pencil"></span>
								</a>

							</td>

				  		</tr>



					  	<tr>

						    <td>

						    	<strong>email</strong>: {{auth()->user()->email}}
								
						    </td>

						    <td>
						    	
						    	<a style="margin-left: 7px;" href="" title="clique para editar" data-toggle="modal" data-target="#modal-form-email">
									<span class="glyphicon glyphicon-pencil"></span>
								</a>

						    </td>

					  	</tr>



						<tr>

						    <td>
						    	<strong>telefone</strong>: {{auth()->user()->telefone == null ? "não informado" : auth()->user()->telefone }}
								
					    	</td>

					    	<td>
					    		
					    		<a style="margin-left: 7px;" href="" title="clique para editar" data-toggle="modal" data-target="#modal-form-telefone">
									<span class="glyphicon glyphicon-pencil"></span>
								</a>

					    	</td>

					  	</tr>



					</table>


					<button class="btn btn-primary" style="margin-top: 20px;" href="#form-pswd" data-toggle="collapse">
						<span class="glyphicon glyphicon-lock"></span>
						mudar minha senha
					</button>


					<form id="form-pswd" class="form {{!old('error')? " collapse" : ""}}" style="margin-top: 30px;" method="POST" action="{{action('ConfiguracoesController@alterarSenha')}}">
					
						{{ csrf_field() }}

					
						<div class="form-group {{ old('senhaIncorreta') ? ' has-error' : '' }}
						col-md-4" style="display: block !important; float:none;">

							<label>antiga senha</label>

							<input class="form-control" type="password" name="old-password">

							@if (old('senhaIncorreta'))

									<span class="help-block">

										<strong>{{ old('senhaIncorreta') }}</strong>

									</span>				

							@endif
							<a class="btn btn-link" href="{{ url('/password/reset') }}">
								Esqueceu sua senha?
							</a>

						</div>


						<div class="form-group {{ old('senhaNaoConfere') ? ' has-error' : '' }} col-md-4" style="display: block !important; float:none;">

							<label>nova senha</label>
							
							<input class="form-control" type="password" name="new-password">

							@if (old('senhaNaoConfere'))

									<span class="help-block">

										<strong>{{ old('senhaNaoConfere') }}</strong>

									</span>								

							@endif
							
						</div>



						<div class="form-group col-md-4" style="display: block !important; float:none;">

							<label>confirme a nova senha</label>

							<input class="form-control" type="password" name="new-password_confirmation">

						</div>



						<button type="submit" class="btn btn-warning">
							<span class="glyphicon glyphicon-floppy-disk"></span>
							alterar a senha
						</button>



					</form>

				</div>

			</div>




			<div class="bs-callout bs-callout-danger">

				<div class="container">
				
					<div class="extra-info">

						<h4 id = "contato-detalhes"> <strong> Excluir conta IELED:</strong></h4>

						<div class="row" style="margin-top: 20px;">

							<div class="form-group col-md-4" >
								<button class="btn btn-danger" href="#form-dlt-acct" data-toggle="collapse"> 
									<span class="glyphicon glyphicon-trash"></span>
									quero excluir minha conta IELED 
								</button>	

							</div>


							<form id="form-dlt-acct"  class="form-inline {{!old('dlSenhaIncorreta')? " collapse" : ""}}" method="POST" action="{{action('ConfiguracoesController@deleteAccount')}}">

								{{csrf_field()}}

								<div class="form-group {{ old('dlSenhaIncorreta') ? ' has-error' : '' }}">

									<input type="password" class="form-control" id="exampleInputName2" placeholder="Sua senha" name="password">

								</div>
								

								<button type="submit" class="btn btn-danger">

								<span class="glyphicon glyphicon-ok"></span>

									confirmar

								</button>

							</form>

						</div>
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
	<script src="{{asset('js/typeahead.js')}}" type="text/javascript"></script>
	<script src="{{asset('js/configuracoes-dashboard.js')}}"type="text/javascript"></script>
@endsection



