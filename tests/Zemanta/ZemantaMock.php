<?php

namespace Zemanta;

class ZemantaMock extends Zemanta
{
    public function makeRequest($url, $params = array())
    {
        $responses = array(
            'json'   => 'suggest.json',
            'rdfxml' => 'suggest.rdf.xml',
            'xml'    => 'suggest.xml',
            'wnjson' => 'suggest.wnjson.html'
        );
        $resource = $responses[$params['format']];

        return file_get_contents(__DIR__ . '/Resources/' . $resource);
    }
}