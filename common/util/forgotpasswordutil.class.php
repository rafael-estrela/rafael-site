<?php

class ForgotPasswordUtil {
    public static function resetPasswordCode($userId, $email) {
        $cid = RESET_SALT_HEAD.$userId.$email.date('dmYHis');

        return md5($cid);
    }
}