<?php
include_once '../../common/connection/pdoconnection.class.php';
include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/internalcontroller.class.php';
include_once '../../common/controller/homecontroller.class.php';
include_once '../../common/dao/basedao.class.php';
include_once '../../common/dao/professionaldao.class.php';
include_once '../../common/model/basemodel.class.php';
include_once '../../common/model/professional.class.php';
include_once '../../common/model/chart.class.php';
include_once '../../common/model/access.class.php';
include_once '../../common/model/apimodel.class.php';
include_once '../../common/resources/success-codes.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/resources/strings.php';
include_once '../../common/util/messageutil.class.php';
include_once '../../common/util/historyutils.class.php';

// VALIDATE AUTH HEADERS
header('Content-type: application/json');
$controller = new HomeController(new PDOConnection());

// RETURNS THE SELECTED TYPE DATA
if (isset($_GET['chart'])) {
    $model = new ApiModel();

    $history = $controller->getAccessHistory();

    $model->data = $history->expose();
    $model->success = true;
    $model->code = 200;

    echo $model->toJson();

    return;
}