<?php 

namespace	sisco\Http\Controllers;
use	Illuminate\Support\Facades\DB;
use Request;
use sisco\Http\Requests\EmpresaRequest;
use Validator;
use sisco\OrgaoInvestigador; //tem que ter o nome do app que foi escolhido via artisan

class OrgaoInvestigadorController extends Controller {

	// defines a middleware in order to garantee that only logged in users
	// can access this content
	
	public function __construct() {
		// $this->middleware('auth', ['only'=>['json']]);
	}

	public function json() {
		$orgaos	=	OrgaoInvestigador::all();

		// foreach ($orgaos as $orgao) {
		// 	$orgao->users;
		// }

		$responseCode = 200;
		$header = array(
			'Content-Type' => 'application/json; charset=UTF-8',
      		'charset' => 'utf-8'
    	);

    	$jsonOptions = JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;
     
		return response()->json($orgaos, $responseCode, $header, $jsonOptions);
	}


	// imagina-se que o número de órgãos não crescerá muito, já que
	// não são muitos os órgãos da rede de controle.
	public function nomesOrgaos() {
		$orgaos	=	OrgaoInvestigador::all();

		$saida = array();

		foreach ($orgaos as $orgao) {
			array_push($saida, $orgao->nome);
		}

		$responseCode = 200;
		$header = array(
			'Content-Type' => 'application/json; charset=UTF-8',
      'charset' => 'utf-8'
    );

    $jsonOptions = JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;

		return response()->json($saida, $responseCode, $header, $jsonOptions);
	}


}