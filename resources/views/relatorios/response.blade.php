<style type="text/css">
	table{
		word-break: normal;
	}

</style>
@if (count($ocorrencias) > 0)

	<table class = 'table table-bordered' style="margin-top: 13px;">

		<tr style="background-color: #fff0b3">
			<th class = 'text-center'>Empresa</th>
			<th class = 'text-center'>CNPJ</th>
			<th class = 'text-center'>Contratante</th>
			<th class = 'text-center'>situação</th>
			<th class = 'text-center'>data</th>
			<th class = 'text-center'>área da contratação</th>
			<th class = 'text-center'>tipo da contratação</th>
			<th class = 'text-center'>valor</th>
			<th class = 'text-center'>fonte</th>

			<th class = 'text-center'>orgão investigador</th>
			<th class = 'text-center'>email</th>



		</tr>

		

			@foreach ($ocorrencias as $o)
			<tr>
					<td>{{$o->empresa->nome}}</td>
					<td class="text-center">{{$o->empresa->cnpj or '-'}}</td>
					<td>{{$o->contratante->nome}}</td>
					<td>{{$o->situacao->nome}}</td>
					<td>{{$o->data}}</td>
					<td class="text-center">{{$o->area_despesa->nome or '-'}}</td>
					<td class="text-center">{{$o->tipo_despesa->nome or '-'}}</td>
					<td class="text-center">{{$o->valor or '-'}}</td>
					<td class="text-center">{{$o->procedimento or '-'}}</td>

					<td>{{$o->user->orgao_investigador->nome}}</td>
					<td>{{$o->user->email}}</td>
				</tr>
			@endforeach

			<div id="qtd-items" style="display: none;">{{$total}}</div>

	</table>

@else

	<div class='jumbotron' style="margin-top: 13px;">
		<h1>:/</h1>
		<h3>Não encontramos registros com os filtros selecionados...</h3>
	</div>

@endif
