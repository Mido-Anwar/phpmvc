<?php

namespace System;

class Session
{
    /**
     * 
     * @var \System\Application
     */
    private $app;

    /**
     * Constructor
     * 
     * @param System\Application $app
     */

    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    public function set($key, $value)
    {
        echo $key . '=>' . $value;
    }
}
