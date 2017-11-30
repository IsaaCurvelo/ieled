@extends('layout.principal')
	
@section('title')
	Sobre
@endsection

@section('styles')
	<link rel="stylesheet" href="{{asset('css/custom/home.css')}}" media="screen" title="no title" charset="utf-8">
@endsection

@section('content')

	<div class="jumbotron" style="margin-top: 25px;">
		<h3>Sobre o IELED</h3>
		<p>
			O Ieled é um sistema para troca de informações entre interessados da rede de controle... tarará
		</p>
		<p>
			Ieled significa criança e é um pedra, algo próximo a uma bola de cristal.
		</p>


		<p>
			Desenvolvido no Ministério Público do Tribunal de Contas do Estado do Maranhão, este sistema tem 
			o intuito de ajudar nas investigações de contratações de todo o estado, evitando esforços duplicados  e facilitando a troca de informações.
		</p>

		<figure class="text-center">
			<img src="{{ asset('images/logo.png') }}">
		</figure>

	</div>

@endsection