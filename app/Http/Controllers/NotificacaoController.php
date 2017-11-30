<?php 

namespace	sisco\Http\Controllers;
use	Illuminate\Support\Facades\DB;
use Auth;
use Request;
use sisco\User;
use sisco\Inscricao;
use sisco\Notificacao;
use sisco\Ocorrencia;

use sisco\Libs\ConversorData;

class NotificacaoController extends Controller 
{

	public function __construct() 
	{
		$this->middleware('auth', ['only'=>['insere']]);
	}

	public function manageNotifications() {
		$notificacaos = Notificacao::where('user_id', auth()->id())
				->orderBy('created_at')
				->get();
		return view('notificacao.dashboard', compact('notificacaos'));
	}

	public function read()
	{
		$id = Request::input('id');
		$ocorrencia = Ocorrencia::find(Request::input('ocorrencia'));

		$ocorrencia->user->orgao_investigador;
		$ocorrencia->situacao;
		$ocorrencia->tipo_despesa;
		$ocorrencia->area_despesa;
		$ocorrencia->contratante;
		$ocorrencia->empresa;
		$ocorrencia->data = ConversorData::toData($ocorrencia->data);

		$bsClasses =
		[
			'fiscalizada' => 'success',
			'fraudulenta' => 'danger',
			'recebeu dinheiro' => 'danger',
			'contratada' => 'info',
			'suspeita' => 'warning',
			'licitante' => 'info',
		];

		$this->setRead($id);


		return view('ocorrencia.detalhes',compact("ocorrencia", "bsClasses", "id"));

	}

	public function unread()
	{
		$id = Request::input('id');
		$this->setUnread($id);
	
		return redirect()->action('NotificacaoController@manageNotifications');
	}

	private function setRead($id)
	{	
		return Notificacao::where('id', $id)->update(['visto' => 1]);
	}

	private function setUnread($id)
	{	
		return Notificacao::where('id', $id)->update(['visto' => 0]);
	}

	public function delete()
	{
		$id = Request::input('id');
		Notificacao::find($id)->delete();

		return redirect()->action('NotificacaoController@manageNotifications');
	}

	public function deleteSeveral()
	{

	}


}