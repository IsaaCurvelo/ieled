<?php

namespace sisco\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OcorrenciaRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize() {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules() {
    return [
      'nome-empresa' => 'required|string',
      'cnpj-empresa' => 
        [	
        	'max:18',
          'string',
          'regex:/[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}\-[0-9]{2}/'
        ],
        'contratante_id'=> 'required',
        'situacao_id'=> 'required',
        'data' => 'required|date|date_format:Y-m-d'
    ];
  }

	public function messages(){
		return [
			// 'nome.required' => 'O campo nome não pode ser deixado vazio.', // específico de um campo
				'regex' => 'O campo :attribute precisa estar no formato 00.000.000/0000-00',
        'required' => 'Este campo é obrigatório',
        'date' => 'Ô, meu querido, não mexe no JS...',

		];
	}
}
