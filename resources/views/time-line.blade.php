@extends('layout.principal')

@section('meta')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

	
@section('title')
	Todas as ocorrências
@endsection

@section('styles')
	<link rel="stylesheet" href="{{asset('css/custom/home.css')}}" media="screen" title="no title" charset="utf-8">

	<style type="text/css">

		.radio-option {

			display: block

		}
		.radio-option:hover {

			background-color: #eee;

		}

		.radio-wrapper{
			width: 100%;
			display: block;
			padding-left: 7px;
		}
		.radio-wrapper label {
			width: 80%;
		}

	</style>

@endsection

@section('navbar-item')

	<div id = "drop-list-open" class="dropdown navbar-form navbar-left">

		<button class="btn btn-default dropdown-toggle" type="button" id="dropdownmenu" data-toggle="dropdown">
			pesquisar por <span class="caret"></span>
		</button>

		<ul class="dropdown-menu" aria-labelled-by="dropdownmenu" id="drop-list">

			<li class="drop-li">
				<a value="cnpj" href="#" 
				onclick="event.preventDefault(); clickSearchOption(this);">
					cnpj
				</a>
			</li>

			<li class="drop-li">
				<a value="nome" href="#" 
				onclick="event.preventDefault(); clickSearchOption(this);">
					nome
				</a>
			</li>

			<li class="drop-li">
				<a value="municipio" href="#" 
				onclick="event.preventDefault(); clickSearchOption(this);">
					município
				</a>
			</li>

		</ul>
		
	</div>

	<form onsubmit="event.preventDefault(); buscaSimples(this)" action="{{action('TimeLineController@buscaNormal')}}" id = 'form-navbar' class="navbar-form navbar-left">
		<div class="form-group">
			<input id="texto-busca" name="texto" type="text" class="form-control" placeholder="pesquise aqui...">
			<input type="hidden" name="modoDeBusca" value="" id="modoDeBusca">
		</div>
		<button type="submit" class="btn btn-danger">
			<span style="font-size: 20px" class="glyphicon glyphicon-search"></span>
		</button>
	</form>
	


	<div class="vertical-separator"></div>

	<div class="navbar-form navbar-left">
		<button class="btn btn-primary" 
		title="clique neste botão para abrir um menu de busca mais avançado"
		data-toggle="modal" data-target="#modal-form-busca"''>
			avançada
		</button>
	</div>

@endsection


