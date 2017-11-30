@extends('layout.principal')
	
@section('title')
	Home
@endsection

@section('styles')
	<link rel="stylesheet" href="{{asset('css/custom/home.css')}}" media="screen" title="no title" charset="utf-8">

	<style type="text/css">
		
		.grid2-item {
			margin:10px;
			float: left;
			height: 
		}

		.grid2-item-1 { width:  180px; margin: 3px;}


		#grid-item-opt {
			height: 230px;
			background-color: #373a3c;
			color: white;
			border: 1px solid black;
		}

	</style>
@endsection

@section('content')
	<main class="container" >
			{{-- se o usuários estiver logado: --}}
			@if (!Auth::guest())
				<div class = "grid">

					<div id = "grid-item-opt" class = "grid-item grid-item-inverted grid-item-2-5">
						<div class="panel-body">
							<h3>Bem vindo!</h3>
							<p class="text-card">
								Olá, {{ Auth::user()->name }}.
							</p>
							<p>
								Bem vindo ao IELED novamente.
							</p>

							<div class="grid2">
								<a href="{{action('OcorrenciaController@minhasOcorrencias')}}" class="btn btn-warning grid2-item-1">
									<span class="glyphicon glyphicon-list-alt" ></span>
									Minhas ocorrências
								</a>
								<a href="{{action('ConfiguracoesController@index')}}" class="btn btn-info grid2-item-1">
									<span class="glyphicon glyphicon-cog" ></span>
									Configurações
								</a>
								@if(Auth::user()->is_adm)
									<a href="{{action('AdmController@index')}}" class="btn btn-success grid2-item-1" >Painel administrador</a>
								@else
									<div class="grid2-item-1">
										
									</div>
								@endif
								<div class=" grid2-item-1" style="display: inline-block;">

									<a id = "btn-sair " 
										href="{{ url('/logout') }}" 
										style="margin-left: 110px;" 
										class="btn btn-danger "
										onclick="event.preventDefault();
															document.getElementById('logout-form').submit();"
									>
										<span class="glyphicon glyphicon-log-out" ></span>
										Sair
									</a>
								</div>
							</div>
							<form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
						</div>
					</div>	


					<div class="grid-item grid-item-3-5">
						<div class = "panel panel-default" style="border:none; margin-bottom: 0">
							<div class="panel-heading">
								<h3 style="margin:0;">
									<span class = "glyphicon glyphicon-bell"></span>
									 Notificações
										
											<a href="{{action('NotificacaoController@manageNotifications')}}" style="color: white" 
											title="ver todas"
											>
												<span class = "badge badge-danger pull-right">
													{{ $totalNotifications }}
												</span>
										 		
									 		</a>
									 
								 </h3>
							 </div>

							<div class="panel-body">
									@if (sizeof($notifications) > 0)
										<ul>
										@foreach( $notifications as $n )
											<a 
											href="{{action('NotificacaoController@manageNotifications')}}"
											style="color:black;">
												<li>{{$n->texto}}</li>
											</a>
										@endforeach
										</ul>
									@else
										Não tem nenhuma novidade por aqui...
									@endif
							</div>							
						</div>
					</div>

					<div class="grid-item">
						<div class="panel-body">
							<h3>Quem está dentro?</h3>
							<p class="text-card">
								Quer saber quais os órgãos da rede de controle estão utilizando o IELED?
							</p>
							<a  href = '{{action("IndexController@orgaosParticipantes")}}'
									class="btn btn-success "
							>
								<span class = "glyphicon glyphicon-info-sign"></span>
								Descobrir
							</a>
						</div>
					</div>


					<div class="grid-item grid-item-2-5">
						<div class="panel panel-default" style="border:none; margin-bottom: 0;">
						<div class="panel-heading">
							Quer deixar-nos uma sugestão ou mensagem?
						</div>

						<div class="panel-body">
							<h3 class="text-center" style="margin-bottom: 1ch">
								Estamos ouvindo...
							</h3>
							<form id ="form-sugestao" class="card-content" action="{{action('IndexController@sugestoesSisco')}}" method="post">

								<input type="hidden" name="email" value="{{Auth::user()->email}}" required>
								{{csrf_field()}}

								<label for="email">mensagem</label>

								<textarea class = "form-control" name="mensagem" rows="8" required></textarea>

							</form>
						</div>
						<div class="panel-footer">
							<button form="form-sugestao" type="submit" name="button" class="btn btn-primary ">
								<span class="glyphicon glyphicon-send"> </span>
								Enviar
							</button>
						</div>
					</div>
					</div>

					<div class="grid-item grid-item-inverted grid-item-3">
						<div class="panel-body">
							<h3>Acompanhe ainda melhor as investigações</h3>
							<p class="text-card">
								<b>Com a funcionalidade de relatórios do IELED é possível:</b>
							</p>
							<ul>
								<li>Descobrir quantas ocorrências foram registradas para uma mesma empresa ao longo do tempo; </li>
								<li>Quais municípios estão tendo maior quantidade de  contratos fraudulentos; </li>
								<li>Fazer consultas personalizadas e ainda exportar os dados para CSV; </li>
							</ul>

						</div>
					</div>

					<div class="grid-item grid-item-2" >
						<div class="panel-body">
							<p class="text-card">
								Veja tudo o que os usuários da rede IELED estão postando agora.
							</p>
							<a href="#" class = 'btn btn-info'>Posts</a>
						</div>
					</div>

				</div>



			@else {{--    USUÁRIO NÃO LOGADO:    --}}



				<div class = 'grid'>
						
				<div class="grid-item grid-item-inverted grid-item-3 ">
					<div class="panel-body">
						<h3>Faça login / registro</h3>
						<p class="text-card">
							Para poder participar do IELED e colaborar com as investigações
							é necessário que o (a) identifiquemos. Por favor, realize o login
							ou o seu registro.
						</p>
						<a href="{{ url('/login') }}" class="btn btn-primary ">
							<span class="glyphicon glyphicon-user" ></span>
							 login | registro
						</a>
					</div>
				</div>

				<div class = 'grid-item grid-item-2-5'>
					<div class="panel panel-default" style="border:none; margin-bottom: 0">
						<div class="panel-heading">
							<h3 style="margin:0;">
								<span class = "glyphicon glyphicon-bell"></span>
								 Notificações
							 </h3>
						 </div>
						<div class="panel-body">
							Precisamos que você se identifique para que possamos exibir o que há de
							novidades na sua conta do IELED. =)
						</div>
					</div>
				</div>

				<div class="grid-item">
					<div class="panel-body">
						<h3>Quem está dentro?</h3>
						<p class="text-card">
							Quer saber quais os órgãos da rede de controle estão utilizando o IELED?
						</p>
						<a  class="btn btn-success " href='{{action("IndexController@orgaosParticipantes")}}'>
							<span class = "glyphicon glyphicon-info-sign"></span>
							Descobrir
						</a>
					</div>
				</div>

				<div class="grid-item grid-item-2-5">
					<div class="panel panel-default" style="border:none; margin-bottom: 0;">
						<div class="panel-heading">
							Quer deixar-nos uma sugestão ou mensagem?
						</div>
						<div class="panel-body">
							<h3 class="text-center" style="margin-bottom: 1ch">
								Estamos ouvindo...
							</h3>
							<form id ="form-sugestao" class="card-content" action="{{action('IndexController@sugestoesSisco')}} method="post">
								<label for="email">email</label>
								<input class = "form-control" type="email" name="email" value="" required>
								<label for="email">mensagem</label>
								<textarea class = "form-control" name="mensagem" rows="5" required></textarea>
							</form>
						</div>
						<div class="panel-footer">
							<button form="form-sugestao" type="submit" name="button" class="btn btn-primary ">
								<span class="glyphicon glyphicon-send"> </span>
								Enviar
							</button>
						</div>
					</div>
				</div>

				<div class="grid-item grid-item-inverted grid-item-3">
					<div class="panel-body">
						<h3>Acompanhe ainda melhor as investigações</h3>
						<p class="text-card">
							<b>Com a funcionalidade de relatórios do IELED é possível:</b>
						</p>
						<ul>
							<li>Descobrir quantas ocorrências foram registradas para uma mesma empresa ao longo do tempo; </li>
							<li>Quais municípios estão tendo maior quantidade de  contratos fraudulentos; </li>
							<li>Fazer consultas personalizadas e ainda exportar os dados para CSV;</li>
						</ul>
					</div>
				</div>

				</div>
			@endif


