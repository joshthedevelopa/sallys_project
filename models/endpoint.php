<?php

class Endpoint
{
    public $url;
    public $target;

    public function __construct($url)
    {
        $this->url = $url[0] ?? "";
        $this->target = $url[1] ?? "";
    }
}

