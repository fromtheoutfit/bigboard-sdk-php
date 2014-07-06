<?php 

namespace BigBoardSDK;

 
 
class APIClient extends \Guzzle\Http\Client  {


	public function __construct($api_key, $url='https://bigboard.us')
	{
		parent::__construct();

		$this->setBaseUrl($url);
		$this->setSslVerification(false, false, false);
		$this->setUserAgent("BigBoardSDK/0.1");
		
		$this->setDefaultOption('headers', 
				array(
					 	'X-BigBoard-Token' => $api_key,
					 	'Content-Type' => "text/json",
					 )
		);

		$client->getEventDispatcher()->addListener('request.error', function(Event $event) {
	
	}

 	
 	public function getCheckAuth ()
 	{
		return $this->fetchEndpoint('/api/check_auth');
	}


 	public function getWhoAmI ()
 	{
		return $this->fetchEndpoint('/api/whoami');
	}


 	public function sendEvents ($events)
 	{
 		return $this->fetchEndpoint('/api/event', json_encode(array("events" => $events)));
 	} 

 	public function sendEvent ($event)
 	{
		return $this->fetchEndpoint('/api/event', json_encode($event));
 	} 


 	protected function fetchEndpoint ($url, $method="get", $body=null)
 	{
 		

		if ($method == "post")
		{
			$req = $this->post($url);
			
			if (!is_null($body))
			{
			 	$req->setBody($body);
			}
 			$resp = $this->post($url);
		}
		else
		{
 			$resp = $this->get($url);
		}


	//	try 
	//	{
		    $resp->send();
	//	} 
		// catch (\Guzzle\Http\Exception\ClientErrorResponseException $e) 
		// {
		// 	return $this->errorHandler($e, $url, "client_error");
		// }
		// catch (\Guzzle\Http\Exception\BadResponseException $e) 
		// {
		// 	return $this->errorHandler($e, $url, "bad_response");
		// }
		// catch (\Guzzle\Http\Exception\ServerErrorResponseException $e)
		// {
		// 	return $this->errorHandler($e, $url, "server_error");
		// }
		// catch (\Guzzle\Http\Exception\CurlException $e) 
		// {
		// 	return $this->errorHandler($e, $url, "curl_error");
		// }
    
       return $resp->json();

 	}

 
 	protected function errorHandler ($e, $url, $type)
 	{

 		$methods_avail = get_class_methods($e);

 		return array(
	 				"error" => array (
	 					"type"		=> $type,
	 					"url"		=> $url,
			 			"message"	=> (in_array("getMessage", $methods_avail)) ? $e->getMessage() : null,
	 				)
 				);

 	}


}

