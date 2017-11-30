<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use sisco\TipoDespesa;
use sisco\AreaDespesa;
use sisco\Situacao;
use sisco\Ocorrencia;
use sisco\Contratante;
use sisco\Empresa;
use sisco\Libs\phpExcel\PHPExcel_IOFactory;

class ExampleTest extends TestCase
{
    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
    	// $nome= 'ca';

    	// $nome.='%';



     //    $texto_sugestao = 'ca';
        
     //    $texto_sugestao .= '%';
     //    $res = DB::table('empresas')->where('nome', 'like', $texto_sugestao)->get();

     //    if( count ($res ) > 0) 
     //    {
     //        return $res;
     //    }
     //    else{
     //        return 'nope';
     //    }
    
    // dd (Empresa::where('cnpj', '=' ,'18.325.597/1354-55')->get());

        // $o = new Ocorrencia();
        // foreach($o->where('user_id','=','1')->get() as $c)
        // {
        //     $c->user;
        //     $c->situacao;
        //     $c->tipo_despesa;
        //     $c->area_despesa;
        //     $c->contratante;
        //     $c->empresa;

        // }

        // dd($o);    


        // $emp = Empresa::where('cnpj', '=', '18.325.597/1354-75')->get();
        // dd($emp);


        // $oco = Ocorrencia::find(1);
        // if ($oco)
        // {
        //   $oco->delete();
        //   echo 'deletar';
        // } 
        // else 
        // {
        //   echo 'nada a fazer';
        // }
// =====================================================================================

      // $empresas = DB::table('empresas')->select('id')->where('nome', 'like', 'c%')->get();
      // // dd($empresas);
      // $s = array();

      // foreach ($empresas as $e) {
      //   array_push($s, $e->id);
      // }

      

      // $ocorrencias = new Ocorrencia();

      // $ocorrencias = $ocorrencias->whereIn('empresa_id', $s)
      //       ->where('user_id', '=', '1')
      //       ->get();

      // dd($ocorrencias);






      // $ocorrencias = Ocorrencia::whereIn('empresa_id', function($query){
      //   $query->select('id')
      //   ->from('empresas')
      //   ->where('nome','like', 'c%');
      // })->where('user_id', '=', 1)->toSql();


      // dd($ocorrencias);




      // PHP_Excel:

      $file = 'contratações.xlsx';
    
      $excelReader = PHPExcel_IOFactory::createReaderForFile($file);



    }

}
