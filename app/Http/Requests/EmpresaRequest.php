<?php

namespace sisco\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaRequest extends FormRequest
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
      'nome' => 'required|string',
      'cnpj' => 
        [	
        	'max:18',
          'required',
          'string',
          'regex:/[0-9]{2}\.[0-9]{3}\.[0-9]{3}\/[0-9]{4}\-[0-9]{2}/'
        ]  
    ];
  }

	public function messages(){
		return [
			// 'nome.required' => 'O campo nome não pode ser deixado vazio.', // específico de um campo
				'regex' => 'O campo :attribute precisa estar no formato 00.000.000/0000-00'
		];
	}
}
