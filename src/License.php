<?php

namespace GeeksAreForLife\Inspector;

class License
{
    /**
     * Name of the license
     * @var string
     */
    private $name;

    /**
     * [$code description]
     * @var string
     */
    private $code;

    /**
     * Version of the license
     * @var string
     */
    private $version;

    public function __construct($code) 
    {
        $this->code = $code;
    }

    public function getCode()
    {
        return $this->code;
    }
}