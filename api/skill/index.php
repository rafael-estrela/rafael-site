<?php
include_once '../../common/util/messageutil.class.php';
include_once '../../common/resources/strings.php';
include_once '../../common/resources/success-codes.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/connection/pdoconnection.class.php';
include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/internalcontroller.class.php';
include_once '../../common/controller/skillcontroller.class.php';
include_once '../../common/dao/basedao.class.php';
include_once '../../common/dao/skilldao.class.php';
include_once '../../common/model/basemodel.class.php';
include_once '../../common/model/apimodel.class.php';
include_once '../../common/model/skill.class.php';

// VALIDATE AUTH HEADERS
header('Content-type: application/json');
$controller = new SkillController(new PDOConnection());

// RETURNS A LIST OF SKILLS
if (isset($_GET['skill'])) {
    $apiModel = new ApiModel();

    $array = $controller->getSkillsByName($_GET['skill']);

    $apiModel->code = 200;
    $apiModel->success = true;
    $apiModel->data = array_map(function($tech) { return $tech->expose(); }, $array);

    echo $apiModel->toJson();

    return;
}