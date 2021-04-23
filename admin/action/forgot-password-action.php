<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once '../../common/resources/strings.php';

if (isset($_COOKIE[COOKIE_INDEX])) {
    header('location:'.BASE_ADMIN_URL);
} else {
    include_once '../../common/connection/pdoconnection.class.php';
    include_once '../../common/controller/basecontroller.class.php';
    include_once '../../common/controller/externalcontroller.class.php';
    include_once '../../common/controller/forgotpasswordcontroller.class.php';
    include_once '../../common/dao/basedao.class.php';
    include_once '../../common/dao/userdao.class.php';
    include_once '../../common/resources/error-codes.php';
    include_once '../../common/resources/error-codes.php';
    include_once '../../common/resources/success-codes.php';
    include_once '../../common/util/forgotpasswordutil.class.php';
    include_once '../../composer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
    include_once '../../composer/vendor/phpmailer/phpmailer/src/SMTP.php';
    include_once '../../composer/vendor/phpmailer/phpmailer/language/phpmailer.lang-pt_br.php';
    include_once '../mailer/mailer.class.php';

    if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email = $_POST['email'];

        $controller = new ForgotPasswordController(new PDOConnection());

        $id = $controller->accountByEmail($email);

        if ($id == null) {
            header('location:'.BASE_ADMIN_URL.'forgotPassword/err='.UNEXISTENT_ACCOUNT);
        } else {
            $cid = $controller->generateResetPasswordCode($id, $email);

            $sent = Mailer::sendResetPasswordEmail($cid, $email);

            if ($sent) {
                header('location:'.BASE_ADMIN_URL.'forgotPassword/suc='.FORGOT_LINK_SENT);
            } else {
                header('location:'.BASE_ADMIN_URL.'forgotPassword/err='.FORGOT_LINK_FAIL);
            }
        }
    } else {
        header('location:'.BASE_ADMIN_URL.'forgotPassword/err='.INVALID_EMAIL);
    }
}