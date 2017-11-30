@extends('layout.principal')
	
@section('title')
	ADM
@endsection

@section('styles')
	<link rel="stylesheet" href="{{asset('css/custom/dashboard-adm.css')}}" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="{{asset('css/font-awesome.css')}}" media="screen" title="no title" charset="utf-8">
@endsection

@section('content')
	<div class="col-md-10 col-md-offset-1">
		<div class="row" style="margin-top: 15px;">
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-primary">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa  fa-users  fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge">{{$numUsers}}</div>
								<div>Usuários</div>
							</div>
						</div>
					</div>
					<a href="{{action('AdmController@gerenciarUsuarios')}}">
						<div class="panel-footer">
							<span class="pull-left">Ver Detalhes</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-green">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-building-o fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge">{{$numEmpresas}}</div>
								<div>Empresas</div>
							</div>
						</div>
					</div>
					<a href="{{action('EmpresaController@lista')}}">
						<div class="panel-footer">
							<span class="pull-left">Gerenciar</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			
			<div class="col-lg-3 col-md-6">
				<div class="panel panel-red">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-list-alt fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge">{{$numOcorrencias}}</div>
								<div>Ocorrências</div>
							</div>
						</div>
					</div>
					<a href="{{action('AdmController@gerenciarOcorrencias')}}">
						<div class="panel-footer">
							<span class="pull-left">Estatísticas</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>

			<div class="col-lg-3 col-md-6">
				<div class="panel panel-yellow">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-3">
								<i class="fa fa-map-o fa-5x"></i>
							</div>
							<div class="col-xs-9 text-right">
								<div class="huge">{{$numContratantes}}</div>
								<div>Municípios</div>
							</div>
						</div>
					</div>
					<a href="#">
						<div class="panel-footer">
							<span class="pull-left">Gerenciar</span>
							<span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
							<div class="clearfix"></div>
						</div>
					</a>
				</div>
			</div>
			
		</div>

	</div>

	<div class="col-md-8 col-md-offset-2">
		<div id="map" style="height: 60%"></div>
	</div>
@endsection


@section('scripts')
	<script>
			var map;
			function initMap() {
				map = new google.maps.Map(document.getElementById('map'), {
					center: {lat: -5.6911595, lng: -44.7001071},
					zoom: 6
				});
			}
		</script>
		<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDr6Z6aUBvwh1-lmxYgd5CFuYDS-vKEIcs&callback=initMap"
		async defer></script>

@endsection