@section('content')

	@if($isBusca)

		<div class="page-header col-md-8 col-md-offset-2">
			
			<h3>Resultados para a busca:</h3>

		</div>

	@endif

	<!-- Modal -->
	<div id="modal-form-busca" class="modal fade" role="dialog">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Busca avançada</h4>
				</div>
				<div class="modal-body">
					<form id="form-busca-avancada" class="form" action="{{action('TimeLineController@buscaAvancada')}}" onsubmit="event.preventDefault(); buscaAvancada(this)"> 
						<label>
							nome da empresa
							<input type="text" name="nome-empresa" class="form-control">
						</label>
						<label>
							cnpj da empresa
							<input type="text" name="cnpj-empresa" class="form-control" id="cnpj-empresa">
						</label>
						<label>
							<input type="checkbox" onclick="habilita('1');"> contratante
							<select id='select1' name="contratante" class="form-control" disabled>
								@foreach( $contratantes as $contratante )
								<option value="{{$contratante->id}}">{{$contratante->nome}}</option>
								@endforeach
							</select>
						</label>
						<label>
							<input type="checkbox" onclick="habilita('2');"> orgao investigador
							<select id='select2' name="orgao-investigador" class="form-control" disabled>
								@foreach( $orgaoInvestigadors as $orgaoInvestigador )
								<option value="{{$orgaoInvestigador->id}}">{{$orgaoInvestigador->nome}}</option>
								@endforeach
							</select>
						</label>
						<fieldset>
							<legend>data:</legend>
							<label>
								início
								<input type="text" name="data-inicio" class="form-control" id="data-inicio">
							</label>
							<label>
								fim
								<input type="text" name="data-fim" class="form-control" id="data-fim">
							</label>
						</fieldset>

						

					</form>
				</div>
				<div class="modal-footer">
					<button form="form-busca-avancada" class="btn btn-success" type="submit">enviar</button>
					<button type="button" class="btn btn-default" data-dismiss="modal">fechar</button>
				</div>
			</div>

		</div>
	</div>

	@if(count($ocorrencias) == 0)
		<div class="jumbotron" style="margin-top: 20px;">
			<h2>:/ Não encontramos registros para exibir...</h2>
			<p>clique <a href="{{action('TimeLineController@timeline')}}">aqui</a> para retornar...</p>
		</div>
	@endif	

	@foreach( $ocorrencias as $o )

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

				</div>
				<div class="content-callout">

					<p>						
						Empresa 
						<a href="{{action('OcorrenciaController@lookInto', ['modo' => 'empresa', 'id'=> $o->empresa->id, 'viewMode'=>'posts'])}}">
							{{$o->empresa->nome}}
						</a> 
						em situação <strong>{{$o->situacao->nome}}</strong>
						com o município 
						<a href="{{action('OcorrenciaController@lookInto', ['modo' => 'contratante', 'id'=> $o->contratante->id, 'viewMode'=>'posts'])}}">
							{{$o->contratante->nome}}
						</a>.
					</p>

					@if(isset($o->valor))
						<p>
							Valor de contratação estimado em 
							@if(strpos($o->valor, 'R$') === false )
							R$
							@endif
							{{$o->valor}}.
						</p>
					@endif
					
					<div>
						<div class="extra-info">

							<h4> <strong> Detalhes da contratação</strong></h4>

							<ul class = "lista-info">
								<li>
									<strong>cnpj:</strong>
									{{$o->empresa->cnpj or 'não informado'}}
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
									<strong>Valor (R$):</strong> {{$o->valor or 'não informado'}}
								</li>
								<li>
									<strong>Fonte:</strong> {{$o->procedimento or 'não informado'}}
								</li>
								
							</ul>
						</div>
					</div>

					@unless ($o->user->id === Auth::user()->id)
					<div>
						<div class="extra-info">

							<h4 id = "contato-detalhes"> <strong> Informações para contato</strong></h4>
							<table class="table-contato">
								<tr>
								<td width="55%">órgão investigador:</td>
									<td> {{$o->user->orgao_investigador->nome}} </td>
								</tr>
								<tr>
									<td>nome:</td>
									<td>
										{{$o->user->name}}
									</td>
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
					@endunless

				</div>

				<div class="bottom-callout" >
					<a class="action-callout-normal" href="#" 
					onclick="event.preventDefault(); toggleSubscribe({{$o->empresa->id}}, 1)">
						@if($o->inscEmpresa)
							<span class = "glyphicon glyphicon-bell"></span>
							<small>parar de seguir esta empresa</small>
						@else
							<span class = "glyphicon glyphicon-bell glyphicon-bordered" style="color:gray;"></span>
							<small style="color:gray;">seguir esta empresa</small>
						@endif
					</a>
					<a class="action-callout-normal" href="#" 
					onclick="event.preventDefault(); toggleSubscribe({{$o->contratante->id}}, 2)">
						@if($o->inscContrat)
							<span class = "glyphicon glyphicon-bell"></span>
							<small>parar de seguir este município</small>
						@else
							<span class = "glyphicon glyphicon-bell glyphicon-bordered" style="color:gray;"></span>
							<small style="color:gray;">seguir este município</small>
						@endif
					</a>
				</div>

			</div>
		</div>

	@endforeach
	<div class="col-md-12">
		<div class="text-center">
			{{ $ocorrencias->appends(Request::except('page'))->links() }}
		</div>
	</div>
@endsection


@section('scripts')
	<script src="{{asset('js/masks.js')}}" type="text/javascript"></script>
	<script type="text/javascript" src='{{asset('js/time-line.js')}}'></script>
	<script type="text/javascript" src="{{asset('js/url.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/toggle-subscribe.js')}}"></script>

@endsection


