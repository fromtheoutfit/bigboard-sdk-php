<?php

namespace BigBoardSDK;


use Guzzle\Http\Exception\ClientErrorResponseException;
use Guzzle\Http\Exception\CurlException;


class APIClient extends \Guzzle\Http\Client
{


    /*
     * Instantiate APIClient.
     *
     * @param 	string  	$api_key
     * @param 	string|null $url
     * @return 	void
     */
    public function __construct($api_key, $url = 'https://bigboard.us')
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


    /*
     * Check if authentication is valid.
     *
     * @return 	array
     */
    public function getCheckAuth()
    {
        return $this->fetchEndpoint('/api/check_auth');
    }


    /*
     * Return information about authenticated account.
     *
     * @return 	array
     */
    public function getWhoAmI()
    {
        return $this->fetchEndpoint('/api/whoami');
    }


    /*
     * Send multiple events.
     *
     * @param 	array 	$events
     * @return 	array
     */
    public function sendEvents($events)
    {
        return $this->fetchEndpoint('/api', "post", json_encode(array("events" => $events)));
    }


    /*
     * Send a single event.
     *
     * @param 	array 	$event
     * @return 	array
     */
    public function sendEvent($event)
    {
        return $this->fetchEndpoint('/api/event', "post", json_encode($event));
    }


    /*
     * Fetch URL, return response in standard format. Trap errors (if present).
     *
     * @param 	string 	$url
     * @param 	string 	$method
     * @param 	string 	$body
     * @return 	array
     */
    protected function fetchEndpoint($url, $method = "get", $body = null)
    {
        $result = array();

        if ($method == "post") {
            $request = $this->post($url);

            if (!is_null($body)) {
                $request->setBody($body);
            }
        } else {
            $request = $this->get($url);
        }


        //
        // Error Handling
        //

        try {
            $response = $request->send();
            $result = json_decode($response->getBody(), true);
        } catch (ClientErrorResponseException $e) {
            $result = json_decode($e->getResponse()->getBody(), true);
        } catch (CurlException $e) {
            $result = array(
                "error" => $e->getMessage(),
                "status" => "bad_request",
            );
        } catch (Exception $e) {
            $result = array(
                "error" => $e->getMessage(),
                "status" => "critical_error",
            );
        }

        if (!isset($result["status"])) {
            $result = array(
                "error" => "Unexpected response from server. Check URL?",
                "status" => "critical_error",
            );
        }

        return $result;

    }

}
