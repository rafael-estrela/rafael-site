<?php session_start();

if (isset($_POST['email']) && isset($_POST['password'])) {
    include_once "../../common/connection/pdoconnection.class.php";
    include_once '../../common/controller/basecontroller.class.php';
    include_once '../../common/controller/externalcontroller.class.php';
    include_once '../../common/controller/logincontroller.class.php';
    include_once '../../common/resources/error-codes.php';
    include_once '../../common/resources/strings.php';
    include_once '../../common/dao/basedao.class.php';
    include_once '../../common/dao/userdao.class.php';
    include_once '../../common/util/registrationutil.class.php';

    $controller = new LoginController(new PDOConnection());

    $pass = RegistrationUtil::hashPassword($_POST['password']);

    $controller->performLogin($_POST['email'], $pass);

    $id = $controller->getId();

    if ($id == -1) {
        header('location:' . BASE_ADMIN_URL . 'login/err=' . INVALID_AUTHENTICATION);
    } else if ($id == -2) {
        header('location:' . BASE_ADMIN_URL . 'login/err=' . MUST_CONFIRM);
    } else {
        if (isset($_POST['remember_me'])) {
            setcookie(COOKIE_INDEX, $controller->getId(), time() + 60 * 60 * 24 * 30, "/");
        } else {
            setcookie(COOKIE_INDEX, $controller->getId(), 0, "/");
        }

        header('location:'.BASE_ADMIN_URL.'action/postLogin/');
    }
} else {
    header('location:'.BASE_ADMIN_URL.'login/');
}