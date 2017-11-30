@extends('layout.principal')
	
@section('title')
	Suas notificações
@endsection

@section('styles')
	<link rel="stylesheet" href="{{asset('css/custom/home.css')}}" media="screen" title="no title" charset="utf-8">

@endsection

@section('content')
	<div class="page-header">
		<h3> Detalhes</h3>
	</div>

	<div class = 'col-md-8 col-md-offset-2'>
		<div class="callout-post bs-callout bs-callout-{{$bsClasses[$ocorrencia->situacao->nome]}}">
			<div class="top-callout">
				<div class="usr-callout">
					<h4>
						{{$ocorrencia->user->orgao_investigador->nome}}
					</h4>
				</div>
				<div class="data-callout">
					<small>em {{$ocorrencia->data}}</small>
				</div>

			</div>
			<div class="content-callout">

				<p>						
					Empresa <strong>{{$ocorrencia->empresa->nome}}</strong> em situação <em class="text-{{$bsClasses[$ocorrencia->situacao->nome]}}">{{$ocorrencia->situacao->nome}}</em>
					com o município <em> {{$ocorrencia->contratante->nome}} </em>.
				</p>

				@if(isset($ocorrencia->valor))
					<p>
						Valor de contratação estimado em R$ {{$ocorrencia->valor}}.
					</p>
				@endif
				
					<div class="extra-info">

						<h4> <strong> Detalhes da contratação</strong></h4>

						<ul class = "lista-info">
							<li>
								<strong>cnpj:</strong>
								{{$ocorrencia->empresa->cnpj}}
							</li>
							<li>
								<strong>situação:</strong>
								{{$ocorrencia->situacao->nome}}
							</li>
							<li>
								<strong>Area da despesa:</strong> {{$ocorrencia->area_despesa->nome or 'não informado'}}
							<li>
								<strong>Tipo da despesa:</strong> {{$ocorrencia->tipo_despesa->nome or 'não informado'}}
							</li>
							<li>
								<strong>Fonte:</strong> {{$ocorrencia->procedimento or 'não informado'}}
							</li>
							<li>
								<strong>Valor:</strong> {{$ocorrencia->valor or 'não informado'}}
							</li>
						</ul>
					</div>

					<div class="extra-info">

						<h4 id = "contato-detalhes"> <strong> Informações para contato</strong></h4>
						<table class="table-contato">
							<tr>
						  	<td width="55%">órgão investigador:</td>
								<td> {{$ocorrencia->user->orgao_investigador->nome}} </td>
					  		</tr>
							<tr>
						  		<td>nome:</td>
								<td>{{$ocorrencia->user->name}}</td>
						  	</tr>
						  	<tr>
							    <td>email:</td>
							    <td>{{$ocorrencia->user->email}}</td>
						  	</tr>
							<tr>
							    <td>telefone:</td>
							    <td>{{$ocorrencia->user->telefone or 'não informado'}}</td>
						  	</tr>
						</table>

					</div>

			</div>

			<div class="bottom-callout">
				<a href="#" class="text-danger action-callout" 
				onclick="event.preventDefault(); document.getElementById('form1').submit()">
					<span class = "glyphicon glyphicon-trash"></span>
					<small>limpar notificação</small>
				</a>

				<form id="form1" style="display: none;" method="POST" action="{{action('NotificacaoController@delete')}}">
					<input type="hidden" name="id" value="{{$id}}">
					{{csrf_field()}}
				</form>

				<a href="#" class="text-info action-callout"
				onclick="event.preventDefault(); document.getElementById('form2').submit()" >
					<span class = "glyphicon glyphicon-eye-close"></span>
					<small>marcar como não visto</small>
				</a>
				
				<form id="form2" style="display: none;" method="POST" action="{{action('NotificacaoController@unread')}}">
					<input type="hidden" name="id" value="{{$id}}">
					{{csrf_field()}}
				</form>

				<a href="{{action('NotificacaoController@manageNotifications')}}" class="text-success action-callout">
					<span class = "glyphicon glyphicon-chevron-left"></span>
					<small>voltar para notificações</small>
				</a>

			</div>
		</div>
	</div>


@endsection