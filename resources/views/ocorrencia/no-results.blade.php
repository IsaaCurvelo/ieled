@extends('layout.principal')

@section('title')
	Sem resultados
@endsection

@section('styles')
	
@endsection
	
@section('content')
	<div class = 'jumbotron'>
		<h3>: /</h3>
		<h3>Não temos resultados para exibir...</h3>
		<a href='{{URL::previous()}}' class = 'btn btn-success' >retornar</a>
	</div>
@endsection