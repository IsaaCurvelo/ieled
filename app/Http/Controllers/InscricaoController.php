<?php 

namespace	sisco\Http\Controllers;
use	Illuminate\Support\Facades\DB;
use Auth;
use Request;
use sisco\Contratante;
use sisco\Empresa;
use sisco\User;
use sisco\Inscricao;

class InscricaoController extends Controller 
{

	public function __construct() 
	{
		$this->middleware('auth', ['only'=>['insere']]);
	}

	public function toggleSubscribe() 
	{
		$requestedSubs = json_decode(Request::input('data'));
		$insc = Inscricao::where('contratante_empresa', $requestedSubs->contratante_empresa)
				->where('tipo', $requestedSubs->tipo)
				->where('user_id', auth()->id())
				->get();

		if (count ($insc) > 0) 
		{
			return (string)$this->unsubscribe($insc);
		}
		else
		{
			return (string)$this->subscribe($requestedSubs);
		}
	}

	// mesmo que inserir
	private function subscribe($dadosReq)
	{
		$insc = new Inscricao();
		$insc->user_id = auth()->id();
		$insc->tipo = $dadosReq->tipo;
		$insc->contratante_empresa = $dadosReq->contratante_empresa;

		return $insc->save();
	}

	// mesmo que deletar
	private function unsubscribe($inscricaos)
	{

		foreach ($inscricaos as $inscricao) 
		{
			$inscricao->delete();
		}
		return true;
		
	}


}
