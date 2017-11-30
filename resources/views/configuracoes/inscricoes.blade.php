@extends('layout.principal')

@section('title')
	Configurações
@endsection

@section('meta')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('styles')

	<style type="text/css">
		.titulo-pagina{
			display: inline-block;
			margin: 0;
		}

	</style>

@endsection

@section('content')
	
	<ul  class="nav nav-tabs" style="margin-top: 30px;">

			<h2 class="titulo-pagina">Configurações</h2>

			<li class="pull-right" ><a href="{{action('ConfiguracoesController@index')}}">conta</a></li>

			<li class="pull-right active"><a>inscrições</a></li>

			<li class="pull-right"><a href="{{action('ConfiguracoesController@notificacoes')}}">notificações</a></li>

	</ul>


	<div class="container">
		
		<div class="row">

			<div class="page-header">
								
				<h4>empresas em que estou inscrito:</h4>

			</div>

			@if ($inscricaos->totalEmpresas < 1)
				
				<div class="jumbotron">

					<h4>Por enquanto nenhuma.</h4>

				</div>

			@else

				<table class="table table-bordered table-striped table-hover">

					<tr class="info">

						<th class="text-center">empresa</th>

						<th class="text-center">cnpj</th>

						<th class="text-center">ações</th>

					</tr>

					@foreach ($inscricaos as $i)
						<tr>
							@if ($i->tipo == 1)
								
								<td>{{$i->empresa->nome}}</td>
								
								<td>{{$i->empresa->cnpj or "não informado"}}</td>
									
								<td>
									<a href="#" onclick="event.preventDefault(); toggleSubscribe('{{$i->empresa->id}}', '1')">
										<span class="glyphicon glyphicon-bell"></span> 
										deixar de seguir
									</a>
								</td>
							@endif
						</tr>

					@endforeach
				</table>

			@endif

		</div>

		<div class="row">
					
			<div class="page-header">
							
				<h4>municípios em que estou inscrito:</h4>

			</div>


			@if ($inscricaos->totalContratantes < 1)
				
				<div class="jumbotron">

					<h4>Por enquanto nenhum.</h4>

				</div>

			@else
	
				<table class="table table-bordered table-striped table-hover">
					<tr class="warning">
						<th class="text-center">município</th>
						<th class="text-center">ações</th>
					</tr>

					@foreach ($inscricaos as $i)
						<tr>
							@if ($i->tipo == 2)
								
								<td>{{$i->contratante->nome}}</td>
																
								<td>
									<a href="#" onclick="event.preventDefault(); toggleSubscribe('{{$i->contratante->id}}', '2')">
										<span class="glyphicon glyphicon-bell"></span> 
										deixar de seguir
									</a>
								</td>
							@endif
						</tr>

					@endforeach
			
				</table>

			@endif

		</div>

	</div>


@endsection


@section('scripts')

	<script type="text/javascript" src="{{asset('js/url.js')}}"></script>
	
	<script type="text/javascript" src="{{asset('js/toggle-subscribe.js')}}"></script>
	
@endsection