<?php

namespace Zemanta;

class ZemantaTest extends \PHPUnit_Framework_TestCase
{
	protected $apiKey;

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
	}

	public function testEndPointCustomized()
	{
		$endPoint = 'http://api.zemanta.com/rest/' . time();
		$zemanta = new Zemanta($this->apiKey, $endPoint);

		$this->assertAttributeEquals($endPoint, 'endPoint', $zemanta);
	}

	public function testApiInvalidArguments()
	{
		$zemanta = new Zemanta($this->apiKey);
	}
}