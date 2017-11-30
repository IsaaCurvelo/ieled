@extends('layout.principal')

@section('title')
	Configurações
@endsection

@section('styles')

	<style type="text/css">
		.titulo-pagina {
			display: inline-block;
			margin: 0;
		}

	</style>

@endsection

@section('content')
	
	<ul  class="nav nav-tabs" style="margin-top: 30px;">

			<h2 class="titulo-pagina">Configurações</h2>

			<li class="pull-right" ><a href="{{action('ConfiguracoesController@index')}}">conta</a></li>

			<li class="pull-right"><a href="{{action('ConfiguracoesController@inscricoes')}}">inscrições</a></li>

			<li class="pull-right active"><a>notificações</a></li>

	</ul>
@endsection