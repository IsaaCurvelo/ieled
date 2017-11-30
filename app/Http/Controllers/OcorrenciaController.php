<?php
namespace	sisco\Http\Controllers;
use	Illuminate\Support\Facades\DB;
use Request;
use Auth;
use sisco\Http\Requests\OcorrenciaRequest;
use Validator;


use sisco\Jobs\CreateSendNotifications;
use Illuminate\Support\Facades\Mail;


use sisco\Ocorrencia;
use sisco\AreaDespesa;
use sisco\TipoDespesa;
use sisco\Empresa; 
use sisco\Situacao;
use sisco\Inscricao;
use sisco\Contratante;
use sisco\Notificacao;

use sisco\Libs\ConversorData;
use PHPExcel;
use PHPExcel_IOFactory;
use Storage;



use sisco\Mail\NovaOcorrenciaCadastrada;


class OcorrenciaController extends Controller 
{

	public function __construct()
	{
		$this->middleware('auth', ['only'=>[
				'novo', 
				'busca', 
				'excluir', 
				'minhasOcorrencias', 
				'insere', 
				'get', 
				'editar',
				'lookInto',
				'cadastroLote',
				'insereEmLote',
			]]);

	}

	public function novo()
	
	{

		// dados para a montagem da view:
		$areaDespesas = AreaDespesa::all();
		$tipoDespesas = TipoDespesa::all();
		$situacaos = Situacao::all();
		$contratantes = Contratante::all()->sortBy('nome');

		return view('ocorrencia.formulario', [
			'situacaos'=> $situacaos,
			'contratantes'=> $contratantes,
			'tipoDespesas'=> $tipoDespesas,
			'areaDespesas'=> $areaDespesas,
			]
		);
	}


	public function cadastroLote()
	{
		
		return view('ocorrencia.cadastro-lote');

	}


	public function minhasOcorrencias()
	{
		// pega o id do usuário da sessão:
		$usr_id = Auth::user()->id;

		$o = new Ocorrencia();
		// recupera todas as instâncias de ocorrências criadas pelo usuário da sessão
		$o = $o->where('user_id', '=', $usr_id)->latest()->paginate(30);

		$o = $this->fillRelations($o);

		// passar os dados para a view e montá-la
		return view('ocorrencia.listagem', ['ocorrencias'=> $o]);
	}




	public function insereEmLote()
	{	
		// pega o id do usuário logado
		$usrId = auth()->id();

		$planilha = request()->file('planilha');
		$path = $planilha->storeAs('planilhas_lote', "planilha{$usrId}.xlsx");
		$full_path = storage_path('app/' . $path);

		// Instancia do objeto para leitura do XLS
		$excelReader = PHPExcel_IOFactory::createReaderForFile($full_path);

		// Configurações básicas:
		$excelReader->setReadDataOnly();
		$sheets = ['Sheet1'];
		$excelReader->setLoadSheetsOnly($sheets);
		$excelObj = $excelReader->load($full_path);
		$sheet = $excelObj->setActiveSheetIndex(0);

		// Área da planilha que contém os dados em si:
		$row = $sheet->getHighestRow();
		$data = $sheet->rangeToArray('A2:H'.$row    ,null, true, true, true);
		
		// variáveis para controle de erros em linhas:
		$rowsWithError = array();
		$i = 2;

		// dados para a verificação de alguns campos:
		$areaDespesas = AreaDespesa::all();
		$tipoDespesas = TipoDespesa::all();
		$situacaos = Situacao::all();
		$contratantes = Contratante::all();

		foreach ($data as $row) 
		{
			$res = $this->verificaLinhaPlanilha($row, $areaDespesas, $tipoDespesas, $situacaos, $contratantes);
			if ($res[1] === False)
			{
				// adiciona ao array de erros para depois exibir para o usuário
				array_push($rowsWithError, [$i, $res[0]]);
			}
			else
			{

				$ocorrencia = new Ocorrencia();
				$emp = null;

				if ($row['B']) 
				{
					if (preg_match('/^\d{14}$/', $row['B'] == 1))
					{
						$row['B'] = $this->putCnpjMask($row['B']);
					}

					$emp = Empresa::where('cnpj', '=' , $row['B'])->get()->first();	
				}
				
				
				if (! $emp)
				{
					// a empresa será cadastrada
					$emp = new Empresa();
					$emp->cnpj = $row['B'];
					$emp->nome = $row['A'];
					$emp->save();
				}

				// caixa alta e sem caracteres especiais
				$contratante_str = strtoupper($row['C']);
				// $contratante_str = iconv('utf-8', 'ascii//TRANSLIT', $contratante_str);

				$contratante = Contratante::where('nome', '=', $contratante_str)->get()->first();
				if (! $contratante)
				{
					$contratante = new Contratante();
					$contratante->nome = $contratante_str;
					$contratante->save();
				}


				$situacao = Situacao::where('nome', '=', $row['D'])->get()->first();
				
				if ( $areaDespesa= AreaDespesa::where('nome', '=', $row['E'])->get()->first())
				{
					$ocorrencia->area_despesa_id = $areaDespesa->id;
				}

				if ($tipoDespesa= TipoDespesa::where('nome', '=', $row['F'])->get()->first())
				{
					$ocorrencia->tipo_despesa_id = $tipoDespesa->id;
				}

				$valor = $row['G'];

				$valor = str_replace(".", "/", $valor);
				$valor = str_replace(",", ".", $valor);
				$valor = str_replace("/", ",", $valor);
				$procedimento = $row['H'];

				$ocorrencia->valor = $valor;
				$ocorrencia->procedimento = $procedimento;
				$ocorrencia->user_id = $usrId;
				$ocorrencia->contratante_id = $contratante->id;
				$ocorrencia->situacao_id = $situacao->id;
				$ocorrencia->empresa_id = $emp->id;
				$ocorrencia->data = date('Y-m-d');

				$ocorrencia->save();

				// dispatch a new job to create the notifications and send emails
				// $this->createNotifications($ocorrencia);

				dispatch(new CreateSendNotifications($ocorrencia));

			}
		
			$i++;
		}

		if (count($rowsWithError) > 0) 
		{
			$numRows = count($data);
			return view('ocorrencia.erros-cadastro-lote', compact('rowsWithError', 'numRows'));
		}
		else
		{
			return redirect()->action('OcorrenciaController@minhasOcorrencias')->withInput(
				[
					'mensagem'=> "Ocorrências cadastradas com sucesso! =)",
					'classe' => 'success',
				]
			);
		}
	}




