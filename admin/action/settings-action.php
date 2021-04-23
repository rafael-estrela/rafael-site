<?php session_start();

include_once '../../common/resources/strings.php';
include_once "../../common/connection/pdoconnection.class.php";
include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/internalcontroller.class.php';
include_once '../../common/controller/imageuploadcontroller.class.php';
include_once '../../common/controller/postregistrationcontroller.class.php';
include_once '../../common/dao/basedao.class.php';
include_once '../../common/dao/professionaldao.class.php';
include_once '../../common/model/basemodel.class.php';
include_once '../../common/model/professional.class.php';
include_once '../../common/resources/success-codes.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/util/registrationutil.class.php';

$controller = new PostRegistrationController(new PDOConnection());

if (isset($_COOKIE[COOKIE_INDEX])) {
    $userId = $_COOKIE[COOKIE_INDEX];

    if (isset($_SESSION[SESSION_PREFIX.$userId])) {
        $controller->setProfessional(unserialize($_SESSION[SESSION_PREFIX.$userId]));
    } else {
        header('location:../login/');

        return;
    }
} else {
    header('location:../login/');

    return;
}

if (isset($_POST['name']) && isset($_POST['username']) && isset($_POST['palette'])) {
    $name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_SPECIAL_CHARS);
    $palette = $_POST['palette'];

    if (empty($name) || mb_strlen($name, 'utf8') > 50) {
        header('location:'.BASE_ADMIN_URL.'settings/err='.INVALID_NAME);
    } else if (empty($username) || !preg_match("/^[a-zA-Z0-9_\.-]{1,32}$/", $username)) {
        header('location:'.BASE_ADMIN_URL.'settings/err='.INVALID_USERNAME);
    } else if ($controller->usernameIsTaken($username)) {
        header('location:' . BASE_ADMIN_URL . 'settings/err=' . TAKEN_USERNAME);
    } else if (empty($palette)) {
        header('location:' . BASE_ADMIN_URL . 'settings/err=' . INVALID_PALETTE);
    } else {
        $controller->getProfessional()->name = $name;
        $controller->getProfessional()->username = $username;
        $controller->getProfessional()->palette = $palette;

        $controller->updateProfessional();

        if (isset($_POST['img-url'])) {
            $imgUrl = $_POST['img-url'];
            
            if ($controller->getProfessional()->picture != $imgUrl) {
                $controller->saveFile($imgUrl);
            }
        } else {
            $controller->saveFile(null);
        }

        $sessionIndex = SESSION_PREFIX.$_COOKIE[COOKIE_INDEX];

        unset($_SESSION[$sessionIndex]);

        $_SESSION[$sessionIndex] = serialize($controller->getProfessional());

        header('location:'.BASE_ADMIN_URL.'settings/suc='.SETTINGS_SAVED);
    }
} else if (isset($_POST['oldPassword']) && isset($_POST['newPassword']) && isset($_POST['confirmPassword'])) {
    $oldPass = $_POST['oldPassword'];
    $newPass = $_POST['newPassword'];
    $confirmPass = $_POST['confirmPassword'];

    if (!$controller->matchUserPassword(RegistrationUtil::hashPassword($oldPass))) {
        header('location:'.BASE_ADMIN_URL.'settings/err='.OLD_PASSWORD_WRONG);
    } else if (mb_strlen($newPass, 'utf8') < 6) {
        header('location:'.BASE_ADMIN_URL.'settings/err='.PASSWORD_SHORT);
    } else if ($newPass != $confirmPass) {
        header('location:'.BASE_ADMIN_URL.'settings/err='.PASSWORD_MATCH);
    } else {
        $newPassword = RegistrationUtil::hashPassword($newPass);

        $controller->updateUserPassword($newPassword);

        header('location:'.BASE_ADMIN_URL.'settings/suc='.SETTINGS_PASSWORD_SAVED);
    }
} else {
    header('location:'.BASE_ADMIN_URL.'settings/');
}