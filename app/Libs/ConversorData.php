<?php 

namespace sisco\Libs;

class  ConversorData
{
	public static function toData($date)
	{
		
		//converte de 2016-08-05 para 05/08/2016
		
		$retorno='';
		$retorno .= substr($date, 8, 2);		
		$retorno .= '/';
		$retorno .= substr($date, 5, 2);		
		$retorno .= '/';
		$retorno .= substr($date, 0, 4);
		
		return $retorno;

	}
	
	public static function toDate($data)
	{
		
		//converte de 05/08/2016 para 2016-08-05
		
		$retorno='';
		$retorno .= substr($data, -4, 4);		
		$retorno .= '-';
		$retorno .= substr($data, 3, 2);		
		$retorno .= '-';
		$retorno .= substr($data, 0, 2);
		
		return $retorno;

	}
}