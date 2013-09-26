<?php

namespace Zemanta;

class TestCase extends \PHPUnit_Framework_TestCase
{
    protected $apiKey;
    protected $defaultParams;

    public function setUp()
    {
        $this->apiKey = md5(time());
    }

    protected function getResponseFixture($file)
    {
        return file_get_contents(__DIR__ . '/Resources/' . $file);
    }    

    protected function getResponseArrayFixture($file = 'response.php')
    {
        return require __DIR__ . '/Resources/' . $file;
    }
}