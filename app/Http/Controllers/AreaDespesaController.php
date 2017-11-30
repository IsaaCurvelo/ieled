<?php 

namespace	sisco\Http\Controllers;
use	Illuminate\Support\Facades\DB;
use Request;
use Auth;
use sisco\Http\Requests\OcorrenciaRequest;
use Validator;
use sisco\AreaDespesa; 

class AreaDespesaController extends Controller 
{

	public function __construct() 
	{
		$this->middleware('auth', ['only'=>['json']]);
	}

	public function json(){
		$areasDespesa = AreaDespesa::all();
		$responseCode = 200;
		$header = array(
			'Content-Type' => 'application/json; charset=UTF-8',
  			'charset' => 'utf-8'
		);

	  	$jsonOptions = JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;

		return response()->json($areasDespesa, $responseCode, $header, $jsonOptions);

	}
}