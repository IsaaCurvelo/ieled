<?php

namespace sisco\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use sisco\Mail\NovaOcorrenciaCadastrada;

use sisco\Ocorrencia;
use sisco\Notificacao;
use sisco\Inscricao;


use sisco\Libs\ConversorData;

class CreateSendNotifications implements ShouldQueue

{
	use InteractsWithQueue, Queueable, SerializesModels;


	protected $ocorrencia;

	/**
	 * Create a new job instance.
	 *
	 * @return void
	 */
	public function __construct($ocorrencia)

	{

		$this->ocorrencia = $ocorrencia;	

	}



	/**
	 * Execute the job.
	 *
	 * @return void
	 */
	public function handle()

	{

		/* pegar todo mundo que tá inscrito em $ocorrencia->contratante_empresa
		nos tipos 1 e 2 e salvar notificações
		*/

		$inscritosEmpresa = $this->ocorrencia->empresa->users();

		$inscritosContratante = $this->ocorrencia->contratante->users();


		// variáveis para montagem do texto da notificação:
		
		$orgaoNome = $this->ocorrencia->user->orgao_investigador->nome;

		$empresaNome = $this->ocorrencia->empresa->nome;

		$contratanteNome = $this->ocorrencia->contratante->nome;

		$data = ConversorData::toData($this->ocorrencia->data);


		foreach ($inscritosEmpresa as $user) 

		{

			if($user->id != auth()->id())

			{

				$notification = new Notificacao();

				$notification->user_id = $user->id;

				$notification->ocorrencia_id = $this->ocorrencia->id;

				$notification->texto = 
					"O " . $orgaoNome . " cadastrou uma ocorrência da empresa " . $empresaNome .
					" em " . $data . ".";

				$notification->save();

				// send email notifying

				Mail::to($user->email)
					->send(new NovaOcorrenciaCadastrada($orgaoNome, $empresaNome, $data, $user));

			}


		}


		foreach ($inscritosContratante as $user) 

		{

			if($user->id != auth()->id())

			{
				$notification = new Notificacao();

				$notification->user_id = $user->id;

				$notification->ocorrencia_id = $this->ocorrencia->id;

				$notification->texto = 
					"O " . $orgaoNome . " cadastrou uma ocorrência do município " . $contratanteNome .
					" em " . $data . ".";

				$notification->save();

				// send email notifying
				
				Mail::to($user->email)
		            ->send(new NovaOcorrenciaCadastrada($orgaoNome, $contratanteNome, $data, $user));

			}
		}
	}

}