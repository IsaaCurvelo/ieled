<?php 

namespace	sisco\Http\Controllers;
use	Illuminate\Support\Facades\DB;
use Request;
use Auth;
use sisco\Http\Requests\EmpresaRequest;
use Validator;
use Response;
use sisco\Contratante; 
use sisco\Ocorrencia;
use sisco\Situacao;
use sisco\Libs\ConversorData;



class RelatorioController extends Controller 
{

	public function __construct() 
	{
		$this->middleware('auth', ['only'=>[

						'index',

						'exportarCSV',

						'novo',
			]
		]);
	}


	public function index() 
	{
		$contratantes = Contratante::all();
		$situacaos = Situacao::all();

		$bsClasses =
		[
			'fiscalizada' => 'success',
			'fraudulenta' => 'danger',
			'recebeu dinheiro' => 'danger',
			'contratada' => 'primary',
			'suspeita' => 'warning',
			'licitante' => 'primary'
		];

		$contratantes = $contratantes->sortBy('nome');
		return view('relatorios.dashboard', compact('contratantes', 'situacaos', 'bsClasses'));
	}

	public function exportarCSV()
	{
		$data = Request::only('contratante', 'data-inicio', 'data-fim');
		$situacaos = Request::except('_token','contratante', 'data-inicio', 'data-fim' );
		$query = Ocorrencia::query();

		if ($data['data-inicio'] != "")
		{
			$dataInicio = ConversorData::toDate($data['data-inicio']);
			$query->where('data', '>=', $dataInicio);
		}

		if ($data['data-fim'] != "")
		{
			$dataFim = ConversorData::toDate($data['data-fim']);
			$query->where('data', '<=', $dataFim);
		}

		if ($data['contratante'] != '-13')
			$query->where('contratante_id', $data['contratante']);

		if (count($situacaos) > 0)
			$query->wherein('situacao_id', $situacaos);

		$query->latest();
		$ocorrencias = $query->get();


		// preparing the output file

		$filename = md5(auth()->id());
		$file = fopen($filename, 'w+');

		// white down the header row
		fputcsv($file, array('empresa', 'cnpj', 'municipio contratante', 'situação', 'área de contratação', 'tipo de contratação', 'valor', 'fonte', 'data', 'órgão investigador', 'investigador', 'email', 'telefone'), ';');

		foreach ($ocorrencias as $o) 
		{
			$row = array($o->empresa->nome, $o->empresa->cnpj, $o->contratante->nome, $o->situacao->nome);

			if (! $o->area_despesa) 
				array_push($row, '');
			else
				array_push($row, $o->area_despesa->nome);

			if (! $o->tipo_despesa) 
				array_push($row, '');
			else
				array_push($row, $o->tipo_despesa->nome);
			
			array_push($row, $o->valor);
			array_push($row, $o->procedimento);
			array_push($row, $o->data);
			array_push($row, $o->user->orgao_investigador->nome);
			array_push($row, $o->user->name);
			array_push($row, $o->user->email);
			array_push($row, $o->user->telefone);

			fputcsv($file, $row, ";");
			
		}
		fclose($file);

		$headers = array(
			'Content-Type' => 'text/csv; charset=UTF-8',
			'Content-Encoding' => 'UTF-8'
		);

		return Response::download($filename, 'export.csv', $headers);

	}

	public function novo()
	{
		$data = json_decode(Request::input('data'), true);

		$query = Ocorrencia::query();

		if ($data['data-inicio'] != "") 
		{
			$dataInicio = ConversorData::toDate($data['data-inicio']);
			$query->where('data', '>=', $dataInicio);
		}

		if ($data['data-fim'] != "") {
			$dataFim = ConversorData::toDate($data['data-fim']);
			$query->where('data', '<=', $dataFim);
		}

		if ($data['contratante'] != '-13')
			$query->where('contratante_id', $data['contratante']);

		if (count($data['situacaos']) > 0)
			$query->wherein('situacao_id', $data['situacaos']);

		$query->latest();

		$total = $query->count();

		$query->limit(13);	
		
		// dd($query->toSql());

		$ocorrencias = $query->get();

		foreach ($ocorrencias as $ocorrencia) 
		{
			$ocorrencia->data = ConversorData::toData($ocorrencia->data);
		}

		return view('relatorios.response', compact('ocorrencias', 'total'));
	}

}