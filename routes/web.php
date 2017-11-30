<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/


/* 
/--------------------------------------------------------------------------
/ auth routes
/--------------------------------------------------------------------------
*/

Auth::routes();

Route::get('', 'HomeController@index');
Route::get('home', 'HomeController@index');

Route::get('sobre', function(){
	return view('about');
});



/* 
/--------------------------------------------------------------------------
/ public routes
/--------------------------------------------------------------------------
*/

// redeem account
Route::get('/resgatar-conta', function(){
	return view('auth.redeem');
});

Route::post('conta/resgatar', 'Auth\RedeemAccountController@redeemAccount');

/*
/--------------------------------------------------------------------------
/ routes managed by controllers
/--------------------------------------------------------------------------
*/

// Empresa's Routes
Route::get('empresas', 'EmpresaController@lista');
Route::get('empresas/mostrar', 'EmpresaController@mostrar');
Route::get('empresas/mostra/{id}', 'EmpresaController@mostra')->where('id', '[0-9]+');
Route::get('empresas/novo' , 'EmpresaController@novo');
Route::post('empresas/adiciona', 'EmpresaController@adiciona');
Route::get('empresas/json', 'EmpresaController@listaJson');
Route::get('empresas/sugestoes/{sugestao}', 'EmpresaController@sugestoes');
Route::get('empresas/remove/{id}','EmpresaController@remove')->where('id', '[0-9]+');
Route::get('/empresas/altera/{id}','EmpresaController@altera')->where('id', '[0-9]+');


// Ocorrencias' Routes
Route::get('ocorrencias', 'OcorrenciaController@minhasOcorrencias');
Route::get('ocorrencias/novo', 'OcorrenciaController@novo');
Route::get('ocorrencias/get/{id}', 'OcorrenciaController@get');
Route::get('ocorrencias/look-into/{modo}/{id}/{viewMode}', 'OcorrenciaController@lookInto');
Route::get('ocorrencias/cadastro-em-lote', 'OcorrenciaController@cadastroLote');
Route::post('ocorrencias/editar/{id}', 'OcorrenciaController@editar');
Route::post('ocorrencias/excluir/{id}', 'OcorrenciaController@excluir');
Route::post('ocorrencias/insere', 'OcorrenciaController@insere');
Route::post('ocorrencias/busca/{texto}', 'OcorrenciaController@busca');
Route::post('ocorrencias/insere-lote', 'OcorrenciaController@insereEmLote');


// Index page's Routes
Route::post('sugestao-para-o-sistema', 'IndexController@sugestoesSisco');
Route::get('orgaos-participantes', 'IndexController@orgaosParticipantes');

// InscricaoController's routes
Route::post('toggleSubscribe', 'InscricaoController@toggleSubscribe');

// Notificacao's Routes
Route::get('gerenciar/notificacoes','NotificacaoController@manageNotifications');
Route::post('gerenciar/notificacoes/ver','NotificacaoController@read');
Route::post('gerenciar/notificacoes/deletar','NotificacaoController@delete');
Route::post('gerenciar/notificacoes/nao-visto','NotificacaoController@unread');

//timeline's routes
Route::get('todas-as-ocorrencias', 'TimeLineController@timeline');
Route::get('todas-as-ocorrencias/busca/normal', 'TimeLineController@buscaNormal');
Route::get('todas-as-ocorrencias/busca/avancada', 'TimeLineController@buscaAvancada');

// AreaDespesas' Routes
Route::get('area-despesas/json', 'AreaDespesaController@json');

//relatórios' Routes
Route::get('relatorios', 'RelatorioController@index');
Route::post('relatorios/exportarCSV', 'RelatorioController@exportarCSV');
Route::post('relatorios/novo', 'RelatorioController@novo');

// TipoDespesas' Routes
Route::get('tipo-despesas/json', 'TipoDespesaController@json');


// Situacaos' Routes
Route::get('situacaos/json', 'SituacaoController@json');


// Contratantes' Routes
Route::get('contratantes/json', 'ContratanteController@json');

// Configuracoes' Routes
Route::get('configuracoes/conta', 'ConfiguracoesController@index');
Route::get('configuracoes/inscricoes', 'ConfiguracoesController@inscricoes');
Route::get('configuracoes/notificacoes', 'ConfiguracoesController@notificacoes');
Route::post('configuracoes/alterar/nome', 'ConfiguracoesController@alterarNome');
Route::post('configuracoes/alterar/email', 'ConfiguracoesController@alterarEmail');
Route::post('configuracoes/alterar/telefone', 'ConfiguracoesController@alterarTelefone');
Route::post('configuracoes/alterar/orgao-investigador', 'ConfiguracoesController@alterarOrgao');
Route::post('configuracoes/alterar/senha', 'ConfiguracoesController@alterarSenha');
Route::post('configuracoes/remover-conta', 'ConfiguracoesController@deleteAccount');


// OrgaoInvestigador's Route
Route::get('/orgao-investigador/json', 'OrgaoInvestigadorController@json');
Route::get('/orgao-investigador/nomes', 'OrgaoInvestigadorController@nomesOrgaos');

//-------------------------------------------------------------------------


// ADM's routes
Route::get('/adm/dashboard','AdmController@index');
Route::get('/adm/gerenciar-usuarios','AdmController@gerenciarUsuarios');
Route::get('/adm/gerenciar-ocorrencias','AdmController@gerenciarOcorrencias');