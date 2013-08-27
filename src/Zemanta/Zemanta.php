<?php

namespace Zemanta;

class Zemanta
{
	/**
	 * Default URL endpoint to Zemanta REST API
	 */
	const END_POINT = 'api.zemanta.com/services/rest/0.0';

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
		// TODO
	}
}