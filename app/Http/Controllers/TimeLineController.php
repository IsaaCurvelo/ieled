<?php 
namespace	sisco\Http\Controllers;
use	Illuminate\Support\Facades\DB;
use Request;
use Auth;

use sisco\Ocorrencia;
use sisco\Contratante;
use sisco\OrgaoInvestigador;

use sisco\Libs\ConversorData;


class TimeLineController extends Controller 
{
	public function __construct()
	{
		$this->middleware('auth');

	}

	private function viewTimeline($ocorrencias, $isBusca = false)
	{

		$this->fillRelations($ocorrencias);

		$bsClasses =
		[
			'fiscalizada' => 'success',
			'fraudulenta' => 'danger',
			'recebeu dinheiro' => 'danger',
			'contratada' => 'info',
			'suspeita' => 'warning',
			'licitante' => 'info',
		];

		$contratantes = Contratante::all()->sortBy('nome');
		$orgaoInvestigadors = OrgaoInvestigador::all();

		return view('time-line', compact(
					'ocorrencias',
					'bsClasses',
					'contratantes',
					'orgaoInvestigadors',
					'isBusca'
					));
	}


	public function timeline()
	{

		$ocorrencias = Ocorrencia::latest()->paginate(20);
		return $this->viewTimeline($ocorrencias);
		
	}

	public function buscaNormal()
	{
		$modo = Request::input('modoDeBusca');
		$texto = Request::input('texto');

		switch ($modo) {
			case 'cnpj':
				$ocorrencias = Ocorrencia::whereIn(
					'empresa_id', function($query) use ($texto){
						$query->select('id')
						->from('empresas')
						->where('cnpj', 'like' , $texto . '%');
						}
					)
				->paginate(20);
				break;

			case 'nome':
				$ocorrencias = Ocorrencia::whereIn(
					'empresa_id', function($query) use ($texto){
						$query->select('id')
						->from('empresas')
						->where('nome', 'like' , $texto . '%');
						}
					)
				->paginate(20);	
				break;

			case 'municipio':
				$ocorrencias = Ocorrencia::whereIn(
					'contratante_id', function($query) use ($texto){
						$query->select('id')
						->from('contratantes')
						->where('nome', 'like' , $texto . '%');
						}
					)
				->paginate(20);
				break;

		}

		return $this->viewTimeline($ocorrencias, true);
		
	}

	public function buscaAvancada()
	{
		$data = (Request::all());
		$data = $this->removeEmptyFields($data);

		// $query = DB::table('ocorrencias');

		// delicia de gambeta :
		$query = Ocorrencia::query();

		if (isset($data['nome-empresa'])) 
		{
		
			$query->whereIn
			(
				'empresa_id', 
				function($query) use ($data)
				{
					$query->select('id')
					->from('empresas')
					->where('nome', 'like' , $data['nome-empresa'] . '%');
				}
			);
		}

		if (isset($data['cnpj-empresa']))
		{
			$query->whereIn
			(
				'empresa_id', 
				function($query) use($data)
				{
					$query->select('id')
					->from('empresas')
					->where('cnpj', 'like', $data['cnpj-empresa'] . '%');
				}
			);
		}

		if (isset($data['orgao-investigador']))
		{
			$query->whereIn
			(
				'user_id', function($query) use ($data){
					$query->select('id')
					->from('users')
					->whereIn
					(
						'orgao_investigador_id', function($query) use ($data) {
							$query->select('id')
							->from('orgao_investigadors')
							->where('id', $data['orgao-investigador']);
						}

					);
				}
			);
		}

		if (isset($data['contratante']))
		{
			$query->where('contratante_id', $data['contratante']);
		}

		if (isset($data['data-inicio']))
		{			
			$dataInicio = ConversorData::toDate($data['data-inicio']);
			$query->whereDate('created_at', '>=', $dataInicio);
		}

		if (isset($data['data-fim']))
		{
			$dataFim = ConversorData::toDate($data['data-fim']);
			$query->whereDate('created_at', '<=', $dataFim);
		} 

		$ocorrencias = $query->paginate(20);
		return $this->viewTimeline($ocorrencias, true);
	}

	private function removeEmptyFields($fields)
	{
		foreach ($fields as $key => $value) 
		{
			if ($value === '' || $value === 0) 
			{
				unset($fields[$key]);
			}
		}

		return $fields;
	}

	private function fillRelations($ocorrencias)
	{
		foreach( $ocorrencias as $o)
		{
			// recuperando os relacionamentos dos objetos Ocorrencia
			$o->user->orgao_investigador;
			$o->situacao;
			$o->tipo_despesa;
			$o->area_despesa;
			$o->contratante;
			$o->empresa;

			// attrib para saber se o usuário tem inscrição
			$o->inscEmpresa = false;
			$o->inscContrat = false;

			// mudando o formato da data
			$o->data = ConversorData::toData($o->data);

			// verificando se o usuário logado é inscrito na Empresa ou Contratante:
			$inscricaoEmpresa = DB::table('inscricaos')
					->select('id')
					->where('user_id', auth()->id() )
					->where('contratante_empresa', $o->empresa_id)
					->where('tipo', 1)
					->get()->first();

			$inscricaoContrat = DB::table('inscricaos')
					->select('id')
					->where('user_id', auth()->id() )
					->where('contratante_empresa', $o->contratante_id)
					->where('tipo', 2)
					->get()->first();


			if ($inscricaoEmpresa)
			{
				$o->inscEmpresa = true;
			}

			if($inscricaoContrat) 
			{
				$o->inscContrat = true;
			}
		}
		return $ocorrencias;
	}
}
