@extends('layout.principal')
	
@section('title')
	Suas notificações
@endsection

@section('styles')
	<link rel="stylesheet" href="{{asset('css/custom/home.css')}}" media="screen" title="no title" charset="utf-8">

	<style type="text/css">

		.action-notif {
			font-size: 120%;
			margin-left: 5px;
			margin-bottom: 5px !important;
		}

	</style>
@endsection

@section('content')
	
	<div class="page-header col-md-offset-1">
		<h4>Suas notificações</h4>
	</div>
	<div class = 'col-md-9 col-md-offset-1'>
		<table class="table table-hover">
			@foreach( $notificacaos as $n)
				
				<tr class = '@if($n->visto === 0){{'success'}}@endif'>
					
					<td>
						<a href = '#' onclick="event.preventDefault(); getElementById('form{{$n->id}}').submit()" title='ir para a ocorrência'>
							{{$n->texto}}
						</a>
					</td>
					
					<form id = 'form{{$n->id}}' method="POST" action="{{action('NotificacaoController@read')}}" style="display: none;">
						<input type="hidden" name="id" value = {{$n->id}}>
						<input type="hidden" name="ocorrencia" value = {{$n->ocorrencia_id}}>
						{{csrf_field()}}
					</form>

					<td>
						<a href="" class="action-notif" title="apagar esta notificação"
						onclick="event.preventDefault(); document.getElementById('form-del-{{$n->id}}').submit()">
							<span  class = 'glyphicon glyphicon-trash text-danger'></span>
						</a>

						<form id="form-del-{{$n->id}}" style="display: none;" method="POST" action="{{action('NotificacaoController@delete')}}">
							<input type="hidden" name="id" value="{{$n->id}}">
							{{csrf_field()}}
						</form>
					</td>

				</li>
			
			@endforeach

			@if(count($notificacaos) == 0)
				<div class = "jumbotron">
					<h3>Sem notificações por aqui...</h3>
					<p>Ninguém tem cadastrado nada das empresas ou municípios que você está inscrito.</p>
				</div>
			@endif
		</table>
	</div>

@endsection

