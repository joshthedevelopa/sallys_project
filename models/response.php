<?php

class Response
{
    public string $status;
    public string $title;
    public string $message;
    public array $data;

    public function __construct(
        string $status = "",
        string $title = "",
        string $message = "",
        array|Object $data = []
    ) {
        $this->status = $status;
        $this->title = $title;
        $this->message = $message;
        $this->data = $data;
    }
}
