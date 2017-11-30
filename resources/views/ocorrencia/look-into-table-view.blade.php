@extends('layout.principal')

@section('meta')
	<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
	{{$ocorrencias[0][$modo]->nome}} 
@endsection

@section('styles')
	<link rel="stylesheet" type="text/css" href="{{asset('css/custom/look-into.css')}}">
@endsection

@section('content')
	<main>

		<div id='modal'></div>
		
		<ul  class="nav nav-tabs">
			<h2 class="titulo-pagina">Contratações de {{$ocorrencias[0][$modo]->nome}}</h2>
			<li class="pull-right" ><a href="{{action("OcorrenciaController@lookInto", ["modo"=>$modo,"id" => $ocorrencias[0][$modo]->id, 'viewMode'=>'posts'])}}">Posts</a></li>
			<li class="pull-right active"><a href="#">Tabela</a></li>
		</ul>

		@if($modo == "empresa")
			<table style="margin-top: 20px" class = 'table table-bordered table-striped table-hover'>
				<tr style="background-color: #fff0b3">
					<th colspan = "2" class = 'text-center'>Contratante</th>
					<th class = 'text-center'>data</th>
					<th class = 'text-center'>investigador</th>
					<th class = 'text-center'>situação</th>
					<th class = 'text-center'>área da despesa</th>
					<th class = 'text-center'>tipo da despesa</th>
					<th class = 'text-center'>valor</th>
					<th class = 'text-center'>mais...</th>

				</tr>
			@foreach($ocorrencias as $o)
				<tr>
					<td style="border-right: none;">{{$o->contratante->nome}}</td>
					<td class = 'text-center' style="border-left: none;">
						<a href="{{action('OcorrenciaController@lookInto', ['modo' => $modoOposto, 'id'=> $o[$modoOposto]->id, 'viewMode'=>'table'])}}">
							<span class = 'glyphicon glyphicon-search'></span>
						</a>
					</td>
					<td class = 'text-center'>{{$o->data}}</td>
					<td>
						@if($o->user->id == Auth::user()->id)
							eu
						@else
							{{$o->user->nome}}
						@endif
						
					</td>
					<td class = '{{$bsClasses[$o->situacao->nome]}}'>{{$o->situacao->nome}}</td>

					<td>{{$o->area_despesa->nome or 'não informado'}}</td>
					<td>{{$o->tipo_despesa->nome or 'não informado'}}</td>
					<td>{{$o->valor or 'não informado'}}</td>

					<td class='text-center'>
						<a href='mais informações' onclick="event.preventDefault(); mais('{{$o->procedimento}}');" class = 'glyphicon glyphicon-plus'></a>
					</td>

				</tr>	
			@endforeach
			</table>

		@else
			<table style="margin-top: 20px" class = 'table table-bordered table-striped table-hover'>
			<tr style="background-color: #fff0b3">
				<th colspan = "2" class = 'text-center'>empresa</th>
				<th class = 'text-center'>cnpj</th>
				<th class = 'text-center'>data</th>
				<th class = 'text-center'>investigador</th>
				<th class = 'text-center'>situação</th>
				<th class = 'text-center'>tipo</th>
				<th class = 'text-center'>area</th>
				<th class = 'text-center'>valor</th>
				<th class = 'text-center'>mais...</th>
			</tr>
			@foreach($ocorrencias as $o)
				<tr>
					<td style="border-right:none;">{{$o->empresa->nome}}</td>
					<td class = 'text-center' style="border-left:none;">
						<a href='{{action('OcorrenciaController@lookInto', ['modo' => $modoOposto, 'id'=> $o[$modoOposto]->id, 'viewMode'=>'table'])}}'>
							<span class = 'glyphicon glyphicon-search'></span>
						</a>
					</td>
					<td class = 'text-center'>{{$o->empresa->cnpj or 'não informado'}}</td>
					<td class = 'text-center'>{{$o->data}}</td>

					<td class = 'text-center'>
						@if($o->user->id == Auth::user()->id)
							Eu
						@else							
							{{$o->user->orgao_investigador->nome}}
						@endif
					</td>

					<td class = '{{$bsClasses[$o->situacao->nome]}}'>
						{{$o->situacao->nome}}
					</td>
					<td class = 'text-center'>
						{{$o->tipo_despesa->nome or '-'}}
					</td>
					<td class = 'text-center'>
						{{$o->area_despesa->nome or '-'}}
					</td>
					<td class = 'text-center'>
						{{$o->valor or '-'}}
					</td>
			
					<td class='text-center'>
						<a href='mais informações' onclick="event.preventDefault(); mais('{{$o->procedimento}}');" class = 'glyphicon glyphicon-plus'></a>
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



	</main>
@endsection


@section('scripts')

	<!--JQUERTY-UI-->
	<link rel="stylesheet" href="{{asset('jquery-ui/jquery-ui.min.css')}}">
	<script src="{{asset('jquery-ui/external/jquery/jquery.js')}}"></script>
	<script src="{{asset('jquery-ui/jquery-ui.min.js')}}"></script>
	<!--JQUERY-UI-->

	<script type="text/javascript" src="{{asset('js/url.js')}}"></script>
	<script type="text/javascript" src="{{asset('js/look-into.js')}}"></script>

@endsection
