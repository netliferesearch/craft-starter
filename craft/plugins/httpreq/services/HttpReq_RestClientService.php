<?php
namespace Craft;

use Guzzle\Http\Client;
use Guzzle\Plugin\Cookie\Cookie;
use Guzzle\Plugin\Cookie\CookiePlugin;
use Guzzle\Plugin\Cookie\CookieJar\ArrayCookieJar;

class HttpReq_RestClientService extends BaseApplicationComponent
{
	//Default requests options - might be configurable in the future
	private $_timeout = 30;
	private $_connectionTimeout = 2;
	private $_allowRedirects = true;

	//Time, in seconds, during which we store the responses in cache
	private $_cacheTtl = 3600;

	//HTTP client
	private $_client;

	/**
	 * Create a new instance of HTTP client
	 */
	private function _getClient()
	{
		if( isset($this->_client) ) {
			return $this->_client;
		}

		$this->_client = new Client();

		//Handle session cookies
		$cookieJar = new ArrayCookieJar();
		// Create a new cookie plugin
		$cookiePlugin = new CookiePlugin($cookieJar);
		// Add the cookie plugin to the client
		$this->_client->addSubscriber($cookiePlugin);

		return $this->_client;
	}

	/**
	 * Generate a cache identifier based on the method, the url and the parameters
	 */
	private function _getCacheId($method, $url, $params)
	{
		return 'restclient_' . $method . '_' . $url . '_' . md5(json_encode($params));
	}

	/**
	 * Accepts a list of files and returns the temporary upload path for each of them.
	 *
	 * @param array $files
	 *
	 * @return array List of temporary paths
	 */
	private function _getFilesTempPath($fileNames)
	{
		$paths = array();
		foreach( $options['files'] as $param => $file ) {
			$paths[$param] = '@' . $file->getTempName();
		}

		return $paths;
	}

	/**
	 * Build an HTTP request.
	 *
	 * @param string $method The request's method (GET or POST)
	 * @param string $url The URL to perform the request to
	 * @param array $requestParams List of GET or POST parameters
	 *
	 * @return object
	 */
	private function _buildRequest($method, $url, $requestParams)
	{
		//Obtain Guzzle instance
		$client = $this->_getClient();
		$request = null;

		//Define request options
		$requestOptions = array(
			'timeout'         => $this->_timeout,
			'connect_timeout' => $this->_connectionTimeout,
			'allow_redirects' => $this->_allowRedirects,
		);

		//Request headers
		$requestHeaders = array(
			'X-Requested-With' => 'XMLHttpRequest',
		);

		if($method === 'post') {
			$request = $client->post($url, $requestHeaders, $requestParams, $requestOptions);
		}
		else if($method === 'get') {
			//If we find an occurence of "?", it means there are already parameters specified
			$urlWithParams = $url . (( strpos($url, '?') !== false ) ? '&' : '?');
			$urlWithParams .= http_build_query($requestParams);
			$request = $client->get($urlWithParams, $requestHeaders, $requestOptions);
		}

		return $request;
	}

	/**
	 * Sends a request and returns the response and error if any.
	 * If the server returns a JSON response, it will be returned as an object.
	 *
	 * @param string $method The request's method (GET or POST)
	 * @param string $url The URL to perform the request to
	 * @param array $options An options array
	 *
	 * @return object { "statusCode": 200, "body": { ... }, "error": "If any..." }
	 */
	private function _request($method, $url, $options)
	{
		//Let's be pessimistic
		$result = false;

		//Extract parameters from options
		$requestParams = ( isset($options['params']) ) ? $options['params'] : array();

		//If there are any files, add them to the list of params
		if( isset($options['files']) ) {
			$requestParams = array_merge( $requestParams, $this->_getFilesTempPath($options['files']) );
		}

		//Should we try to get the results from cache?
		$getFromCache = (isset($options['fromCache'])) ? $options['fromCache'] : true;

		//Obtain the cache id
		$cacheId = $this->_getCacheId($method, $url, $requestParams);

		if( $getFromCache ) {

			//Check if the response has already been cached
			if( $cachedResult = craft()->cache->get($cacheId) ) {
				$result = $cachedResult;

				return $result;
			}
		}

		//If cache is empty or bypassed, we send the request
		$responseReceived = false;
		$response = false;
		$errorMsg = '';

		try {
			//Build the request
			$request = $this->_buildRequest($method, $url, $requestParams);

			//Potentially long-running request, so close session to prevent session blocking on subsequent requests.
			craft()->session->close();

			//Send the request
			$response = $request->send();
			$responseReceived = true;
		}
		//HTTP response with error code received
		catch(\Guzzle\Http\Exception\BadResponseException $e) {
			$response = $e->getResponse();
			$errorMsg = $e->getMessage();
			$responseReceived = true;
		}
		//We did not receive a response
		catch(\Exception $e) {
			$errorMsg = $e->getMessage();
		}

		//Prepare the results
		$result = array(
			'statusCode' => 0,
			'body' => array(),
		);

		//Check if we received a response
		if( $responseReceived ) {
			//Store the status code
			$result['statusCode'] = $response->getStatusCode();

			//Try to obtain the body in JSON
			try {
				$result['body'] = $response->json();
			}
			//If the response does not contain JSON, simply get the body as it is
			catch(\Exception $e) {
				$result['body'] = $response->getBody();
			}

			//Store in cache if the response was successful
			if( $response->isSuccessful() ) {
				//Store in cache
				craft()->cache->set($cacheId, $result, $this->_cacheTtl);
			}
		}

		//If there was an error, add the error message to the results
		if( ! $responseReceived || ! $response->isSuccessful() ) {
			$result['error'] = $errorMsg;
		}


		return $result;
	}

	/**
	 * Set cache time to live
	 *
	 * @param int $ttl Number of seconds during which the cache is valid
	 *
	 * @return null
	 */
	public function setCacheTtl($ttl)
	{
		if( is_numeric($ttl) )
		{
			$this->_cacheTtl = $ttl;
		}
	}

	/**
	 * Shorthand method to create a get request
	 */
	public function get($url, $params, $fromCache)
	{
		$options = array(
			'params' => $params,
			'fromCache' => $fromCache,
		);

		return $this->_request('get', $url, $options);
	}

	/**
	 * Shorthand method to create a post request
	 */
	public function post($url, $params, $files)
	{
		$options = array(
			'params' => $params,
			'files' => $files,
			//POST requests will never be cached
			'fromCache' => false,
		);

		return $this->_request('post', $url, $options);
	}
}