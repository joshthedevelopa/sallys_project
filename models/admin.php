<?php

class Admin extends User {
    public function __construct()
    {
        parent::__construct("admins");
    }

}