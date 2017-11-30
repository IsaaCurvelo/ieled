<?php

namespace sisco;

use Illuminate\Database\Eloquent\Model;

class Ocorrencia extends Model
{
	public function contratante() {
        return $this->belongsTo(Contratante::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function tipo_despesa() {
        return $this->belongsTo(TipoDespesa::class);
    }

    public function area_despesa() {
        return $this->belongsTo(AreaDespesa::class);
    }

    public function empresa() {
        return $this->belongsTo(Empresa::class);
    }

    public function situacao() {
        return $this->belongsTo(Situacao::class);
    }

    public function notificacaos() {
        return $this->hasMany(Notificacao::class);
    }


}
