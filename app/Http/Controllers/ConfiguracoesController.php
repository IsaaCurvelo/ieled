<?php 

namespace	sisco\Http\Controllers;
use	Illuminate\Support\Facades\DB;
use	Illuminate\Support\Facades\Hash;
use Request;
use Auth;
use sisco\Http\Requests\OcorrenciaRequest;
use Validator;

use \sisco\OrgaoInvestigador;
use \sisco\User;
use \sisco\Empresa;
use \sisco\Contratante;

class ConfiguracoesController extends Controller 
{



	public function __construct() 
	
	{
	
		$this->middleware('auth'/*, ['only'=>['']]*/);

	}





	public function index() 
	
	{

		return view('configuracoes.dashboard');

	}







	public function inscricoes()

	{

		$inscricaos = auth()->user()->inscricaos;

		$inscricaos->totalContratantes = 0;
		$inscricaos->totalEmpresas = 0;

		foreach ($inscricaos as $i) 

		{
			if($i->tipo == 1)

			{

				$inscricaos->totalEmpresas++;
				
				$i->empresa = Empresa::find($i->contratante_empresa);

			}
			else
		
			{

				$inscricaos->totalContratantes++;

				$i->contratante = Contratante::find($i->contratante_empresa);

			}

		}

		return view('configuracoes.inscricoes', compact('inscricaos'));

	}







	public function notificacoes()
	
	{
		
		return view('configuracoes.notificacoes');

	}



	// métodos para alteração dos att do Usuário


	public function alterarNome()
	
	{

		$user = auth()->user();

		$user->name = Request::input("nome");

		$user->save();

		return redirect()->action('ConfiguracoesController@index')->withInput(
							[
								'mensagem'=> "O nome de usuário foi alterado com sucesso!",
								'classe' => "success",
							]);

	}


	public function alterarTelefone()
	
	{
		
		$user = auth()->user();

		$user->telefone = Request::input("telefone");

		$user->save();

		return redirect()->action('ConfiguracoesController@index')->withInput(
							[
								'mensagem'=> "O telefone de usuário foi alterado com sucesso!",
								'classe' => "success",
							]);

	}


	public function alterarOrgao()
	
	{

		$orgao = OrgaoInvestigador::where('nome', Request::input('orgao-investigador'))
						->first();

		
		if ($orgao == null)
		
		{

			$orgao = new OrgaoInvestigador();

			$orgao->nome = Request::input('orgao-investigador');

			$orgao->save();

		}


		$user = auth()->user();

		$user->orgao_investigador_id = $orgao->id;

		$user->save();

		return redirect()->action('ConfiguracoesController@index')->withInput(
							[
								'mensagem'=> "O órgão investigador do usuário foi alterado com sucesso!",
								'classe' => "success",
							]);

	}

	public function alterarEmail()
	
	{

		$user = auth()->user();

		$user->email = Request::input("email");

		$user->save();

		return redirect()->action('ConfiguracoesController@index')->withInput(
							[
								'mensagem'=> "O email de usuário foi alterado com sucesso!",
								'classe' => "success",
							]);

	}



	public function alterarSenha()
	
	{

		$antiga = Request::input('old-password');
		
		$nova = Request::input('new-password');

		$confirmacao = Request::input('new-password_confirmation');

		
		$user = auth()->user();


		$messages=[];


		if (!Hash::check($antiga, $user->password))

		{

			$messages['classe'] = 'danger';

			$messages['senhaIncorreta'] = 'A sua senha está incorreta.';

			$messages['mensagem'] =  "Não foi possível altera a senha, verifique abaixo.";

			$messages['error'] = true;


		}

		elseif ($nova != $confirmacao)

		{

			$messages['classe'] = 'danger';

			$messages['senhaNaoConfere'] = 'As senhas não conferem.';

			$messages['mensagem'] = 'Não foi possível altera a senha, verifique abaixo.';

			$messages['error'] = true;

		}

		else

		{

			$user->password = bcrypt($nova);

			$user->save();

			$messages['classe'] = 'success';

			$messages['mensagem'] =  "Senha alterada com sucesso!";

		}


		return redirect()->action('ConfiguracoesController@index')->withInput($messages);

	}


	public function deleteAccount()
	
	{

		$psw = Request::input('password');
		
		if (!Hash::check($psw, auth()->user()->password))

		{

			$messages['classe'] = 'danger';

			$messages['dlSenhaIncorreta'] = true;

			$messages['mensagem'] =  "Não foi possível excuir sua conta IELED, sua senha está incorreta";


			return redirect()->action('ConfiguracoesController@index')->withInput($messages);

		}

		else

		{	

		 	

		 	$user = User::find(auth()->user()->id);

		 	Auth::logout();

			// delete user and redirect to home
			$user->delete();

			return redirect('home');

		}

	}


}