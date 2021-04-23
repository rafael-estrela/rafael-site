<?php

class ForgotPasswordController {
    use ExternalController {
        ExternalController::__construct as private __ecConstruct;
    }

    public function __construct($connection) {
        $this->__ecConstruct($connection);
    }

    public function accountByEmail($email) {
        $this->validateUserDao();

        return $this->userDao->accountByEmail($email);
    }

    public function userByPasswordCid($cid) {
        $this->validateUserDao();

        return $this->userDao->accountByPasswordCid($cid);
    }

    public function updatePassword($cid, $newPass) {
        $this->validateUserDao();

        return $this->userDao->updateUserPassword($cid, $newPass);
    }

    public function generateResetPasswordCode($userId, $email) {
        $this->validateUserDao();

        $cid = ForgotPasswordUtil::resetPasswordCode($userId, $email);

        $this->userDao->saveResetPasswordCode($userId, $cid);

        return $cid;
    }
}