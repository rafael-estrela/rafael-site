<?php

trait ExternalController {
    use BaseController {
        BaseController::__construct as private __bcConstruct;
    }

    private $userDao;

    public function __construct($connection) {
        $this->__bcConstruct($connection);
    }

    private function validateUserDao() {
        if ($this->userDao == null)
            $this->userDao = new UserDAO($this->connection);
    }
}