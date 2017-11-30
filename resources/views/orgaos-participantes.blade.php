@extends('layout.principal')
	
@section('title')
	Órgãos participantes
@endsection

@section('styles')
@endsection

@section('content')
	<div class = "col-md-10 col-md-offset-1">
	<div class = 'page-header'>
		<h2>Quem está participando da rede do IELED?</h2>
	</div>
		<ul>
			@foreach ($orgaos as $o)
				<li>{{$o->nome}}</li>
			@endforeach
		</ul>
	</div>

@endsection