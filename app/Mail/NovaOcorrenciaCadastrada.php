<?php

namespace sisco\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NovaOcorrenciaCadastrada extends Mailable
{
    use Queueable, SerializesModels;


    public $quem; 
    public $oQue; 
    public $quando; 
    public $usuario;


    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($quem, $oQue, $quando, $usuario)

    {

        $this->oQue = $oQue;
        $this->quem = $quem;
        $this->quando = $quando;
        $this->usuario = $usuario;
    
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()

    {

        return $this->view('emails.nova-ocorrencia-cadastrada');

    }
}
