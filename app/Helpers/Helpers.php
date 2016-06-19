<?php

namespace App\Helpers;

/**
* class containing custom helpers
*/
class Helpers 
{

	/**
	 * generate short text of large text of particular length
	 * @param  [type] $text   [description]
	 * @param  [type] $length [description]
	 * @return [type]         [description]
	 */
	public static function excerpt($text,$length = 100) {
		if (strlen($text) > $length) { 
			$text = substr($text, 0, $length); 
			$text = substr($text,0,strrpos($text," ")); 
			$etc = " ...";  
			$text = $text.$etc; 
		}
		return $text; 
	}

	/**
	 * return the the date time string in readable format
	 * @param  [type] $value [description]
	 * @return [type]        [description]
	 */
	public static function humanize($value){

		$carbon = new \Carbon\Carbon($value);
		return $carbon->diffForHumans();
	}


}