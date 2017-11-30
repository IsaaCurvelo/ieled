<?php 

namespace sisco\Libs;

class  GetLastMonths
{

	public static $translate = 
	[
		"1"=>"janeiro", 
		"2"=>"fevereiro", 
		"3"=>"março", 
		"4"=>"abril",
		"5"=>"maio",
		"6"=>"junho",
		"7"=>"julho",
		"8"=>"agosto",
		"9"=>"setembro",
		"10"=>"outubro",
		"11"=>"novembro",
		"12"=>"dezembro"
	];



	public static function last($n)
	{
		$months = [];

		for ($i = $n-1; $i >= 0; $i--) 
		{
			$m = strtotime( date( 'Y-m-01' )." -$i months");
			$months[(int)(date("m", $m))] = self::$translate[(int)(date("m", $m))];
		}
		return $months;
	
	}

	public static function lastWithYear($n)
	{	
		$months = [];

		for ($i = $n-2; $i >= -1; $i--) 
		{
			$m = strtotime('last day of previous month -'.$i.' months');
			$months[(int)(date("m", $m))] = [self::$translate[(int)(date("m", $m))], (date("Y-m-d", $m))];
		}
		return $months;
	}
}
// date('Y-m-d', strtotime('last day of previous month -4 months'));
