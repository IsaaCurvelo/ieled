<?php 

namespace	sisco\Http\Controllers;
use	Illuminate\Support\Facades\DB;
use Request;
use sisco\Http\Requests\EmpresaRequest;
use Validator;
use sisco\Empresa; 
use sisco\Ocorrencia; 
use sisco\Contratante; 

class EmpresaController extends Controller 
{

	public function __construct() 
	{
		$this->middleware('auth', ['only'=>
			[
				'novo',
				'remove', 
				'altera', 
				'listaJson',
				'sugestoes',
			 ]

		]);
	}

	
	public function lista() 
	{

		$empresas = Empresa::orderby('nome','asc')->paginate(20);

		return view('empresa.listagem', ['empresas'=> $empresas]);
	}

	public function mostra($id) 
	{
		
		$empresa = Empresa::find($id);

		if (empty($empresa)) {
			return "Essa empresa não existe!";
		}

		$municipios = Contratante::whereIn('id', function($query) use ($empresa){$query->select('contratante_id')->from('ocorrencias')->where('empresa_id', $empresa->id);})->get();

		return view('empresa.detalhes', ['empresa'=> $empresa, 'municipios'=>$municipios]);

	}

	public function novo() 
	{
		$modo = 'Cadastro';
		return view('empresa.formulario', ['modo' => $modo, 'empresa' => null]);
	}

	public function adiciona(EmpresaRequest $request) 
	{	
		
		$params = $request->except('_token'); // dd($params); // vardump & die do Laravel
		$empresa = new Empresa($params);

		if (isset($params['id']) && Empresa::find($params['id'])) {
			$empresa->id = $params['id'];  
			$empresa->exists = true; 
			$params['modo'] = 'alterada';  
		} else {
			$params['modo'] = 'cadastrada';  
			$empresa->exists = false;  
		}
		
		$empresa->save();  


		
		return redirect()->action('EmpresaController@lista')
			->withInput($params); // Request::except('id')
	}


	public function remove($id)
	{
		$empresa = Empresa::find($id);
		$empresa->delete();

		return redirect()->action('EmpresaController@lista')->withInput(['modo'=>'deletada']);
	}

	public function altera($id)
	{
		$empresa = Empresa::find($id);
		$modo = "Edição";
		return view('empresa.formulario', ['modo' => $modo, 'empresa' => $empresa]);
	}

	public function listaJson() 
	{

		$empresas	=	Empresa::all();
		// return	response()->download('arquivo'); 				

		// exemplo de consulta com like:
		// $empresas = DB::select("select * from empresas where nome like ?", ['c%']);

		$responseCode = 200;
		$header = array(
			'Content-Type' => 'application/json; charset=UTF-8',
      			'charset' => 'utf-8'
		);

	  	$jsonOptions = JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT;

		return response()->json($empresas, $responseCode, $header, $jsonOptions);
	}

	public function sugestoes($sugestao)
	{
				
		$sugestao .= '%';
		$res = DB::table('empresas')->where('nome', 'like', $sugestao)->limit(4)->get();

		if( count ($res) > 0)
		{
        	return $res;
        }
        else{
        	return 'nope';
        }
	}	

}
