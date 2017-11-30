@extends('layout.principal')


@section('title')
	Linhas com erros
@endsection


@section('content')

	<div class='page-header'>
		<h1>Problemas no cadastro em lote   :/ </h1>
	</div>
	
		<div class='jumbotron'>
			<h2>
				Instruções
			</h2>
		
			@if (count($rowsWithError) != $numRows)

				<p>Cadastro bem sucedido, mas com algumas ressalvas.</p>

			@else

				<p>Não foi possível realizar o cadastro, todas as linhas da planiha continham erros.</p>

			@endif


			<p>Mas não se preocupe, abaixo (em vermelho) está uma lista de todos os erros encontrados na tentativa de cadastro em lote.</p>

			@if (count($rowsWithError) != $numRows)

				<p>Todas as outras linhas não citadas abaixo foram cadastradas com sucesso, então você pode cadastrar manualmente <a href="{{action('OcorrenciaController@novo')}}"> aqui </a> apenas as que apresentaram erros, caso tenham sido poucas, ou então seguir os seguintes passos:
				</p>

			@else

				<p>Realize os seguintes passos, se aplicável:</p>

			@endif
			<ol style="font-size: 120%">

				<li>Deletar todas as linhas que não aparecem na lista abaixo na planilha, pois já foram cadastradas</li>

				<li>Corrigir os erros por linha da planilha que ficaram</li>
				
				<li>Tentar o cadastro em lote novamente <a href="{{action('OcorrenciaController@cadastroLote')}}">aqui</a></li>
			
			</ol>

			<ul style="font-size: 120%">
				
				@foreach( $rowsWithError as $row )
				
					<li style="font-weight: bold">
				
						linha {{$row[0]}}:
				
							<ol>
				
								@foreach( $row[1] as $error)
				
									<li style="color: red; font-weight: normal;">
				
										{{$error}}
				
									</li>
				
								@endforeach
				
							</ol>
				
					</li>
				
				@endforeach
			
			</ul>
		
		</div>

@endsection

