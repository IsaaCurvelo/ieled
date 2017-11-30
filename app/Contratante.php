<?php

namespace sisco;

use Illuminate\Database\Eloquent\Model;

class Contratante extends Model
{
	public function ocorrencias()
	{
		return $this->hasMany(Ocorrencia::class);
	}

	public function users() {
		// retornar quais usuários estão inscritos no contratante/municipio

		$r = User::whereIn('id', function($query){$query->select('user_id')->from('inscricaos')->where('contratante_empresa', $this->id)->where('tipo', 2);})->get();

		return $r;
	}
}
