<?php 

namespace	sisco\Http\Controllers;
use	Illuminate\Support\Facades\DB;
use	Illuminate\Support\Facades\Hash;
use Request;
use Auth;
use sisco\Http\Requests\OcorrenciaRequest;
use Validator;

use \sisco\User;
use \sisco\Empresa;
use \sisco\Contratante;
use \sisco\Ocorrencia;

use sisco\Libs\GetLastMonths;


class AdmController extends Controller 
{
	// js api key Google-Maps
	//  AIzaSyDr6Z6aUBvwh1-lmxYgd5CFuYDS-vKEIcs 

	public function __construct() 
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$numUsers = User::where('is_adm', false)->count();
		$numOcorrencias = Ocorrencia::count();
		$numEmpresas = Empresa::count();
		$numContratantes = Contratante::count();

		return view('adm.dashboard', compact("numUsers","numOcorrencias","numEmpresas", "numContratantes"));
	}


	public function gerenciarUsuarios()
	{
		
		$months = GetLastMonths::last(6);

		foreach ($months as $key => $value)
		{
			$history[$value] = User::whereMonth('created_at', $key)->count();
		}

		$months = GetLastMonths::lastWithYear(6);

		foreach ($months as $key => $value)
		{
			$history2[$value[0]] = User::whereDate('created_at', '<=', $value[1])->count();
		}


		return view('adm.gerenciar-usuario', compact('history', 'history2'));
	}


	public function gerenciarOcorrencias()
	{
		
		$months = GetLastMonths::last(6);

		foreach ($months as $key => $value)
		{
			$history[$value] = Ocorrencia::whereMonth('data', $key)->where("user_id", "!=", 2)->count();
			$historyJairo[$value] = Ocorrencia::whereMonth('data', $key)->where("user_id", 2)->count();
		}

		$months = GetLastMonths::lastWithYear(6);
		
		foreach ($months as $key => $value)
		{
			$history2[$value[0]] = Ocorrencia::whereDate('data', '<=', $value[1])->where("user_id", "!=", 2)->count();
			$historyJairo2[$value[0]] = Ocorrencia::whereDate('data', '<=', $value[1])->where("user_id", 2)->count();
		}


		return view('adm.gerenciar-ocorrencia', compact('history', 'history2', 'historyJairo2', 'historyJairo'));
	}

}
