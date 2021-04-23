<?php

trait BaseController {
    private $connection;

    public function __construct($connection) {
        $this->connection = $connection;
    }

    public function __destruct() {
        $this->connection = null;
    }
}