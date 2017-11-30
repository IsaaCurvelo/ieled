<?php

// Este namespace tem que ser importado quando se quiser utilizar uma das classes de Modelo
namespace sisco;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model {

	protected $table = 'empresas';
	public $timestamps = false;
	
	protected $fillable = ['nome', 'cnpj'];
	protected $guarded = ['id'];

	public function ocorrencias()

	{

		return $this->hasMany(Ocorrencia::class);
		
	}

	public function users() {
		// retornar quais usuários estão inscritos na empresa

		$r = User::whereIn('id', function($query){$query->select('user_id')->from('inscricaos')->where('contratante_empresa', $this->id)->where('tipo', 1);})->get();

		return $r;
		
	}

}
