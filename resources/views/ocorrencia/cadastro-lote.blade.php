@extends('layout.principal')


@section('title')
	Cadastro de ocorrências em lote
@endsection


@section('styles')

	<style>
		#progressbar .ui-progressbar-value {
			background-color: green;
		}
	</style>
@endsection


@section('content')
	
	
	<div class="text-center row" style="margin-bottom: 13px; margin-top: 13px;">
		<div id = 'actions-bar' class='btn-group'>
			<a class = 'btn btn-primary' href="{{asset('storage/template_contratações_sisco.xlsx')}}"
			title="Baixar planilha modelo para preenchimento das contratações">
				<span class = 'glyphicon glyphicon-file'></span>&nbsp baixar template
			</a>
			<a class = 'btn btn-primary' onclick='event.preventDefault();' data-toggle="collapse" data-target="#form-lote" 
			title="fazer upload de planilha já preenchida para cadastrar no IELED">
				<span class = 'glyphicon glyphicon-folder-open'></span> &nbsp subir planilha
			</a>
		</div>
	</div>
	
	<div id='form-lote' class='collapse'>
		<form id = 'form' method="POST" action = '{{action("OcorrenciaController@insereEmLote")}}' class="form-inline" enctype="multipart/form-data">
			
			<label for="exampleInputFile">Planilha</label>
			<input type="file" name='planilha' required>
			<p class="help-block">Procure em seu computador a planilha que será carregada para o IELED</p>

			{{csrf_field()}}
			<button class ="btn btn-success" type="submit"><span class="glyphicon glyphicon-send"></span> OK</button>
		</form>
	</div>

	<div id = "loading" style="display: none; float:none; margin-top: 20px; margin-bottom: 20px;" class = "col-sm-offset-3 col-md-6">
		<h3 id = 'wait-text' >Aguarde, estamos processando a planilha...</h3>
		<div id="progressbar"></div>
	</div>

	<div class = 'jumbotron'>
		<h3>Passos para cadastro de ocorrências em lote:</h3>
		<ol style="font-size: 120%">
			<li>Clicar em "baixar template" para realizar download da planilha modelo de contratações.</li>
			<li>Preencher a planilha sem deixar linhas vazias pelo meio.</li>
			<li>Salvar no formato .xlsx .</li>
			<li>Clicar em "subir planilha". </li>
			<li>Quando a janela abrir, selecionar o arquivo que foi preenchido.</li>
			<li>Seguir instruções posteriores no caso de haver erros.</li>
		</ol>
	</div>
@endsection


@section('scripts')
	
	<!--JQUERTY-UI-->
	<link rel="stylesheet" href="{{asset('jquery-ui/jquery-ui.min.css')}}">
	<script src="{{asset('jquery-ui/external/jquery/jquery.js')}}"></script>
	<script src="{{asset('jquery-ui/jquery-ui.min.js')}}"></script>
	<!--JQUERY-UI-->

	<script type="text/javascript" src="{{asset('js/cadastro-lote.js')}}"></script>

@endsection