{{-- 				<div class="col-md-12">

					<div class="page-header">
						<h3>Notícias</h3>
					</div>
					<div class="panel panel-default">
						<div class="panel-body">
							<h3>Sempre é possível </h3>
							<p class="text-card">
								É um fato conhecido de todos que um leitor se distrairá com o conteúdo
								de texto legível de uma página quando estiver examinando sua
								diagramação. A vantagem de usar Lorem Ipsum é que ele tem uma
								distribuição normal de letras.
							</p>
						</div>
					</div>

					<div class="panel panel-default">
						<div class="panel-body">
							<h3>De onde ele vem? </h3>
							<p class = "text-card">
								Ao contrário do que se acredita, Lorem Ipsum não é simplesmente um
								texto randômico. Com mais de 2000 anos, suas raízes podem ser
								encontradas em uma obra de literatura latina clássica datada de 45 AC.
								Richard McClintock, um professor de latim do Ham
							</p>
						</div>
					</div>
		
				</div> --}}

		</main>


@endsection









@section('scripts')
	<script type="text/javascript" src="{{asset('js/masonry.min.js')}}"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			$('.grid').masonry({
				itemSelector: '.grid-item',
				columnWidth: 160
			});

			$('.grid2').masonry({
				itemSelector: '.grid2-item',
				columnWidth: 50
			});
		});
	</script>

@endsection
