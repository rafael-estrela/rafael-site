<?php

include_once '../../common/resources/strings.php';
include_once '../../common/resources/error-codes.php';

if (isset($_POST['email']) && isset($_POST['email_confirm']) && isset($_POST['password']) && isset($_POST['password_confirm'])) {
    $email = $_POST['email'];
    $emailConfirm = $_POST['email_confirm'];
    $password = $_POST['password'];
    $confirm = $_POST['password_confirm'];

    if (filter_var($email, FILTER_VALIDATE_EMAIL) && !empty($email) && mb_strlen($email, 'utf8') <= 100) {
        include_once "../../common/connection/pdoconnection.class.php";
        include_once '../../common/controller/basecontroller.class.php';
        include_once '../../common/controller/externalcontroller.class.php';
        include_once '../../common/controller/registrationcontroller.class.php';
        include_once '../../common/dao/basedao.class.php';
        include_once '../../common/dao/userdao.class.php';
        include_once '../../common/resources/success-codes.php';
        include_once '../../common/util/registrationutil.class.php';
        include_once '../../composer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
        include_once '../../composer/vendor/phpmailer/phpmailer/src/Exception.php';
        include_once '../../composer/vendor/phpmailer/phpmailer/src/SMTP.php';
        include_once '../../composer/vendor/phpmailer/phpmailer/language/phpmailer.lang-pt_br.php';
        include_once '../mailer/mailer.class.php';

        $controller = new RegistrationController(new PDOConnection());

        if ($controller->alreadyRegistered($email)) {
            header('location:'.BASE_ADMIN_URL.'login/suc='.ACCOUNT_EXISTS);
        } else {
            if (mb_strlen($password, 'utf8') < 6) {
                header('location:'.BASE_ADMIN_URL.'register/err='.PASSWORD_SHORT);
            } else if ($password != $confirm) {
                header('location:'.BASE_ADMIN_URL.'register/err='.PASSWORD_MATCH);
            } else if ($email != $emailConfirm) {
                header('location:'.BASE_ADMIN_URL.'register/err='.EMAIL_MATCH);
            } else {
                $cid = RegistrationUtil::confirmationId($email);

                $sent = Mailer::sendConfirmationEmail($cid, $email);

                if ($sent) {
                    $controller->registerUser(
                        $email,
                        RegistrationUtil::hashPassword($password)
                    );

                    header('location:'.BASE_ADMIN_URL.'login/suc='.ACCOUNT_CREATED);
                } else {
                    header('location:'.BASE_ADMIN_URL.'register/err='.ACC_CREATE_FAIL);
                }
            }
        }
    } else {
        header('location:'.BASE_ADMIN_URL.'register/err='.INVALID_EMAIL);
    }
} else {
    header('location:'.BASE_ADMIN_URL.'register/');
}
