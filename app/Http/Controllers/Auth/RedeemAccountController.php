<?php

namespace sisco\Http\Controllers\Auth;

use sisco\Http\Controllers\Controller;


use	Illuminate\Support\Facades\Hash;

use Request;

use Auth;


use \sisco\User;




class RedeemAccountController extends Controller

{

	public function redeemAccount ()

	{

		$email = Request::input('email');
		$pswd = Request::input('password');


		$user = User::onlyTrashed()->where('email', $email)->get()->first();

		if ( ! $user ) 

		{

			return view('auth.redeem', ['email_error'=>'email não encontrado.', 'error'=>true]);

		}

		elseif (!Hash::check($pswd, $user->password))

		{

			return view('auth.redeem', ['password_error'=>'senha incorreta para a conta', 'error'=>true]);

		}

		else

		{

			$user->restore();

			Auth::login($user);

			return redirect()->action('HomeController@index');

		}

	}



}