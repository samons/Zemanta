<?php

namespace Zemanta;

use Zemanta\Response;

class ResponseTest extends \Zemanta\TestCase
{
    public function testConstruct()
    {
        $body = '<response><status>ok</status></response>';
        $format = Response::FORMAT_XML;
        $response = new Response($body, $format);

        $this->assertAttributeEquals($body, 'body', $response);
        $this->assertAttributeEquals($format, 'format', $response);
        $this->assertEquals($body, $response->getBody());
        $this->assertEquals($format, $response->getFormat());
        $this->assertEquals($body, $response->__toString());
    }

    /**
     * @dataProvider responseFormats
     */
    public function testToArray($body, $format)
    {       
        $response = new Response($body, $format);
        $toArray = $response->toArray();

        $this->assertEquals($body, $response->getBody());
        $this->assertEquals($this->getResponseArrayFixture(), $toArray);
    }       

    public function responseFormats()
    {
        return array(
            array($this->getResponseFixture('suggest.json'), Response::FORMAT_JSON)
        );
    }    
}