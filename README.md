Zemanta PHP API 
===============

More info about API and to retrieve API key, see http://www.zemanta.com

Usage:

	use Zemanta\Zemanta;

	$zemanta = new Zemanta('your_api_key');
	$params = array(
		'method' => 'zemanta.suggest',
		'text' => 'Your text'
	);
	$suggest = $zemanta->api($params);

	// output
	// array('status' => 'ok', 'articles' => .....);

The `api` method also support call method as first argument and optional parameters as array in second or third argument. 

	$params = array('format' => 'json');	
	$zemanta->api('zemanta.suggest', $params);
	// or with text
	$zemanta->api('zemanta.suggest', 'Your text', $params);

The output to `api` is alwas an array. To get raw response, use `getRaw` method with array of parameters. 

	$args = array(
		'method' => 'zemanta.suggest',
		'text'   => 'Your text',
		'format' => 'json'
	)
	$response = $zemanta->getRaw($args);

The API supports JSON, WNJSON, XML and RDFXML as ouput formats. If format parameter is not informed, XML format is used as default. 

Object-oriented
---------------

Soon...