<?php

namespace Zemanta;

class Zemanta
{
	/**
	 * Default URL endpoint to Zemanta REST API
	 */
	const END_POINT = 'http://api.zemanta.com/services/rest/0.0';

	/**
	 * API methods
	 */
	const METHOD_SUGGEST        = 'zemanta.suggest';
	const METHOD_SUGGEST_MARKUP = 'zemanta.suggest_markup';
	const METHOD_PREFERENCES    = 'zemanta.preferences';

	/**
	 * @var string The api key provided by Zemanta service
	 */
	protected $apiKey;

	/**
	 * The constructor
	 *
	 * @param string $apiKey API key for Zemanta request
	 * @param string $endPoint API service URL
	 */
	public function __construct($apiKey, $endPoint = '')
	{
		$this->apiKey = $apiKey;		
		$this->endPoint = $endPoint ? $endPoint : self::END_POINT;
	}

	/**
	 * @return string
	 */
	public function getEndPoint()
	{
		return $this->endPoint;
	}

	/**
	 * Query Zemanta service for suggestions or markup, format other than XML. 
	 * Other supported formats: JSON, WJSON, RDF/XML
	 *
	 * The arguments could be a string with api method and/or array of parameters. 
	 * Usage:
	 *
	 * <code>
	 * // String method and parameters
	 * $zemanta = new Zemanta('your_apiKey');
	 * $zemanta->method('zemanta.suggest', array('text' => ''));
	 * 
	 * // String method, text and parameters
	 * $zemanta->method('zemanta.suggest', 'Your text', array('parameters'));
     *
	 * // Array parameters
	 * $zemanta->api(array('method' => 'zemanta.suggest', 'text' => 'Your text'));
	 * </code>
	 *
	 * @param string|array
	 *
	 * @return array
	 */
	public function api()
	{
		// Map arguments
		$parameters = array();
		$args  = func_get_args();

		switch (func_num_args()) {
			case 3:
				$parameters = $args[2];
				$parameters['text']  == $args[1];				
				$parameters['method'] = $args[0];
				break;
			case 2:
				$parameters = $args[1];			
				$parameters['method'] = $args[0];
				break;
			case 1:
				$parameters = $args[0];
				break;
			case 0:
			default: 
				throw new \InvalidArgumentException('No parameters to build query from');
		}

		// Set default return format. It must be necessary to parse raw response
		if (!isset($parameters['format'])) {
			$parameters['format'] = 'xml';
		}		
		$response  = $this->getRaw($parameters);
		$returnValue = array();

		if ($parameters['format'] == 'json') {
			$returnValue = json_decode($response, true);
		}

		// // Parse response
		// switch ($parameters['format']) {
		// 	case 'rdf':
		// 	case 'xml':
		// 		break;
		// 	case 'wdjson':
		// 	case 'json':
		// 		$this->parseJSON($response);
		// }


		return $returnValue;
	}

	/**
	 * Request API method, format other than XML. 
	 * Other supported formats: JSON, WJSON, RDF/XML
	 *
	 * The argument must be an array with method and other
     *
     * @param array $parameters
     *
     * @return string
	 */
	public function getRaw($parameters = array())
	{
		// Validating method
		if (!isset($parameters['method'])) {
			throw new \InvalidArgumentException('No method to request');			
		}

		// Validating method text
		if ($parameters['method'] == static::METHOD_SUGGEST || $parameters['method'] == static::METHOD_SUGGEST_MARKUP) {
			if (!isset($parameters['text'])) {
				throw new \InvalidArgumentException('No text to analyse');
			}
		}
		$parameters['api_key'] = $this->apiKey;		

		// Set default return format
		if (!isset($parameters['format'])) {
			$parameters['format'] = 'xml';
		}

		// Validating format
		if (!preg_match("/^(xml|json|wnjson|rdfxml)$/", $parameters['format'])) {
			throw new \InvalidArgumentException(sprintf( 'Format %s is not supported', $parameters['format']) );
		}

		// Preparing and make request
		$response = $this->makeRequest($this->endPoint, $parameters);

		return $response;
	}

	/**
	 * @param string $url
	 *
	 * @return string
	 */
	protected function makeRequest($url, $params = array())
	{		
		$content  = http_build_query($params);		
		$context = stream_context_create(array(
			'http' => array(
				'method' => 'POST',
				'header' => "Content-type: application/x-www-form-urlencoded\r\n"
				  		  . "Content-length: " . strlen($content) . "\r\n",
				'content' => $content
			)
		));

		$result = file_get_contents($url, false, $context);

		return $result;
	}
}