<?php

namespace Zemanta;

class Response
{
    /**
     * Response formats
     */
    const FORMAT_JSON            = 'json';
    const FORMAT_RDF             = 'xmlrdf';
    const FORMAT_XML             = 'xml';
    const FORMAT_WNJSON          = 'wnjson';

    /**
     * @var string
     */
    protected $body;

    /**
     * @param 
     */
    protected $format;

    /**
     * @param string $body
     * @param string $format
     */
    public function __construct($body, $format = self::FORMAT_XML)
    {
        $this->body   = $body;
        $this->format = $format;
    }

    /**
     * @return array
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->body;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        if ($this->format != static::FORMAT_JSON) {
            throw new \RuntimeException( 'Export to array is only supported by JSON format' );
        }

        return json_decode($this->body, true);
    }
}
