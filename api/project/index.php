<?php
include_once '../../common/util/messageutil.class.php';
include_once '../../common/resources/strings.php';
include_once '../../common/resources/success-codes.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/connection/pdoconnection.class.php';
include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/internalcontroller.class.php';
include_once '../../common/controller/imageuploadcontroller.class.php';
include_once '../../common/controller/projectcontroller.class.php';
include_once '../../common/dao/basedao.class.php';
include_once '../../common/dao/portfoliodao.class.php';
include_once '../../common/model/basemodel.class.php';
include_once '../../common/model/apimodel.class.php';
include_once '../../common/model/projecttype.class.php';

// VALIDATE AUTH HEADERS
header('Content-type: application/json');
$controller = new ProjectController(new PDOConnection());

// RETURNS THE SELECTED TYPE DATA
if (isset($_GET['singleType'])) {
    $model = new ApiModel();

    $url = $controller->urlsByType($_POST['type']);

    if ($url == null) {
        $code = 400;
        http_response_code($code);
        $model->success = false;
        $model->code = $code;
        $model->error = MessageUtil::errorMessage(INVALID_PROJ_TYPE);

        echo $model->toJson();
    } else {
        $model->success = true;
        $model->code = 200;
        $model->data = $url->expose();

        echo $model->toJson();
    }

    return;
}

// RETURNS THE TYPE LIST JSON
if (isset($_GET['typeList'])) {
    $model = new ApiModel();

    $typeList = $controller->getProjectTypes();

    $array = array();

    foreach ($typeList as $type) {
        $array[] = $type->expose();
    }

    $model->code = 200;
    $model->success = true;
    $model->data = $array;

    echo $model->toJson();

    return;
}

if (isset($_GET['projectImage'])) {
    $model = new ApiModel();
    $code = 200;

    if (isset($_FILES['formData'])) {
        $file = $_FILES['formData'];

        if (!$controller->validFile($file)) {
            $code = 400;
            $model->error = MessageUtil::errorMessage(INVALID_PROJ_IMAGE);
        } else {
            $url = $controller->saveTempFile($file);
            $model->data = $url;
        }
    } else {
        $code = 400;
        $model->error = MessageUtil::errorMessage(INVALID_PROJ_IMAGE);
    }

    http_response_code($code);
    $model->success = $code == 200;
    $model->code = $code;

    echo $model->toJson();

    return;
}