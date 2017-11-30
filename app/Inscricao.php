<?php

namespace sisco;

use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
	/* 
	 * O campo tipo, na base de dados, assume 1 se for uma inscrição de
	 * um usuário em uma empresa e 2 se for a inscrição de um usuário
	 * em um Contratante;
	*/

    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function empresa() {
        return $this->belongsTo(Empresa::class);
    }

    public function contratante() {
        return $this->belongsTo(Contratante::class);
    }

}
