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
    include_once '../../common/controller/resendemailcontroller.class.php';
    include_once '../../common/dao/basedao.class.php';
    include_once '../../common/dao/userdao.class.php';
    include_once '../../common/model/basemodel.class.php';
    include_once '../../common/model/user.class.php';
    include_once '../../common/resources/error-codes.php';
    include_once '../../common/resources/success-codes.php';
    include_once '../../composer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
    include_once '../../composer/vendor/phpmailer/phpmailer/src/SMTP.php';
    include_once '../../composer/vendor/phpmailer/phpmailer/language/phpmailer.lang-pt_br.php';
    include_once '../mailer/mailer.class.php';

    if (isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $email = $_POST['email'];

        $controller = new ResendEmailController(new PDOConnection());

        $account = $controller->accountByEmail($email);

        if ($account == null) {
            header('location:'.BASE_ADMIN_URL.'resendEmail/err='.RESEND_EMAIL_UNEXISTENT);
        } else if ($account->confirmed) {
            header('location:'.BASE_ADMIN_URL.'resendEmail/err='.RESEND_EMAIL_CONFIRMED);
        } else {
            $sent = $controller->resendEmail($account->email, $account->confirmationId);
            
            if ($sent) {
                header('location:'.BASE_ADMIN_URL.'resendEmail/suc='.RESEND_EMAIL);
            } else {
                header('location:'.BASE_ADMIN_URL.'resendEmail/err='.FORGOT_LINK_FAIL);
            }
        }
    } else {
        header('location:'.BASE_ADMIN_URL.'resendEmail/err='.INVALID_EMAIL);
    }
}