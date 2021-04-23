<?php

class ResendEmailController {
    use ExternalController {
        ExternalController::__construct as private __ecConstruct;
    }

    public function __construct($connection) {
        $this->__ecConstruct($connection);
    }

    public function accountByEmail($email) {
        $this->validateUserDao();

        return $this->userDao->fullAccountByEmail($email);
    }

    public function resendEmail($email, $cid) {
        $this->validateUserDao();

        return Mailer::sendConfirmationEmail($cid, $email);
    }
}