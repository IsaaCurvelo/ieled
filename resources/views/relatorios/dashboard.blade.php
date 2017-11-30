@extends('layout.principal')

@section('meta')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
relatórios
@endsection

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{asset('css/custom/dashboard-relatorios.css')}}">
@endsection


@section('content')
	<!-- Sidebar -->
	<div id="sidebar-wrapper">
		<ul class="sidebar-nav">
			<li class="sidebar-brand">
				<h3> Relatórios	</h3>
			</li>
			{{-- <li>
				<h3>pré-prontos:</h3>
			</li>
			<li>
				<ul>
					<li><a href="">Municípios com mais empresas fraudulentas</a></li>
					<li><a href="">Empresas com mais contratos no estado</a></li>
					<li><a href="">Valor total (R$) de contratos fraudulentos</a></li>
					<li><a href="">relatório 4</a></li>					
				</ul>
			</li>
 			<div class="horizontal-separator"></div>
			<li>
				
				<h3>montar filtros do relatório:</h3>

			</li> --}}
			<li>
				situação da empresa:
			</li>
			<li>
				@for ($i = floor(count($situacaos)/2 -1); $i >=0 ; $i--)
					<a idsit="{{$situacaos[$i]->id}}"
					class="unselected btn btn-{{$bsClasses[$situacaos[$i]->nome]}} sidebar-button " href="" 
					onclick="event.preventDefault(); pressFilter(this)">{{$situacaos[$i]->nome}}</a>
				@endfor
			</li>
			<li>
				@for ($i = floor(count($situacaos)/2); $i < count($situacaos); $i++)
					<a idsit="{{$situacaos[$i]->id}}" 
					class="unselected btn btn-{{$bsClasses[$situacaos[$i]->nome]}} sidebar-button " href="" 
					onclick="event.preventDefault(); pressFilter(this)">{{$situacaos[$i]->nome}}</a>
				@endfor
			</li>

			<li>
				município:
			</li>

			<li>
				<select class="form-control sidebar-form" id="select">
					<option value='-13'>selecione...</option>
					@foreach( $contratantes as $contratante )
						<option value="{{$contratante->id}}"> {{$contratante->nome}}</option>
					@endforeach
				</select>
			</li>

			<li>
				<p style="display: inline-block; width: 45%; text-indent: 0; margin: 0;">a partir de:</p>
				<p style="display: inline-block; width: 40%; text-indent: 0; margin: 0;">até:</p>
			</li>
			
			<li>
				<input type="text" name="data-inicio" class="form-control" id="data-inicio" 
				style="display: inline-block; width: 45%">

				<input type="text" name="data-fim" class="form-control" id="data-fim"
				style="display: inline-block; width: 45%">
			</li>

			<li>
				<button class="btn btn-primary" onclick="submitFilters();" style="margin-bottom: 13px;">
					<span class="glyphicon glyphicon-filter"></span>
					filtrar 
				</button>
			</li>
			
		</ul>
	</div>
	<!-- /#sidebar-wrapper -->

	<!-- Page Content -->
	<div id="page-content-wrapper">
		<div class="container-fluid">
			<div class="row">

				<div class="col-lg-12" id='actions'>
					<a href="#menu-toggle" class="btn btn-default" id="menu-toggle"> 
						<span id ="chevron2" class="glyphicon glyphicon-chevron-left" ></span>
						esconder
					</a>

					<ol id="breadcrumbs" class="breadcrumb" style="display: inline-block; display: none;">
						<li style="color: #337ab7" id="breadcrumb-qtd">Foram encontrados 1453 registros</li>
						<li style="color: #337ab7">exibindo apenas os mais recentes</li>
					</ol>

					<form id="form-export" 
					style="display: none;" onsubmit="exportCSV(this);" method="POST"
					action="{{action('RelatorioController@exportarCSV')}}">
						{{csrf_field()}}
					</form>

					<button id="btn-export" form="form-export" class='btn btn-success' style="float: right; display: none;">
						<span class="glyphicon glyphicon-export"></span>
						exportar todos
					</button>
				</div>
				<div style="color: black;" class="col-md-12">

						<div id = "loading" style="display: none; float:none; margin-top: 20px; margin-bottom: 20px;" class = "col-sm-offset-2 col-md-8">
							<h3 id = 'wait-text' >Aguarde, estamos procurando resultados...</h3>
							<div id="progressbar"></div>
						</div>


						<div id="content">

							{{-- the content to be displayed --}}

						</div>

				</div>

			</div>
		</div>
	</div>
	<!-- /#page-content-wrapper -->

@endsection


@section('scripts')

	<!--JQUERTY-UI-->
	<link rel="stylesheet" href="{{asset('jquery-ui/jquery-ui.min.css')}}">
	<script src="{{asset('jquery-ui/external/jquery/jquery.js')}}"></script>
	<script src="{{asset('jquery-ui/jquery-ui.min.js')}}"></script>
	<!--JQUERY-UI-->

	<script src="{{asset('js/masks.js')}}" type="text/javascript"></script>
	<script type="text/javascript" src="{{asset('js/url.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/relatorios-dashboard.js')}}"></script>

@endsection