	public function insere(OcorrenciaRequest $request) 
	{
		$reqData = $request->except(['_token','button']);

		// Tratando os parâmetros da requisição;
		if (! $reqData['valor'])
		{
			$reqData['valor'] = null;
		}
		if (! $reqData['procedimento']){
			$reqData['procedimento'] = null;
		}

		if (! $reqData['tipo_despesa_id'] 
			|| $reqData['tipo_despesa_id'] == '-13')
		{
			$reqData['tipo_despesa_id'] = null;
		}
		if (! $reqData['area_despesa_id'] 
			|| $reqData['area_despesa_id'] == '-13')
		{
			$reqData['area_despesa_id'] = null;
		}

		$emp = null;

		if ($reqData['cnpj-empresa']  == '')
		{
			$reqData['cnpj-empresa'] = null;
		}
		else 
		{
			$emp = Empresa::where('cnpj', '=' , $reqData['cnpj-empresa'])->get()->first();
		}
		// ------------------------------------

		if (!$emp)
		{
			$emp = Empresa::where('nome', '=', $reqData['nome-empresa'])->get()->first();
		}
		
		if (!$emp)
		{
			// a empresa será cadastrada
			$emp = new Empresa();
			$emp->cnpj = $reqData['cnpj-empresa'];
			$emp->nome = $reqData['nome-empresa'];

			$emp->save();
		}

		// preenchendo objeto Ocorrencia
		$ocorrencia = new Ocorrencia();

		// atributos obrigatórios:
		$ocorrencia->empresa_id = $emp->id;
		$ocorrencia->user_id = Auth::user()->id;
		$ocorrencia->situacao_id = $reqData['situacao_id'];
		$ocorrencia->contratante_id = $reqData['contratante_id'];
		$ocorrencia->data = $reqData['data'];
		
		// atributos opcionais
		$ocorrencia->area_despesa_id = $reqData['area_despesa_id'];
		$ocorrencia->tipo_despesa_id = $reqData['tipo_despesa_id'];
		$ocorrencia->valor = $reqData['valor'];
		$ocorrencia->procedimento = $reqData['procedimento'];

		if ($ocorrencia->save())
		{

			// dispatch a new job to create the notifications and send emails
			// $this->createNotifications($ocorrencia);
			
			
			dispatch(new CreateSendNotifications($ocorrencia));


			return redirect()->action('OcorrenciaController@minhasOcorrencias')
			->withInput(
				[
					'mensagem'=> "Ocorrência cadastrada com sucesso! =)",
					'classe' => 'success',
				]);
		}
		else 
		{
			return redirect()->action('OcorrenciaController@minhasOcorrencias')
			->withInput(
				[
					'mensagem'=> "Algum erro ocorreu durante a tentativa de cadastro, por favor, tente novamente! =(",
					'classe' => 'danger',
				]);
		}
	}

