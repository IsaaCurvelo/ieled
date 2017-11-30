@extends('layout.principal')

@section('meta')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
	Minhas Ocorrências
@endsection

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{asset('css/custom/listgm-ocorrencia.css')}}">
@endsection

@section('content')
	
	@if(old('mensagem'))
		<div class = 'alert alert-{{old('classe')}}'>
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			{{old('mensagem')}}
		</div>
	@endif

	<div id="modal"></div>
	<div id="modal-confirm"></div>

	<div if = "pagina"class="page-header">
		<h1 style="display:inline-block"class = "titulo-pagina">
 		Minhas Ocorrências
 		</h1>

 		<a style="margin-top:3ch "
 		class = "btn-amarelo pull-right" href="{{action('OcorrenciaController@cadastroLote')}}">
			<span class="glyphicon glyphicon-th-list"></span>
			Cadastrar Lote
		</a>

 		<a style="margin-top:3ch "
 		class = "btn-verde pull-right" href="{{action('OcorrenciaController@novo')}}">
			<span class="glyphicon glyphicon-plus"></span>
			Cadastrar nova
		</a>
		
	</div>

	<div id = "pesquisa-section">

		<div class="page-header">
			<h3>Busca</h3>
		</div>

		<div class="col-md-6 pesq-tool">
			<div class="input-group">
				<input
				id='busca-ocorrencia-cnpj'
				name="pesquisa"
				type="text"
				class="form-control"
				placeholder = "Pesquisar ocorrência por CNPJ">
				<span id = "btn-pesq-ocorrencia"
				onclick="buscaOcorrencia('cnpj')"
				class="input-group-addon ">
				<span class="glyphicon glyphicon-search">
				</span></span>
			</div>
		</div>

		<div class="col-md-6 pesq-tool">
			<div class="input-group">
				<input
				id='busca-ocorrencia-nome'
				name="pesquisa"
				type="text"
				class="form-control"
				placeholder = "Pesquisar ocorrência por nome">
				<span id = "btn-pesq-ocorrencia"
				onclick="buscaOcorrencia('nome')"
				class="input-group-addon ">
				<span class="glyphicon glyphicon-search">
				</span></span>
			</div>
		</div>
	</div>

	@if(count($ocorrencias) == 0)
			{{-- Esta jumbotron serve tanto para exibir que não há ocorrências, como para
				exibir resposta de busca que não teve sucesso ao encontrar resultados.
			 --}}
			<div class="jumbotron">
				@if( ! isset($modo))
					<h2>Está vazio por aqui.</h2>
					<p>Clique em cadastrar nova e comece a participar da rede.</p>
				
				 @else
				
					<h2>=/</h2>
					<p>Não conseguimos encontrar resultados para a busca...</p>
					<form class="" action="{{action('OcorrenciaController@minhasOcorrencias')}}" method="get">
						<button class = "btn btn-default" type="submit" name="button">voltar</button>
					</form>

				@endif
			</div>

	@else

		<div class = 'page-header' style='padding-top: 3ch;'>
			<h3>
				@if(! isset($modo ))
					As mais recentes
				@else
					Resultados para a busca por {{strtoupper($modo)}} de "{{$texto}}"
				@endif
			</h3>
		</div>

		<div class="col-md-12">
			<div class="text-center">
				{{ $ocorrencias->appends(Request::except('page'))->links() }}
			</div>
		</div>

		<div id = "loading" style="display: none; float:none; margin-top: 20px; margin-bottom: 20px;" 
		class = "col-sm-offset-3 col-md-6">
			<h3 id = 'wait-text' >Aguarde, estamos buscando as informações...</h3>
			<div id="progressbar"></div>
		</div>

		<table class = 'table table-bordered table-striped table-hover'>
			<tr class = 'info'>
				<th colspan = "2" class = 'text-center'>Empresa</th>
				<th class = 'text-center'>CNPJ</th>
				<th colspan = "2" class = 'text-center'>Contratante</th>
				<th class = 'text-center'>Data</th>
				<th colspan = "2" class = 'text-center'>ações</th>
			</tr>
		@foreach( $ocorrencias as $o )

			<tr class="">
				<td style="border-right: 0" class = 'text-center' > {{ $o->empresa->nome	or 'não informado' }}</td>

				<td class = 'text-center' style="border-left: 0">
					<a href='{{action("OcorrenciaController@lookInto", ["modo"=>"empresa","id" => $o->empresa->id, 'viewMode'=>'posts'])}}' >
						<span class="glyphicon glyphicon-search"></span>
					</a> 
					<span class = "division-actions"></span>
					<a href='#' onclick="event.preventDefault(); toggleSubscribe('{{$o->empresa->id}}', '1')" >
						@if($o->inscEmpresa)
							<span title="Clique aqui para desativar notificações desta empresa" class="glyphicon glyphicon-bell"></span>
						@else
							<span title="Clique aqui para ativar notificações desta empresa" class="glyphicon glyphicon-bell glyphicon-bordered"></span>
						@endif
					</a> 
				</td>

				<td class = 'text-center' > {{ $o->empresa->cnpj	or 'não informado' }}</td>
				<td style="border-right: 0" class = 'text-center' > {{ $o->contratante->nome	or 'não informado' }}</td>

				<td class = 'text-center' style="border-left: 0">
					<a href='{{action("OcorrenciaController@lookInto", ["modo"=>"contratante","id" => $o->contratante->id, 'viewMode'=>'posts'])}}' >
						<span class="glyphicon glyphicon-search"></span>
					</a> 
					<span class = "division-actions"></span>
					<a href='#' onclick="event.preventDefault(); toggleSubscribe('{{$o->contratante->id}}', '2')" >
						@if($o->inscContrat)
							<span title="Clique aqui para desativar notificações deste contratante" class="glyphicon glyphicon-bell"></span>
						@else
							<span title="Clique aqui para ativar notificações deste contratante" class="glyphicon glyphicon-bell glyphicon-bordered"></span>
						@endif
					</a> 
				</td>

				<td class = 'text-center' > {{ $o->data	or 'não informado' }}</td>

				<td width = '4%'class = 'text-center'>
					<a href="informações" 
						title = 'Mais informações...'
						onclick = "
							event.preventDefault();
              info({{$o->id}});
            "
					>
						<span class="glyphicon glyphicon-info-sign"></span>
					</a> 
				</td>
				<td width = '4%' class = 'text-center'>
					<a href='editar'
						title = 'Editar ocorrência'
						onclick = "
							event.preventDefault();
							editar({{$o->id}});
						" 
					>
						<span class="glyphicon glyphicon-cog"></span>
					</a>
				</td>
				
			</tr>

		@endforeach
		</table>
		<div class="col-md-12">
			<div class="text-center">
				{{ $ocorrencias->appends(Request::except('page'))->links() }}
			</div>
		</div>



	@endif

	
@endsection



@section('scripts')

	<!--JQUERTY-UI-->
	<link rel="stylesheet" href="{{asset('jquery-ui/jquery-ui.min.css')}}">
	<script src="{{asset('jquery-ui/external/jquery/jquery.js')}}"></script>
	<script src="{{asset('jquery-ui/jquery-ui.min.js')}}"></script>
	<!--JQUERY-UI-->

	<script src="{{asset('js/masks.js')}}" type="text/javascript"></script>
	<script type="text/javascript" src="{{asset('js/url.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/list-ocorrencia.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/toggle-subscribe.js')}}"></script>

@endsection


