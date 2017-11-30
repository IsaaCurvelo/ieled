<?php

namespace sisco;

use Illuminate\Database\Eloquent\Model;

class TipoDespesa extends Model
{
    protected $fillable = ['nome'];
	protected $guarded = ['id'];

	public function ocorrencias()
	{
    	return $this->hasMany(Ocorrencia::class);
  	}
}
