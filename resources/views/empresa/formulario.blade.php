@extends('layout.principal')

@section('content')

	<h1>{{$modo}}	de empresa</h1>
	<!-- I couldn't figure out how the url redirecting works -->
	
	@if(count($errors) > 0)
		<div class = 'alert alert-danger'>
			<ul>
				@foreach( $errors->all() as $error )
					<li>{{	$error	}}</li>
				@endforeach
			</ul>	
		</div>
	@endif

	@if($empresa)
		<form method = 'post' action = '{{ url("/") }}/empresas/adiciona'> <!--It could be /sisco/public/empresas/adiciona-->
			<div	class="form-group">
				<label for='nome'>Nome</label>
				<input name='nome' class='form-control' value = '{{ $empresa->nome or "" }}'>				
			</div>
			<div	class="form-group">
				<label for='cnpj'>CNPJ</label>
				<input name='cnpj' class='form-control' value = '{{ $empresa->cnpj or "" }}'>
			</div>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="id" value="{{ $empresa->id }}">
			<button class='btn btn-default pull-right'	type="submit">Submit</button>
		</form>
	@else
		<form method = 'post' action = '{{ url("/") }}/empresas/adiciona'> <!--It could be /sisco/public/empresas/adiciona-->
			<div	class="form-group">
				<label for='nome'>Nome</label>
				<input name='nome' class='form-control' value = '{{old("nome")}}' >
			</div>
			<div	class="form-group">
				<label for='cnpj'>CNPJ</label>
				<input name='cnpj' class='form-control' value = '{{old("cnpj")}}' >
			</div>
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<button class='btn btn-default pull-right'	type="submit">Submit</button>
		</form>
	@endif

@stop
