<?php
include_once '../../common/resources/strings.php';

if (isset($_COOKIE[COOKIE_INDEX])) {
    header('location:'.BASE_ADMIN_URL);

    return;
}

include_once '../../common/connection/pdoconnection.class.php';
include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/externalcontroller.class.php';
include_once '../../common/controller/forgotpasswordcontroller.class.php';
include_once '../../common/dao/basedao.class.php';
include_once '../../common/dao/userdao.class.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/resources/success-codes.php';
include_once '../../common/util/registrationutil.class.php';

$controller = new ForgotPasswordController(new PDOConnection());

var_dump($_POST);

if (!isset($_POST['cid'])) {
    header('location:'.BASE_ADMIN_URL.'login/err='.INVALID_CONFIRM_ID);
} else if (!isset($_POST['newPassword']) || mb_strlen($_POST['newPassword'], 'utf8') < 6) {
    header('location:'.BASE_ADMIN_URL.'resetPassword/'.$_POST['cid'].'/err='.PASSWORD_SHORT);
} else if (!isset($_POST['confirmPassword']) || mb_strlen($_POST['confirmPassword'], 'utf8') < 6 || $_POST['newPassword'] != $_POST['confirmPassword']) {
    header('location:'.BASE_ADMIN_URL.'resetPassword/'.$_POST['cid'].'/err='.PASSWORD_MATCH);
} else {
    $newPass = RegistrationUtil::hashPassword($_POST['newPassword']);

    $code = $controller->updatePassword($_POST['cid'], $newPass);

    if ($code == ACCOUNT_CONFIRMED) {
        header('location:'.BASE_ADMIN_URL.'login/suc='.ACCOUNT_CONFIRMED);
    } else {
        header('location:'.BASE_ADMIN_URL.'login/err='.INVALID_CONFIRM_ID);
    }
}