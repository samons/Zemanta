<?php

namespace Zemanta;

abstract class Response implements ArrayAccess
{
    /**
     * @param array $data
     */
    public function __construct($data = array())
    {
        $this->data = $data;
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return isset($this->data['status']) ? $this->data['status'] : static::STATUS_FAIL;
    }
}