	public function get($id)
	{
		$ocorrencia = Ocorrencia::find($id);
		if ($ocorrencia)
		{
		 	$ocorrencia->user;
			$ocorrencia->situacao;
			$ocorrencia->tipo_despesa;
			$ocorrencia->area_despesa;
			$ocorrencia->contratante;
			$ocorrencia->empresa;
    		}

		$responseCode = 200;
		$header = array(
			'Content-Type' => 'application/json; charset=UTF-8',
			'charset' => 'utf-8'
		);

	  $jsonOptions = JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;

		return response()->json($ocorrencia, $responseCode, $header, $jsonOptions);
	}



	public function editar($id)
	{
		$reqData = json_decode(Request::input(['req_data']));
		$ocorrOriginal = Ocorrencia::find($id);

		// empresa da requisição atual:
		$emp = Empresa::where('cnpj', '=', $reqData->empresa->cnpj)->get();


		if (count($emp) > 0)
		{
			// a o CNPJ já existe na base de dados...
			// necessário verificar se o nome foi mudado:
			$emp = $emp[0];
			if (!($emp->nome == $reqData->empresa->nome))
			{
				$emp->nome = $reqData->empresa->nome;
				$emp->save();
			}
		}
		else 
		{
			
			// a empresa será cadastrada
			$emp = new Empresa();
			$emp->cnpj = $reqData->empresa->cnpj;
			$emp->nome = $reqData->empresa->nome;

			$emp->save();
		}

		$ocorrOriginal->empresa_id = $emp->id;
		$ocorrOriginal->valor = $reqData->valor;
		$ocorrOriginal->procedimento = $reqData->procedimento;
		$ocorrOriginal->situacao_id = $reqData->situacao_id;
		$ocorrOriginal->contratante_id = $reqData->contratante_id;

		/* operadores ternários para determinar se o valor de 
		 * area_despesa_id e de tipo_despesa_id são 13 e, portanto,
		 * devem assumir o valor NULL
		*/
		$ocorrOriginal->area_despesa_id = ($reqData->area_despesa_id === '-13')? null : $reqData->area_despesa_id;
		$ocorrOriginal->tipo_despesa_id = ($reqData->tipo_despesa_id === '-13')? null : $reqData->tipo_despesa_id;		

		$ocorrOriginal->save();

		return 'ok';
	}


	public function excluir($id)
	{
		$id = Request::input(['id-oco']);

		$ocorrencia = Ocorrencia::find($id);
		if ($ocorrencia)
		{
			$ocorrencia->contratante();
			$ocorrencia->delete();
			return 'ok';
		}
		else
		{
			return 'nope';
		}
	}


	public function busca($texto)
	{


		$modo = Request::input(['modo']);
		$texto = str_replace("@$", "/", $texto);
		$usr_id = Auth::user()->id;

		// se alguem burlou meu JS
		if ($modo !== 'cnpj' && $modo !== 'nome')
		{
			return redirect()->action('OcorrenciaController@minhasOcorrencias')->withInput(
				[
					'mensagem'=> "Mexendo no código fonte? =/",
					'classe' => 'danger',
				]); 
		}

		$ocorrencias = Ocorrencia::whereIn('empresa_id', function($query) 
							use ($modo, $texto, $usr_id)
		{

				$query->select( 'id' )
	      ->from( 'empresas' )
	      ->where($modo, 'like', $texto . '%');
	    })->where('user_id', '=', $usr_id)->paginate();

		$ocorrencias = $this->fillRelations($ocorrencias);

  		// passar os dados para a view e montá-la
		return view('ocorrencia.listagem', compact('ocorrencias','modo','texto'));


	}


