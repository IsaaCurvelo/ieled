@extends('layout.principal')
	
@section('title')
	ADM
@endsection

@section('styles')
	<link rel="stylesheet" href="{{asset('css/custom/dashboard-adm.css')}}" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="{{asset('css/font-awesome.css')}}" media="screen" title="no title" charset="utf-8">
@endsection

@section('content')
	<div class="jumbotron">
		<h3>Sem permissão!</h3>
		<p>
			Aparentemente você não é um usuário administrador e tentou acessar o painel administrador.
		</p>
		<a class="btn btn-default" href="/">ir para a página inicial</a>
	</div>
@endsection