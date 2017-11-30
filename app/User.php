<?php

namespace sisco;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable {
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'telefone','orgao_investigador_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 
    ];



    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];





    public function orgao_investigador() {
        return $this->belongsTo(OrgaoInvestigador::class);
    }

    public function notificacaos() {
        return $this->hasMany(Notificacao::class);
    }
    
    public function inscricaos() {
        return $this->hasMany(Inscricao::class);
    }



}
