@extends('layout.principal')


@section('title')
	Nova Ocorrência
@endsection


@section('styles')
	<link rel="stylesheet" type="text/css" href="{{asset('css/custom/form-ocorrencia.css')}}">
@endsection


@section('content')
	<main class="container ">

	<div id="mensagem-modal"></div>

	<div class="page-header">
        <h1>Cadastro de Ocorrência </h1>
	</div>


	<form class="form" action="{{action('OcorrenciaController@insere')}}" method="post">

		<div class="col-md-6">
			<label for="nome-empresa">*Nome da empresa envolvida</label>
			<div class="input-group">
				<input id='nome-empresa' name="nome-empresa" type="text" class="form-control" required/>
				<span id = "btn-set-cnpj" onclick="buscaEmpresa()" class="input-group-addon "><span class="glyphicon glyphicon-search"></span></span>
			</div>
		</div>

		<div class="col-md-6">
			<label for="cnpj-empresa">*CNPJ da empresa envolvida</label>
			<input id='cnpj-empresa' name="cnpj-empresa" type="text" class="form-control"/>
		</div>


		<!--Tem que ser um select com todos os municipios do maranhão-->
		<div class="col-md-6">
			<label for="contratante_id">*Ente público contratante</label>
			<select id ="select1" name="contratante_id" class="form-control" onChange="validaSelect(1)" required>
				<option value = "-13">Selecione...</option>

				@foreach( $contratantes as $c )
					<option value="{{ $c->id }}"> {{ $c->nome }}</option>
				@endforeach

			</select>

		</div>

		<div class="col-md-6">
			<label for="situacao_id">*Situação</label>
			<select id="select2" name="situacao_id" class="form-control" onChange="validaSelect(4)" required>
				<option value = "-13">Selecione...</option>

				@foreach( $situacaos as $s )
					<option value="{{ $s->id }}"> {{ $s->nome }}</option>
				@endforeach

			</select>
		</div>


		<div class="col-md-4">
			<label for="tipo_despesa_id">Tipo da despesa  (facultativo)</label>
			<select id ="" name="tipo_despesa_id" class="form-control" onChange=""  >
				<option value = "-13">Selecione...</option>
				
				@foreach( $tipoDespesas as $t )
					<option value="{{ $t->id }}"> {{ $t->nome }}</option>
				@endforeach

			</select>
		</div>
		

		<div class="col-md-4">
			<label for="area_despesa_id">Área da despesa (facultativo)</label>
			<select id="" name="area_despesa_id" class="form-control" onChange="" >
				<option value = "-13">Selecione...</option>
				
				@foreach( $areaDespesas as $a )
					<option value="{{ $a->id }}"> {{ $a->nome }}</option>
				@endforeach

			</select>
		</div>



		<div class="col-md-4">
			<label for="valor">Valor (estimado, facultativo)</label>
			<div class="input-group">
				<span class="input-group-addon">R$</span>
				<input id="valor" type="text" class="form-control" name="valor" >
			</div>
		</div>



		<div class="col-md-12">
			<label for="procedimento">Fonte (facultativo)</label>
			<textarea id = "texto-fonte" rows="8" class="form-control" name="procedimento" maxlength="240"></textarea>
			<small id = "contador-caracteres" class = "pull-right" style="margin-top : 0.5ch">
				240 caractere(s) restante(s).
			</small>
		</div>

		
		<input type="hidden" name="data" id='data'  class="form-control">
		<input type="hidden" name="id-empresa" id='input-id-empresa'  class="form-control">

		{{ csrf_field() }}


		<button id = "submit-button" type="submit" name="button"
			class="btn btn-success pull-right">
      <span class="glyphicon glyphicon-open"></span>
      cadastrar
    </button>


	</form>


</main>
@endsection


@section('scripts')
	<!--JQUERTY-UI-->
	<link rel="stylesheet" href="{{asset('jquery-ui/jquery-ui.min.css')}}">
	<script src="{{asset('jquery-ui/external/jquery/jquery.js')}}"></script>
	<script src="{{asset('jquery-ui/jquery-ui.min.js')}}"></script>
	<!--JQUERY-UI-->

  	<script src="{{asset('js/masks.js')}}" type="text/javascript"></script>
	<script type="text/javascript" src="{{asset('js/url.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/form-ocorrencia.js')}}"></script>



@endsection