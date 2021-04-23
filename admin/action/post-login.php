<?php session_start();

include_once '../../common/resources/strings.php';
include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/internalcontroller.class.php';
include_once '../../common/controller/homecontroller.class.php';
include_once '../../common/connection/pdoconnection.class.php';
include_once '../../common/dao/basedao.class.php';
include_once '../../common/dao/professionaldao.class.php';
include_once '../../common/model/basemodel.class.php';
include_once '../../common/model/professional.class.php';
include_once '../../common/model/graduation.class.php';
include_once '../../common/model/work.class.php';

$controller = new HomeController(new PDOConnection());

$controller->getUserById();

if ($controller->getProfessional() == null) {
    header('location:'.BASE_ADMIN_URL.'aboutMe/');
} else {
    $_SESSION[SESSION_PREFIX.$controller->getUserId()] = serialize($controller->getProfessional());

    header('location:'.BASE_ADMIN_URL);
}

