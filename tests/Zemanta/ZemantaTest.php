<?php

namespace Zemanta;

class ZemantaTest extends \PHPUnit_Framework_TestCase
{
	protected $apiKey;
	protected $defaultParams;

	public function setUp()
	{
		$this->apiKey = md5(time());
	}

	public function testApiKey()
	{
		$zemanta = new Zemanta($this->apiKey);

		$this->assertAttributeEquals($this->apiKey, 'apiKey', $zemanta);
	}

	public function testEndPoint()
	{
		$endPoint = Zemanta::END_POINT;		
		$zemanta = new Zemanta($this->apiKey);

		$this->assertAttributeEquals($endPoint, 'endPoint', $zemanta);
		$this->assertEquals($endPoint, $zemanta->getEndPoint());
	}

	public function testEndPointCustomized()
	{
		$endPoint = 'http://api.zemanta.com/rest/' . time();
		$zemanta = new Zemanta($this->apiKey, $endPoint);

		$this->assertAttributeEquals($endPoint, 'endPoint', $zemanta);
		$this->assertEquals($endPoint, $zemanta->getEndPoint());
	}

	public function testGetRawInvalidParametersNoMethod() 
	{
		$this->setExpectedException('\InvalidArgumentException');
		$zemanta = new Zemanta($this->apiKey);
		$zemanta->getRaw(array());
	}

	public function testGetRawInvalidParametersNoText() 
	{
		$this->setExpectedException('\InvalidArgumentException');
		$zemanta = new Zemanta($this->apiKey);
		$zemanta->getRaw(array('method' => Zemanta::METHOD_SUGGEST));
	}

	public function testGetRawInvalidFormat()
	{
		$this->setExpectedException('\InvalidArgumentException');
		$zemanta = new Zemanta($this->apiKey);
		$zemanta->getRaw(array('method' => Zemanta::METHOD_PREFERENCES, 'format' => 'asp'));
	}

	public function testGetRaw()
	{
		$params = array(
			'method' => Zemanta::METHOD_SUGGEST, 
			'text'   => 'Lorem ipsum'			
		);		
		$requestParams = array_merge($params, array('api_key' => $this->apiKey, 'format' => 'xml'));

		$requestUrl = Zemanta::END_POINT;
		$expectedResponse = '<rsp><status>ok</status></rsp>';

		$zemanta = $this->getMock('\Zemanta\Zemanta', array('makeRequest'), array($this->apiKey));
		$zemanta->expects($this->once())
				->method('makeRequest')
				->with($requestUrl, $requestParams)
				->will($this->returnValue($expectedResponse));

		$response = $zemanta->getRaw($params);

		$this->assertInternalType('string', $response);
		$this->assertEquals($expectedResponse, $response);
	}

	public function testApiInvalidArguments()
	{
		$this->setExpectedException('\InvalidArgumentException');
		$zemanta = new Zemanta($this->apiKey);		
		$zemanta->api();
	}	

	public function testApi()
	{
		$params = array(
			'method' => Zemanta::METHOD_SUGGEST, 
			'text'   => 'Lorem ipsum',
			'format' => 'xml'
		);
		$zemanta = $this->getMock('\Zemanta\Zemanta', array('getRaw'), array($this->apiKey));
		$zemanta->expects($this->once())
				->method('getRaw')
				->with($this->equalTo($params));

		unset($params['format']);

		$response = $zemanta->api($params);

		$this->assertInternalType('array', $response);
	}

	public function testApiMethodArgument()
	{
		$params = array(
			'method' => Zemanta::METHOD_PREFERENCES, 
			'text'   => 'Lorem ipsum',
			'format' => 'xml'
		);				
		$zemanta = $this->getMock('\Zemanta\Zemanta', array('getRaw'), array($this->apiKey));
		$zemanta->expects($this->once())
				->method('getRaw')
				->with($this->equalTo($params));

		$response = $zemanta->api(Zemanta::METHOD_PREFERENCES, 'text', $params);

		$this->assertInternalType('array', $response);
	}	

	// Test parse response XML, WJSON, JSON, RDF
	public function testApiParseXML()
	{		
		$params = array(
			'method' => Zemanta::METHOD_SUGGEST, 
			'text'   => 'Lorem ipsum',
			'format' => 'json'
		);						
		$json = $this->getResponseFixture('suggest.json');		

		$zemanta = $this->getMock('\Zemanta\Zemanta', array('makeRequest'), array($this->apiKey));
		$zemanta->expects($this->once())
				->method('makeRequest')
				->will($this->returnValue($json));
				
		$response = $zemanta->api($params);

		$this->assertInternalType('array', $response);
		$this->assertArrayHasKey('status', $response);
		$this->assertArrayHasKey('articles', $response);
	}	

	protected function getResponseFixture($file)
	{
		return file_get_contents(__DIR__ . '/Resources/' . $file);
	}
}