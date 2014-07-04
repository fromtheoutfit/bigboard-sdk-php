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

	
	}

 	
 	public function getCheckAuth ()
 	{
		return $this->getEndpoint('/api/check_auth');
	}


 	public function getWhoAmI ()
 	{
		return $this->getEndpoint('/api/whoami');
	}


 	public function sendEvents ($events)
 	{
		return json_decode($this->post('/api')->setBody(json_encode(array("events" => $events)))->send());
 	} 

 	public function sendEvent ($event)
 	{
		return json_decode($this->post('/api/event')->setBody(json_encode($event))->send()->getBody());
 	} 


 	protected function getEndpoint ($url)
 	{
 		$resp = $this->get($url)->send();

print_r($resp->getBody());
exit;
// 		if ($resp)
//		return json_decode();
 	}



}

