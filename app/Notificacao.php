<?php

namespace sisco;

use Illuminate\Database\Eloquent\Model;

class Notificacao extends Model
{
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function ocorrencia() {
        return $this->belongsTo(Ocorrencia::class);
    }
}
