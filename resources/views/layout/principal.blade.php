<html>
<head>
	<meta charset = "UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	@yield('meta')
	<title>IELED - @yield('title')</title>


	<link rel="icon" href="{{asset('images/icon.png')}}" type="image/x-icon" />
	<link rel="shortcut icon" href="{{asset('images/icon.png')}}" type="image/x-icon" />

	<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">

	<link rel="stylesheet" href="{{asset('css/custom/master.css')}}">
	
	@yield('styles')

	<script src="{{asset('js/jquery-2.1.4.min.js')}}" charset="utf-8"></script>
	<script src="{{asset('js/bootstrap.min.js')}}" charset="utf-8"></script>
</head>

<body>

	<nav class="navbar navbar-default navbar-fixed-top">
	  <div class="container-fluid">
	    <!-- Brand and toggle get grouped for better mobile display -->
	    <div class="navbar-header">
	      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
	        <span class="sr-only">Toggle navigation</span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	      </button>
	      <a class="navbar-brand" href="{{url('/')}}">
	        <span class="glyphicon glyphicon-chevron-left"></span>
	        IELED
	        <span class="glyphicon glyphicon-chevron-right"></span>
	      </a>
	    </div>

	    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	      <ul class="nav navbar-nav">

	      	<div class="vertical-separator"></div>

	        <li id="time-line-nav"><a href="{{action('TimeLineController@timeline')}}"><span class = "glyphicon glyphicon-time"></span> todas ocorrências</a></li>

	        <div class="vertical-separator"></div>

	        @if (!Auth::guest())
	        <li><a href="{{action('OcorrenciaController@minhasOcorrencias')}}">
	        <span class="glyphicon glyphicon-list-alt"></span>
	        	minhas ocorrências<span class="sr-only">(current)</span></a></li>
	        @endif

	        @if (!Auth::guest())
	        <div class="vertical-separator"></div>
	        <li>
	        	<a href="{{action('RelatorioController@index')}}"><span class="glyphicon glyphicon-paste"></span> relatórios IELED</a>
	        </li>
	        @endif
	        <div class="vertical-separator"></div>


	        @yield('navbar-item')
	      </ul>

	      <ul class="nav navbar-nav navbar-right">
	        <li><a href="/sobre">Sobre</a></li>
	        <li class="dropdown">
	          <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Conta <span class="caret"></span></a>
	          <ul class="dropdown-menu">

	            @if (!Auth::guest())

		            <li>
		              <a>
		                <span class="glyphicon glyphicon-user"></span>
		                {{ Auth::user()->name }}
		              </a>
		            </li>
		            <li><a href="{{action('ConfiguracoesController@index')}}"><span class = "glyphicon glyphicon-cog"></span> Configurações</a></li>
		            <li role="separator" class="divider"></li>
		            <li>
		            	<a href="{{ url('/logout') }}"
                      onclick="event.preventDefault();
                             		document.getElementById('logout-form').submit();"
                 		>
                 		<span class = 'glyphicon glyphicon-off'></span>
                      sair
                  </a>

                  <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                  </form>
		            </li>
	           
	            @else
	              
	              <li>
	                <a href="{{ url('/login') }}">
	                  <span class="glyphicon glyphicon-user"></span>
	                  entrar
	                </a>
	              </li>
	              <li>
	                <a href="{{ url('/register') }}">
	                  <span class="glyphicon glyphicon-copy"></span>
	                  criar conta
	                </a>
	              </li>

	            @endif

	          </ul>
	        </li>
	      </ul>
	    </div><!-- /.navbar-collapse -->
	  </div><!-- /.container-fluid -->
	</nav>


	<div id = 'wrapper' class = 'container' style = 'padding-bottom: 13ch; margin-top:50px'>
		@yield('content')
	</div>

<!--
	<footer class="footer">
      <p class="text-center texto-footer">
        IELED - Controle de contratações do Estado do Maranhão
        <br>
        <b>&copy Tribunal de Contas do Estado do Maranhão, 2016.</b>
      </p>
  </footer>
-->
  @yield('scripts')
</body>
</html>