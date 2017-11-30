<?php

namespace sisco;

use Illuminate\Database\Eloquent\Model;

class AreaDespesa extends Model
{
    protected $fillable = ['nome'];
	protected $guarded = ['id'];

	public function ocorrencias()
	{
    	return $this->hasMany(Ocorrencia::class);
  	}
}
