<?php

namespace sisco;

use Illuminate\Database\Eloquent\Model;

class OrgaoInvestigador extends Model {
    

  public function users() {

    return $this->hasMany(User::class);
  }
    
}
