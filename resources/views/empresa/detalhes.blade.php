@extends('layout.principal')

@section('title')
Detalhes empresa
@stop

@section('content')
<ul class='list-group' style="margin-top: 13px;">
	<li class = 'list-group-item'>nome: {{ $empresa->nome or 'não informado' }}</li>
	<li class = 'list-group-item'>cnpj: {{ $empresa->cnpj or 'não informado' }}</li>
</ul>


<div class="page-heading">
	<h3> Municípios com contratos com esta empresa:</h3>
</div>
<ul>
	@foreach($municipios as $m)
		<li>{{$m->nome}}</li>
	@endforeach
</ul>

@stop