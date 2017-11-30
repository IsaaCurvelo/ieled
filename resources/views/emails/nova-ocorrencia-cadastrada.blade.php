<!DOCTYPE html>

<html lang="pt">

<head>

	<meta charset="utf-8">

	<title id> Document</title>

</head>

<body>

	<h1>Uma nova ocorrência foi registrada, {{$usuario->name}}</h1>


	<p>
		
		O {{$quem}} cadastrou uma ocorrência de {{$oQue}} em {{$quando}}.

	</p>

	<a href="{{action('NotificacaoController@manageNotifications')}}">Dar uma olhada.</a>

	<p>
		
	Atenciosamente, equipe do IELED.
			
	</p>

	<small>Ministério Público do Maranhão.</small>



</body>

</html>