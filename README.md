#BigBoard SDK for PHP

This SDK provides a simple interface to the [BigBoard API] (https://bigboard.us/api). [BigBoard] (https://bigboard.us/) is a web based service that aggredates point-in-time events from other web based services (and custom events) into a visually pleasing dashboard, allowing you to see what's really happening.


##Installation
Installation via [Composer] (http://getcomposer.org) is recommended; update composer.json file to include the BigBoard SDK:
```javascript
{
    "require": {
        "bigboard/bigboard-php-sdk": "*"
    }
}
```

##Basic Usage
```php

require 'vendor/autoload.php';

// See BigBoard's service settings UI. 
// Connect an App and paste your token here:

$api_key = "<Your API Access Token Here>";

$client = new BigBoardSDK\APIClient ($api_key);


// Get My Account
$my_account = $client->getWhoAmI();
var_export ($my_account);



// Post Events
$events = array (
	array (
	    "person_id" => "peter.gibbons@initech.com",
	    "person_label" => "Peter Gibbons",
	    "summary" => "Weekly TPS Report filed",
	    "time" => (time()-300), 
	    "label" => "TPS Reports"
	),
	array (
	    "person_id" => "bill.lundbergh@initech.com",
	    "person_label" => "Bill Lundbergh",
	    "summary" => "Report Rejected. Comment: Please include cover sheet. Mmmmkay?",
	    "time" => time(),
	    "label" => "TPS Reports"
	)
);

$status = $client->sendEvents($events);
var_export ($status);
```

##Documentation
More information on the BigBoard API is available at https://bigboard.us/api.


 