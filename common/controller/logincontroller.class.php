<?php

class LoginController {
    use ExternalController {
        ExternalController::__construct as private __ecConstruct;
    }

    private $id;

    public function __construct($connection) {
        $this->__ecConstruct($connection);
    }

    public function performLogin($email, $pass) {
        $this->validateUserDao();

        $this->id = $this->userDao->login($email, $pass);
    }

    public function getId() {
        return $this->id;
    }
}