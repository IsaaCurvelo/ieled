@extends('layout.principal')
	
@section('title')
	ADM
@endsection

@section('styles')
	<link rel="stylesheet" href="{{asset('css/custom/dashboard-adm.css')}}" media="screen" title="no title" charset="utf-8">
	<link rel="stylesheet" href="{{asset('css/font-awesome.css')}}" media="screen" title="no title" charset="utf-8">

	<style type="text/css">
		.container {
			min-width: 310px;
			max-width: 800px;
			height: 400px;
			margin: 0 auto;
			margin-top: 13px;
			border-top: : 1px solid black;
		}

	</style>
@endsection

@section('content')

	
	<div id="container" class="container"></div>
	<div id="container2" class="container"></div>

@endsection


@section('scripts')
	<script src="{{asset('js/highcharts.js')}}"></script>

	<script type="text/javascript">
		Highcharts.chart('container', {
		chart: {
			type: 'line',
			zoomType: 'y'
		},
		title: {
			text: 'Histórico de Cadastro de Ocorrências (6 meses)'
		},
		xAxis: {
			categories: 
			[
				@foreach($history as $key => $value)
					'{{$key}}',
				@endforeach	
			]
		},
		yAxis: {
			allowDecimals: false,
			title: {
				text: 'número de ocorrências'
			},
			labels: {
				formatter: function() {
					return this.value;
				}
			}
		},
		series: [
			{
				name: 'Jairo',
				data: 
				[
					@foreach($historyJairo as $key => $value)
					{{$value}},
					@endforeach
				]
			},
					{
				name: 'Demais usuários',
				data: 
				[
					@foreach($history as $key => $value)
					{{$value}},
					@endforeach
				]
			}
		]
	});


	Highcharts.chart('container2', {
		chart: {
			type: 'line',
			zoomType: 'y'
		},
		title: {
			text: 'Número de Ocorrências (6 meses)'
		},
		xAxis: {
			categories: 
			[
				@foreach($history2 as $key => $value)
				'{{$key}}',
				@endforeach	
			]
		},
		yAxis: {
			allowDecimals: false,
			title: {
				text: 'número de ocorrências'
			},
			labels: {
				formatter: function() {
					return this.value;
				}
			}
		},
		series: [
			{
				name: 'Jairo',
				data: 
				[
					@foreach($historyJairo2 as $key => $value)
					{{$value}},
					@endforeach
				]
			},
					{
				name: 'Demais usuários',
				data: 
				[
					@foreach($history2 as $key => $value)
					{{$value}},
					@endforeach
				]
			}
		]
	});

	</script>
@endsection