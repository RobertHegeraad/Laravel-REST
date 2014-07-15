<?php

class curl
{
	public static function test()
	{
		echo 'test';
	}

	/** --------------------------------------------------------------------------
	 * Make a GET request and send along optional data
	 *
	 * @param $url mixed The url to request, if false the request will not be made
	 * @param $data array Optional data to sent with the request
	 */
	public static function get($url = false, $data = array())
	{
		return self::request($url, "GET", $data);
	}

	/** --------------------------------------------------------------------------
	 * Make a POST request and send along optional data
	 */
	public static function post($url = false, $data = array())
	{
		return self::request($url, "POST", $data);
	}

	/** --------------------------------------------------------------------------
	 * Make a PUT request and send along optional data
	 */
	public static function put($url = false, $data = array())
	{
		return self::request($url, "PUT", $data);
	}

	/** --------------------------------------------------------------------------
	 * Make a DELETE request and send along optional data
	 */
	public static function delete($url = false, $data = array())
	{
		return self::request($url, "DELETE", $data);
	}

	/** --------------------------------------------------------------------------
	 * Makes the GET/POST/PUT/DELETE request, returns a JSON object with the response or an error message
	 *
	 * @param $url mixed The url to request, if false the request will not be made
	 * @param $method string which request method to use
	 * @param $data array Optional data to sent with the request
	 */
	protected static function request($url = false, $method = "GET", $data = array())
	{
		if($url)
		{
			// Init cURL
			$ch = curl_init();

			// cURL settings
			curl_setopt_array($ch, array(
					CURLOPT_CUSTOMREQUEST => $method,
					CURLOPT_CONNECTTIMEOUT => 5,
					CURLOPT_RETURNTRANSFER => true,
					CURLOPT_URL => $url,
				)
			);

			if( ! empty($data))
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

			$response = curl_exec($ch);

			// Get the HTTP status code for the cURL request
			//$http_status = curl_getinfo($ch);

			//  if(curl_errno($ch))  echo 'Curl error: ' . curl_error($ch);

			return $response;

			curl_close($ch);

			// Return an error message if there was no response
			if( ! $response) {
				return json_decode(array('error' => 'No response'));
			}

			return json_decode($response);
		}
	}
}