REST webservice setup using Laravel 4
=====

# Cross-Origin Resource Sharing

You can set the allowed domains that may use this REST webservice in the cors.php config array.

```php
return array(

	/*
	|--------------------------------------------------------------------------
	| Allowed domains
	|--------------------------------------------------------------------------
	|
	| This array will hold the domain names that may use the REST webservice.
	|
	| Default values is '*' Which means all domains may request from the webservice.
	*/

	'allowed_domains' => array(
		'*'
	)
);
```

# Authentication

The before filter checks if the user is authenticated by checking a hash with a private key that only the REST service knows.

The authentication method is explained in this article: http://www.thebuzzmedia.com/designing-a-secure-rest-api-without-oauth-authentication/

Response

All respones are in JSON at the moment