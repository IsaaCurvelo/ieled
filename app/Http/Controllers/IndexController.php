<?php 
namespace	sisco\Http\Controllers;
use	Illuminate\Support\Facades\DB;
use	Illuminate\Support\Facades\Mail;
use Request;
use Auth;

use sisco\OrgaoInvestigador; 
use sisco\Mail\NovaSugestao; 



class IndexController extends Controller 

{

	public function sugestoesSisco()
	
	{
	
		$sender = Request::input('email');
	
		$text = Request::input('mensagem');

		// ENVIAR EMAIL PARA O ADM DO SISTEMA

		Mail::to("jcvieira@tce.ma.gov.br")->send(new NovaSugestao($sender, $text));
		
		Mail::to("isaacfrancis-cm@hotmail.com")->send(new NovaSugestao($sender, $text));

		return view('sugestao-enviada');
	}

	public function orgaosParticipantes()
	{

		$orgaos = OrgaoInvestigador::all();
		return view('orgaos-participantes', compact('orgaos'));
	}


}