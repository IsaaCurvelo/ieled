<?php

use Illuminate\Database\Seeder;
use	Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
     // $this->call(EmpresasTableSeeder::class);
     $this->call(AreaDespesasSeeder::class);
     $this->call(TipoDespesasSeeder::class);
     $this->call(SituacaoSeeder::class);
     $this->call(ContratanteSeeder::class);
     $this->call(OrgaoInvestigadorSeeder::class);
     $this->call(UserSeeder::class);
  }
}


// class	EmpresasTableSeeder	extends	Seeder	{
// 	public	function	run()
// 	{
// 		DB::insert('insert into empresas(nome, cnpj) values(?,?)',
// 								array('InfoWay systems.ltda','54.000.985/8954-10'));

// 		DB::insert('insert into empresas(nome, cnpj) values(?,?)',
// 								array('Core Builder.sa','18.325.597/1354-55'));

// 		DB::insert('insert into empresas(nome, cnpj) values(?,?)',
// 								array('Cadeiras Nonato.ltda','98.456.030/6958-17'));

// 		DB::insert('insert into empresas(nome, cnpj) values(?,?)',
// 								array('Canonical Elements and Stuff.sa','12.784.147/3626-25'));
// 	}
// }

class AreaDespesasSeeder extends Seeder {
	public function run()
	{
		DB::insert('insert into area_despesas(nome) values (?)', 
								array('administracao'));
	
		DB::insert('insert into area_despesas(nome) values (?)', 
								array('infra-estrutura'));

		DB::insert('insert into area_despesas(nome) values (?)', 
								array('educacao'));

		DB::insert('insert into area_despesas(nome) values (?)', 
								array('saude'));

		DB::insert('insert into area_despesas(nome) values (?)', 
								array('assistencia social'));
	}

}


class TipoDespesasSeeder extends Seeder {
	public function run()
	{
		DB::insert('insert into tipo_despesas(nome) values (?)', 
								array('compra'));
	
		DB::insert('insert into tipo_despesas(nome) values (?)', 
								array('servico'));

		DB::insert('insert into tipo_despesas(nome) values (?)', 
								array('obra'));
	}

}

class SituacaoSeeder extends Seeder {
	public function run()
	{
		DB::insert('insert into situacaos(nome) values (?)', 
								array('licitante'));
	
		DB::insert('insert into situacaos(nome) values (?)', 
								array('contratada'));

		DB::insert('insert into situacaos(nome) values (?)', 
								array('recebeu dinheiro'));
		
		DB::insert('insert into situacaos(nome) values (?)', 
								array('fiscalizada'));

		DB::insert('insert into situacaos(nome) values (?)', 
								array('suspeita'));

		DB::insert('insert into situacaos(nome) values (?)', 
								array('fraudulenta'));
	}

}

class ContratanteSeeder extends Seeder {
	public function run ()
	{
		DB::insert('insert into contratantes(nome) values(?)',
								array('SANTA INES'));
		DB::insert('insert into contratantes(nome) values(?)',
								array('MONCAO'));
		DB::insert('insert into contratantes(nome) values(?)',
								array('BARRA DO CORDA'));
		DB::insert('insert into contratantes(nome) values(?)',
								array('CAXIAS'));
		DB::insert('insert into contratantes(nome) values(?)',
								array('SAO LUIS'));
		DB::insert('insert into contratantes(nome) values(?)',
								array('IMPERATRIZ'));
		DB::insert('insert into contratantes(nome) values(?)',
								array('ZE DOCA'));
	}

}


class OrgaoInvestigadorSeeder extends Seeder{
	public function run()
	{
		DB::insert('insert into orgao_investigadors(nome) values(?)',
								array('TCE-MA-SECEX'));
		DB::insert('insert into orgao_investigadors(nome) values(?)',
								array('TCE-MA-UIE'));
		DB::insert('insert into orgao_investigadors(nome) values(?)',
								array('CGU-MA'));
		DB::insert('insert into orgao_investigadors(nome) values(?)',
								array('GAECO-MA'));

	}
}
class UserSeeder extends Seeder{
	public function run()
	{
		DB::insert('insert into users(name, password, email, orgao_investigador_id) values(?, ?, ?, ?)', array('adm', bcrypt("#$1sC012"), 'adm.sisco.ma@gmail.com', 1));
	}
}

