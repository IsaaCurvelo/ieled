<?php

namespace sisco\Http\Controllers\Auth;

use sisco\User;
use sisco\OrgaoInvestigador;
use Validator;
use sisco\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
	/*
	|--------------------------------------------------------------------------
	| Register Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users as well as their
	| validation and creation. By default this controller uses a trait to
	| provide this functionality without requiring any additional code.
	|
	*/

	use RegistersUsers;

	/**
	 * Where to redirect users after login / registration.
	 *
	 * @var string
	 */
	protected $redirectTo = '/home';

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	protected function validator(array $data)
	{


		return Validator::make(
			$data, 
			
			[
				'name' => 'required|max:255',
				'email' => 'required|email|max:255|unique:users',
				'password' => 'required|min:6|confirmed',
				'telefone' =>  [
					'nullable',
					'max:14',
					'string',
					'regex:/\([0-9]{2}\)[0-9]{5}\-[0-9]{4}/',
					'unique:users',
				]
			],

			[
				'regex' => 'O campo :attribute precisa estar no formato (00)00000-0000',
				'unique' => 'Este :attribute já está cadastrado no sistema',
				'required' => 'O campo :attribute é obrigatório',
				'min' => 'A senha precisa ter pelo menos 6 dígitos',
				'confirmed' => 'As senhas não conferem'

			]
	 );
	
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	protected function create(array $data)
	{


		// verificar se o órgão já existe no banco de dados
		// se sim, apenas associar o usuário ao órgão
		// se não, inserir e depois pegar o ID e associar ao usuário

		$orgao = OrgaoInvestigador::where('nome', $data['orgao_investigador'])->first();
		
		if ( is_null($orgao) ) 
		{
			$orgao = new OrgaoInvestigador();
			$orgao->nome = $data['orgao_investigador'];
			$orgao->save();
		}
		
		$arrayData = [
			'orgao_investigador_id' => $orgao->id,
			'name' => $data['name'],
			'telefone' => NULL,
			'email' => $data['email'],
			'password' => bcrypt($data['password']),
		];

		if($data['telefone'] !== '')
		{	
			array_push($arrayData, $data['telefone']);
		}

		// dd($arrayData);

		return User::create($arrayData);
	}
}
