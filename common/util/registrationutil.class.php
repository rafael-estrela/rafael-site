<?php

class RegistrationUtil {
    public static function hashPassword($password) {
        return md5(SALT_HEAD.$password.SALT_TAIL);
    }

    public static function confirmationId($email) {
        return md5(CONFIRM_SALT_HEAD.$email.CONFIRM_SALT_TAIL);
    }
}