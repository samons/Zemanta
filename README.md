Zemanta PHP API 
===============

More info about API and to retrieve API key, see http://www.zemanta.com

Usage:

	$zemanta = new Zemanta('your_api_key');
	$suggest = $zemanta->api(array('method' => zemanta.suggest', 'text' => 'Your text'));
