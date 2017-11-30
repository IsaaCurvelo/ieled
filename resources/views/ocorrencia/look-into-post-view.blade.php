@extends('layout.principal')

@section('meta')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
	{{$ocorrencias[0][$modo]->nome}} 
@endsection

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{asset('css/custom/look-into.css')}}">
@endsection

@section('content')
	<main style="margin-top: 13px;">
		
		<ul  class="nav nav-tabs">
			<h2 class="titulo-pagina">Contratações de {{$ocorrencias[0][$modo]->nome}}</h2>
			<li class="pull-right active" ><a href="#">Posts</a></li>
			<li class="pull-right"><a href="{{action("OcorrenciaController@lookInto", ["modo"=>$modo,"id" => $ocorrencias[0][$modo]->id, 'viewMode'=>'table'])}}">Tabela</a></li>
		</ul>


		@foreach($ocorrencias as $o)
			<div class = 'col-md-8 col-md-offset-2'>
			<div class="callout-post bs-callout bs-callout-{{$bsClasses[$o->situacao->nome]}}">
				<div class="top-callout">
					<div class="usr-callout">
						<h4>
						@if ($o->user->id === Auth::user()->id)
							Eu
						@else
							{{$o->user->orgao_investigador->nome}}
						@endif
						</h4>
					</div>
					<div class="data-callout">
						<small>em {{$o->data}}</small>
					</div>
					<div class="dropdown pull-right">
					  <button class=" seta-dropdown dropdown-toggle"
							type="button" id="dropdownMenu1"
							data-toggle="dropdown"
							aria-haspopup="true"
							aria-expanded="true">
					    <span class="caret"></span>
					  </button>
					  <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					    <li><a href="">
								<span class="glyphicon glyphicon-bell"></span>
								Ativar notificações para esta empresa</a>
							</li>
					    <li><a href="#">Another action</a></li>
					    <li><a href="#">Something else here</a></li>
					    <li role="separator" class="divider"></li>
					    <li><a href="#">Separated link</a></li>
					  </ul>
					</div>
				</div>
				<div class="content-callout">
				@if($modo == 'empresa')
					<p>						
						Empresa em situação <strong>{{$o->situacao->nome}}</strong>
						com o município <a href="{{action('OcorrenciaController@lookInto', ['modo' => 'contratante', 'id'=> $o->contratante->id, 'viewMode'=>'posts'])}}"> {{$o->contratante->nome}} </a>.
					</p>
				@else
					<p>
						Empresa <a href="{{action('OcorrenciaController@lookInto', ['modo' => 'empresa', 'id'=> $o->empresa->id, 'viewMode'=>'posts'])}}">{{$o->empresa->nome}}</a> em situação <strong>{{$o->situacao->nome}}</strong>
						com o município.						
					</p>
				@endif

					@if(isset($o->valor))
						<p>
							Valor de contratação estimado em 
							@if(strpos($o->valor, 'R$') === false )
							R$
							@endif
							{{$o->valor}}.
						</p>
					@endif
					
					<div  id="collapse{{$o->id}}"
						class="collapse"
					>
						<div class="extra-info">

							<h4> <strong> Detalhes da contratação</strong></h4>

							<ul class = "lista-info">
								<li>
									<strong>cnpj:</strong>
									{{$o->empresa->cnpj}}
								</li>
								<li>
									<strong>situação:</strong>
									{{$o->situacao->nome}}
								</li>
								<li>
									<strong>Area da despesa:</strong> {{$o->area_despesa->nome or 'não informado'}}
								<li>
									<strong>Tipo da despesa:</strong> {{$o->tipo_despesa->nome or 'não informado'}}
								</li>
								<li>
									<strong>Fonte:</strong> {{$o->procedimento or 'não informado'}}
								</li>
								<li>
									<strong>Valor:</strong> {{$o->valor or 'não informado'}}
								</li>
							</ul>
						</div>
					</div>

					<div  id="collapse2{{$o->id}}"
						class="collapse"
					>
						<div class="extra-info">

							<h4 id = "contato-detalhes"> <strong> Informações para contato</strong></h4>
							<table class="table-contato">
								<tr>
							  	<td width="55%">órgão investigador:</td>
									<td> {{--$o->user->orgao_investigador->nome--}} </td>
						  		</tr>
								<tr>
							  		<td>nome:</td>
									<td>{{$o->user->name}}</td>
							  	</tr>
							  	<tr>
								    <td>email:</td>
								    <td>{{$o->user->email}}</td>
							  	</tr>
								<tr>
								    <td>telefone:</td>
								    <td>{{$o->user->telefone or 'não informado'}}</td>
							  	</tr>
							</table>

						</div>
					</div>

				</div>

				<div class="bottom-callout">
					<a class="action-callout"
						data-toggle="collapse"
						data-target="#collapse2{{$o->id}}"
						aria-expanded="false"
						aria-controls="collapse2{{$o->id}}"
				  >
						<span class = "glyphicon glyphicon-user"></span>
						<small>contato</small>
					</a>

					<a
						class="action-callout"
						data-toggle="collapse"
						data-target="#collapse{{$o->id}}"
						aria-expanded="false"
						aria-controls="collapse{{$o->id}}"
					>
						<span class = "glyphicon glyphicon-info-sign"></span>
						<small>detalhes</small>
					</a>

					<a class="action-callout"
				 	 	 onclick="$('#form-callout{{$o->id}}').submit()"
						 title = "ver todas as ocorrências de {{$o[$modoOposto]->nome}}"
					>
						<span class = "glyphicon glyphicon-search"></span>
						<small>{{$modoOposto}}</small>
					</a>
					<form style = 'display: none;' id = "form-callout{{$o->id}}" class = "form-callout"
						action="{{action('OcorrenciaController@lookInto', ['modo' => $modoOposto, 'id'=> $o[$modoOposto]->id, 'viewMode'=>'posts'])}}">
					</form>

				</div>
			</div>
			</div>
		@endforeach

		<div class="col-md-12">
			<div class="text-center">
				{{ $ocorrencias->appends(Request::except('page'))->links() }}
			</div>
		</div>


	</main>
@endsection



@section('scripts')

	<!--JQUERTY-UI-->
	<link rel="stylesheet" href="{{asset('jquery-ui/jquery-ui.min.css')}}">
	<script src="{{asset('jquery-ui/external/jquery/jquery.js')}}"></script>
	<script src="{{asset('jquery-ui/jquery-ui.min.js')}}"></script>
	<!--JQUERY-UI-->

	<script type="text/javascript" src="{{asset('js/url.js')}}"></script>

@endsection


