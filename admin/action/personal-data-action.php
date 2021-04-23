<?php
include_once "../../common/connection/pdoconnection.class.php";
include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/internalcontroller.class.php';
include_once '../../common/controller/imageuploadcontroller.class.php';
include_once '../../common/controller/postregistrationcontroller.class.php';
include_once '../../common/dao/basedao.class.php';
include_once '../../common/dao/professionaldao.class.php';
include_once '../../common/model/basemodel.class.php';
include_once '../../common/model/professional.class.php';
include_once '../../common/resources/strings.php';
include_once '../../common/resources/success-codes.php';
include_once '../../common/resources/error-codes.php';

if (isset($_POST['name']) && isset($_POST['phone'])) {
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    if (empty($name) || mb_strlen($name, 'utf8') > 50) {
        header('location:'.BASE_ADMIN_URL.'aboutMe/err='.INVALID_NAME);
    } else if (empty($phone)) {
        header('location:'.BASE_ADMIN_URL.'aboutMe/err='.INVALID_PHONE);
    } else {
        $phone = str_replace(
            " ", "", str_replace(
                "-", "", $phone
            )
        );

        $size = mb_strlen($phone, 'utf8');

        if ($size > 11 || $size < 10) {
            header('location:'.BASE_ADMIN_URL.'aboutMe/err='.INVALID_PHONE);

            return;
        }

        $controller = new PostRegistrationController(new PDOConnection());

        $professional = new Professional();

        $professional->name = filter_var($name, FILTER_SANITIZE_SPECIAL_CHARS);
        $professional->phone = $phone;

        $controller->setProfessional($professional);

        $controller->saveProfessional();

        $controller->saveFile(isset($_POST['img-url']) ? $_POST['img-url'] : null);

        $sessionIndex = SESSION_PREFIX.$_COOKIE[COOKIE_INDEX];

        unset($_SESSION[$sessionIndex]);

        $_SESSION[$sessionIndex] = serialize($controller->getProfessional());

        header('location:'.BASE_ADMIN_URL);
    }
} else {
    header('location:'.BASE_ADMIN_URL.'aboutMe/');
}
