@extends ('layout.principal')

@section('title')
Empresas
@stop

@section('content')
<h1>Listagem	de	empresas 
	<a href='{{action("EmpresaController@novo")}}' class="pull-right">
		<span class="glyphicon glyphicon-plus"></span>
		Nova
	</a>
</h1>


@if(old('modo') == 'deletada')
<div class = 'alert alert-success'>
	A empresa foi deletada com sucesso.
</div>
@elseif(old('modo') != null)
<div class = 'alert alert-success'>
	A empresa <strong>{{old('nome')}}</strong>, de cnpj {{old('cnpj')}}  foi {{old('modo')}} com sucesso
</div>
@endif

<!-- Best approach is to verify if return is empty, because it is a Laravel Collection -->

@if( $empresas->isEmpty() )
<div	class="alert	alert-danger">
		Você	não	tem	nenhum	produto	cadastrado.
</div>

@else
<table class = 'table table-bordered table-striped table-hover'>
	<tr class = 'success'>
		<th class = 'text-center'>nome</th>
		<th class = 'text-center'>cnpj</th>
		<th colspan = "3" class = 'text-center'>ações</th>
	</tr>

	@foreach( $empresas as $e )
	<tr class="">
		<td class = 'text-center' > {{ $e->nome	or 'não informado' }}</td>
		<td class = 'text-center' > {{ $e->cnpj	or 'não informado' }}</td>
		<td width = '4%'class = 'text-center'>
			<a href='{{action("EmpresaController@mostra", ["id" => $e->id])}}' >
				<span class="glyphicon glyphicon-search"></span>
			</a> 
		</td>
		<td width = '4%' class = 'text-center'>
			<a href='{{action("EmpresaController@altera", ["id" => $e->id])}}' >
				<span class="glyphicon glyphicon-pencil"></span>
			</a>
		</td>
		<td width = '4%' class = 'text-center'>
			<a href='{{action("EmpresaController@remove", ["id" => $e->id])}}' >
				<span class="glyphicon glyphicon-trash"></span>
			</a>
		</td>
	</tr>
	@endforeach
</table>


<div class="col-md-12">
	<div class="text-center">
		{{ $empresas->appends(Request::except('page'))->links() }}
	</div>
</div>


@endif

@stop


@section('scripts')

	<!--JQUERTY-UI-->
	<link rel="stylesheet" href="{{asset('jquery-ui/jquery-ui.min.css')}}">
	<script src="{{asset('jquery-ui/external/jquery/jquery.js')}}"></script>
	<script src="{{asset('jquery-ui/jquery-ui.min.js')}}"></script>
	<!--JQUERY-UI-->

  	<script src="{{asset('js/masks.js')}}" type="text/javascript"></script>
	<script type="text/javascript" src="{{asset('js/url.js')}}"></script>

@endsection