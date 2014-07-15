<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function($request)
{
	// http://www.thebuzzmedia.com/designing-a-secure-rest-api-without-oauth-authentication/

	$method = Input::server('REQUEST_METHOD');

	// Only POST, PUT and DELETE need authentication
	if($method != "GET")
	{
	    $data = Input::all();

		// Check if all the right data was sent
		if(isset($data['id'], $data['hash'], $data['timestamp']))
		{
		    $diff = ($data['timestamp'] - time()) / 60;

		    // Check if the request was made within the last 2 seconds to protect against Replay Attacks (http://en.wikipedia.org/wiki/Replay_attack)
		    if($diff < 2)
		    {
		        // Recreate the hash that was sent
		        $hash = hash_hmac('sha256', $data['id'], Config::get('app.private'));

		        // Check if the hash is correct
		        if($data['hash'] != $hash)
		        {
		        	return Response::json(array(
						'error' => 'Unauthorized hash'), 401
				    );
		        }
		    }
		    else
		    	return Response::json(array(
					'error' => 'Timed out'), 408
			    );

		}
		else
			return Response::json(array(
				'error' => 'Unauthorized data'), 401
		    );
	}
});


App::after(function($request, $response)
{
	// Check if the origin is allowed
	if(isset($_SERVER['HTTP_ORIGIN']))
	{
		$origin = $_SERVER['HTTP_ORIGIN'];

		// If the origin is found in de allowed domains array set the header to allow this origin
		if(in_array($origin, Config::get('cors.allowed_domains')))
		{
			$response->headers->set('Access-Control-Allow-Origin', 'http://thingder.com');
		}
	}

	// Only allow GET, POST, PUT and DELETE
	$response->headers->set('Access-Control-Allow-Methods','GET, POST, PUT, DELETE');
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function()
{
	if (Auth::guest())
	{
		if (Request::ajax())
		{
			return Response::make('Unauthorized', 401);
		}
		else
		{
			return Redirect::guest('login');
		}
	}
});


Route::filter('auth.basic', function()
{
	return Auth::basic();
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});
