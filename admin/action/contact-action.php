<?php session_start();

include_once '../../common/resources/strings.php';
include_once '../../common/connection/pdoconnection.class.php';
include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/internalcontroller.class.php';
include_once '../../common/controller/contactcontroller.class.php';
include_once '../../common/dao/basedao.class.php';
include_once '../../common/dao/professionaldao.class.php';
include_once '../../common/model/basemodel.class.php';
include_once '../../common/model/professional.class.php';
include_once '../../common/resources/success-codes.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/util/messageutil.class.php';

$controller = new ContactController(new PDOConnection());

if (isset($_COOKIE[COOKIE_INDEX])) {
    $userId = $_COOKIE[COOKIE_INDEX];

    if (isset($_SESSION[SESSION_PREFIX.$userId])) {
        $controller->setProfessional(unserialize($_SESSION[SESSION_PREFIX.$userId]));
    } else {
        header('location:'.BASE_ADMIN_URL.'login/');

        return;
    }
} else {
    header('location:'.BASE_ADMIN_URL.'login/');

    return;
}

if (isset($_POST['phone'])) {
    $phone = filter_var(str_replace(
        " ", "", str_replace(
            "-", "", $_POST['phone']
        )
    ), FILTER_SANITIZE_SPECIAL_CHARS);

    $size = mb_strlen($phone, 'utf8');

    if ($size > 11 || $size < 10) {
        header('location:'.BASE_ADMIN_URL.'contact/err='.INVALID_PHONE);

        return;
    }

    $controller->getProfessional()->phone = $phone;
}

if (isset($_POST['linkedin'])) {
    $linkedInPrefix = "https://www.linkedin.com/in/";

    $linkedIn = filter_var(str_replace(
        $linkedInPrefix, "", $_POST['linkedin']
    ), FILTER_SANITIZE_SPECIAL_CHARS);

    if (mb_strlen($linkedIn, 'utf8') > 40 || strpos($_POST['linkedin'], $linkedInPrefix) !== 0) {
        header('location:'.BASE_ADMIN_URL.'contact/err='.INVALID_LINKEDIN);

        return;
    }

    $controller->getProfessional()->linkedin = $linkedIn;
}

if (isset($_POST['github'])) {
    if (mb_strlen($_POST['github'], 'utf8') > 60 || !preg_match("{^https://(github\.com|bitbucket\.org|gitlab\.com)/.+$}", $_POST['github'])) {
        header('location:'.BASE_ADMIN_URL.'contact/err='.INVALID_GIT);

        return;
    }

    $controller->getProfessional()->github = filter_var($_POST['github'], FILTER_SANITIZE_SPECIAL_CHARS);
}

if (isset($_POST['site'])) {
    if (mb_strlen($_POST['site'], 'utf8') > 60) {
        header('location:'.BASE_ADMIN_URL.'contact/err='.INVALID_SITE);

        return;
    }

    $controller->getProfessional()->site = filter_var($_POST['site'], FILTER_SANITIZE_SPECIAL_CHARS);
}

$controller->saveContact();

$sessionIndex = SESSION_PREFIX.$_COOKIE[COOKIE_INDEX];

unset($_SESSION[$sessionIndex]);

$_SESSION[$sessionIndex] = serialize($controller->getProfessional());

header('location:'.BASE_ADMIN_URL.'contact/suc='.CONTACT_SAVED);