<?php

class Response
{
    public $status;
    public $title;
    public $message;
    public $data;

    public function __construct(
        $status = "",
        $title = "",
        $message = "",
        $data = []
    ) {
        $this->status = $status;
        $this->title = $title;
        $this->message = $message;
        $this->data = $data;
    }
}
