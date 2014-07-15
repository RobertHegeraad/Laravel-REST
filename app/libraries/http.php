<?php

class http
{
	public static function response($status)
	{
		http_response_code($status);
	}

	public static function content($type = 'json')
	{
		switch(strtolower($type))
		{
			case 'json':
				header('Content-type: application/json');
				break;

			default:
				header('Content-type: text/html');
				break;
		}
	}
}