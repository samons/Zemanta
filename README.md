Zemanta PHP API 
===============

More info about API and to retrieve API key, see http://developer.zemanta.com

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

The `api` method also support API `method` parameter as first argument and optional API parameters as array in second or third argument. 

	$params = array('format' => 'json');	
	$zemanta->api('zemanta.suggest', $params);
	// or with text
	$zemanta->api('zemanta.suggest', 'Your text', $params);


To `suggest` and `suggestMarkup` API methods, you could use the direct methos on Zemanta instance. 

	// Suggest
	$response = $zemanta->suggest('Your text');
	// Markup
	$response = $zemanta->suggestMarkup('Your text');

To request with raw parameters, use `request` method with array of parameters.

	$args = array(
		'method' => 'zemanta.suggest',
		'text'   => 'Your text',
		'format' => 'json'
	)
	$response = $zemanta->request($args);

The API supports `json`, `wnjson`, `xml` and `rdfxml` as ouput formats. If format parameter is not informed, `xml` format is used as default. 

Either `api` or `request` method returns a `Zemanta\Response` instance. To print or parse raw response body, you could use `getBody` method. 

	echo $response->getBody();
	// Zemanta\Response supports __toString() magic method, so you could print it direct. 
	echo $response;

To `json` format, you could export response to array. 

	$array = $response->toArray();