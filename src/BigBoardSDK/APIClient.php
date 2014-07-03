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

 	
 	public function checkAuth ()
 	{

		$resp = $this->fetch_endpoint('/api/check_auth');
		return (isset($resp->status) && ($resp->status == "success")) ? true : false;
	}


 	public function getWhoAmI ()
 	{
		$resp = $this->fetch_endpoint('/api/whoami');
		return $resp->result;
	}


 	public function sendEvents ($events)
 	{
 		$events = json_encode($events);

		$req = $this->post('/api');
		$req->setBody($events);
		$resp = $req->send();
		return json_decode($resp->getBody());
 	} 


 	protected function fetch_endpoint ($url)
 	{
		$req = $this->get($url);
		$resp = $req->send();
		return json_decode($resp->getBody());
 	}



}

