<?php

namespace Alex\ManagementSystem\database;

class Connection
{
    private $hostname = "localhost";
    private $database = "bankchange";
    private $user = "root";
    private $password = "";

    public function __construct()
    {
        return new mysqli($this->hostname, $this->user, $this->password, $this->database);
    }
}
