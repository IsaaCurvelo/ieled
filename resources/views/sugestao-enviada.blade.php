@extends('layout.principal')

@section('title') Sugestões @endsection


@section('content')
 
	<div class='jumbotron' style="margin-top: 30px">
		
		<h2>Sucesso! =)</h2>

		<p>
		
			Sua sugestão foi enviada com sucesso para os administradores do
			IELED. Garantimos que vamos ler com atenção e levá-las em consideração! 

		</p>


		<p>
			
			Caso queira voltar para a tela inicial é só clicar 
			<a href="{{action('HomeController@index')}}">aqui</a>.

		</p>


		<p>
			
			<small class='pull-right'>Atenciosamente, equipe do IELED.</small>
			
		</p>


	</div>
	
@endsection