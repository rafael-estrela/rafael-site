<?php
include_once '../../common/util/messageutil.class.php';
include_once '../../common/resources/strings.php';
include_once '../../common/resources/success-codes.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/connection/pdoconnection.class.php';
include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/internalcontroller.class.php';
include_once '../../common/controller/imageuploadcontroller.class.php';
include_once '../../common/controller/postregistrationcontroller.class.php';
include_once '../../common/dao/basedao.class.php';
include_once '../../common/dao/professionaldao.class.php';
include_once '../../common/model/basemodel.class.php';
include_once '../../common/model/apimodel.class.php';
include_once '../../common/model/professional.class.php';

// VALIDATE AUTH HEADERS
header('Content-type: application/json');
$controller = new PostRegistrationController(new PDOConnection());

if (isset($_GET['usernameAvailable'])) {
    $username = $_GET['usernameAvailable'];
    $model = new ApiModel();
    $unavailable = $controller->usernameIsTaken($username);

    if ($unavailable) {
        $model->error = MessageUtil::errorMessage(TAKEN_USERNAME);
    }

    $model->data = !$unavailable;
    $model->code = 200;

    echo $model->toJson();

    return;
}