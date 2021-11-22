<?php

class Endpoint {
    public string $url;
    public string $target;

    public function __construct(array $url) {
        $this->url = $url[0] ?? "";
        $this->target = $url[1] ?? "";
    }
}