	public function lookInto($modo, $id, $viewMode)
	{
		// pegar todas as ocorrências de acordo com os dados da requisição
		// considerar utilizar chunks para pegar menos registros!!!
		$ocorrencias = Ocorrencia::where($modo.'_id', '=', $id)->latest()->paginate(20);
		
		$ocorrencias = $this->fillRelations($ocorrencias);

    	$modoOposto = ($modo == 'empresa' ? 'contratante' : 'empresa');

    	$bsClasses =
    	[
    		'fiscalizada' => 'success',
    		'fraudulenta' => 'danger',
    		'recebeu dinheiro' => 'danger',
    		'contratada' => 'info',
       		'suspeita' => 'warning',
    		'licitante' => 'info',
    	];

    	if (count($ocorrencias) == 0) 
    	{
    		return view('ocorrencia.no-results');
    	}

		if ($viewMode == 'posts')
		{
			return view('ocorrencia.look-into-post-view', compact (
					'ocorrencias', 'modo', 'modoOposto', 'bsClasses')
			);
		}
		else if($viewMode == 'table') 
		{
			return view( 'ocorrencia.look-into-table-view', compact (
					'ocorrencias', 'modo', 'modoOposto', 'bsClasses')

			);
		}
		else
		{
			return 'URL inválida! Aperte voltar no navegador...';
		}
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
					->where('user_id', $o->user_id )
					->where('contratante_empresa', $o->empresa_id)
					->where('tipo', 1)
					->get()->first();

			$inscricaoContrat = DB::table('inscricaos')
					->select('id')
					->where('user_id', $o->user_id )
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



	private function verificaLinhaPlanilha($row, $areaDespesas, $tipoDespesas, $situacaos, $contratantes)
	{
		$out = [[], True];
		// Se alguma das colunas essenciais estiver vazia
		if( ! ($row['A'] && $row['C'] && $row['D']))
		{
			$out[1] = False;
			array_push($out[0], 'Campo(s) obrigatório(s) não preenchido(s). Podem ser identificados pela cor verde');
		}
		else
		{
			/* Testes para saber se as colunas apresentam os valores válidos,
			 * que são os que estão cadastrados previamente no banco de dados ou regex:
			*/

			/* 
			Se o valor na coluna "Situação" não está cadastrado no banco:
			*/

			// "limpeza" dos dados que vêm da planilha
			$sit = $row['D'];
			$sit = iconv('utf-8', 'ascii//TRANSLIT', $sit);
			$sit = strtolower($sit);
			$row['D'] = $sit;

			if($situacaos->search(function ($item, $key) use ($sit){
						return $item->nome == $sit;}) === False)
			{
				$out[1] = False;
				array_push($out[0], 'O campo "situação" contém um valor inválido');
			}

			
			/* 
			Se o valor na coluna "area da contratação" não está cadastrado no banco:
			*/

			// limpeza dos dados que vêm da planilha
			$area = $row['E'];
			$area = iconv('utf-8', 'ascii//TRANSLIT', $area);
			$area = strtolower($area);
			$row['E'] = $area;


			if($areaDespesas->search(function ($item, $key) use ($area){
						return $item->nome == $area;}) === False && $area)
			{
				$out[1] = False;
				array_push($out[0], 'O campo "área da contratação" contém valor inválido');
			}


			/* 
			Se o valor na coluna "tipo da contratação" não está cadastrado no banco: 
			*/

			// limpeza dos dados que vêm da planilha:

			$tipo = $row['F'];
			$tipo = iconv('utf-8', 'ascii//TRANSLIT', $tipo);
			$tipo = strtolower($tipo);
			$row['F'] = $tipo;


			if($tipoDespesas->search(function ($item, $key) use ($tipo){
						return $item->nome == $tipo;}) === False && $tipo)
			{
				$out[1] = False;
				array_push($out[0], 'O campo "tipo da contratação" contém valor inválido');
			}
			
			// Se o CNPJ está no formato 'XX.XXX.XXX/XXXX-XX'
			if( $row['B'] && (preg_match('/^\d{14}$|^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/', $row['B']) != 1))
			{
				$out[1] = False;
				array_push($out[0], 'O campo "cnpj" não está no formato: xx.xxx.xxx/xxxx-xx');
			}

		}

		return $out;
	}


	private function createNotifications($ocorrencia)
	{
	 	/* pegar todo mundo que tá inscrito em $ocorrencia->contratante_empresa
	 	  nos tipos 1 e 2 e salvar notificações
		*/

		$inscritosEmpresa = $ocorrencia->empresa->users();
		$inscritosContratante = $ocorrencia->contratante->users();

		// variáveis para montagem do texto da notificação:
		$orgaoNome = $ocorrencia->user->orgao_investigador->nome;
		$empresaNome = $ocorrencia->empresa->nome;
		$contratanteNome = $ocorrencia->contratante->nome;
		$data = ConversorData::toData($ocorrencia->data);

		foreach ($inscritosContratante as $user) 
		{
			if($user->id != auth()->id())
			{
				$notification = new Notificacao();
				$notification->user_id = $user->id;
				$notification->ocorrencia_id = $ocorrencia->id;
				$notification->texto = 
					"O " . $orgaoNome . " cadastrou uma ocorrência da empresa " . $empresaNome .
					" em " . $data . ".";
				$notification->save();
			}
		}

		foreach ($inscritosEmpresa as $user) 
		{
			if($user->id != auth()->id())
			{
				$notification = new Notificacao();
				$notification->user_id = $user->id;
				$notification->ocorrencia_id = $ocorrencia->id;
				$notification->texto = 
					"O " . $orgaoNome . " cadastrou uma ocorrência do município " . $contratanteNome .
					" em " . $data . ".";
				 $notification->save();
			}
		}
	}

	private function putCnpjMask($string)
	{
		$masked = substr($string, 0, 2) . '.' . substr($string, 2, 3) . '.' ;
		$masked .= substr($string, 5, 3) . '/' . substr($string, 8, 4) . '-' ;
		$masked .= substr($string, 11, 2) ;

		return $masked;
	}
}
