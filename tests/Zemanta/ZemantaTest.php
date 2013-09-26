<?php

namespace Zemanta;

class ZemantaTest extends \Zemanta\TestCase
{
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

    public function testRequestInvalidParametersNoMethod() 
    {
        $this->setExpectedException('\InvalidArgumentException');
        $zemanta = new Zemanta($this->apiKey);
        $zemanta->request(array());
    }

    public function testRequestInvalidParametersNoText() 
    {
        $this->setExpectedException('\InvalidArgumentException');
        $zemanta = new Zemanta($this->apiKey);
        $zemanta->request(array('method' => Zemanta::METHOD_SUGGEST));
    }

    public function testRequestInvalidFormat()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $zemanta = new Zemanta($this->apiKey);
        $zemanta->request(array('method' => Zemanta::METHOD_PREFERENCES, 'format' => 'asp'));
    }

    public function testRequest()
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

        $response = $zemanta->request($params);

        $this->assertInstanceOf('\Zemanta\Response', $response);
        $this->assertEquals($expectedResponse, $response);
    }

    public function testApiInvalidArguments()
    {
        $this->setExpectedException('\InvalidArgumentException');
        $zemanta = new Zemanta($this->apiKey);      
        $zemanta->api();
    }   

    public function testApiParameters()
    {
        $params = array(
            'method' => Zemanta::METHOD_SUGGEST, 
            'text'   => 'Lorem ipsum'
        );
        $zemanta = $this->getMock('\Zemanta\Zemanta', array('request'), array($this->apiKey));
        $zemanta->expects($this->once())
                ->method('request')
                ->with($this->equalTo($params));

        $response = $zemanta->api($params);
    }

    public function testApiParametersMethodAsArgument()
    {
        $params = array(
            'method' => Zemanta::METHOD_PREFERENCES, 
            'text'   => 'Lorem ipsum',
            'format' => 'xml'
        );              
        $zemanta = $this->getMock('\Zemanta\Zemanta', array('request'), array($this->apiKey));
        $zemanta->expects($this->once())
                ->method('request')
                ->with($this->equalTo($params));

        $zemanta->api(Zemanta::METHOD_PREFERENCES, 'Lorem ipsum', $params);
    }   

    public function testApiResponse()
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

        $response = $zemanta->api($params);

        $this->assertInstanceOf('\Zemanta\Response', $response);
        $this->assertEquals($expectedResponse, $response);
    }
}