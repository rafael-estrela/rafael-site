<?php

class RegistrationController {
    use ExternalController {
        ExternalController::__construct as private __ecConstruct;
    }

    public function __construct($connection) {
        $this->__ecConstruct($connection);
    }

    public function alreadyRegistered($email) {
        $this->validateUserDao();

        return $this->userDao->accountExists($email);
    }

    public function registerUser($email, $pass) {
        $this->validateUserDao();

        $this->userDao->createAccount($email, $pass);
    }
}