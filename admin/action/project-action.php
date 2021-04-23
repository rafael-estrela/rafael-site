<?php session_start();

include_once '../../common/resources/strings.php';
include_once '../../common/connection/pdoconnection.class.php';
include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/internalcontroller.class.php';
include_once '../../common/controller/imageuploadcontroller.class.php';
include_once '../../common/controller/projectcontroller.class.php';
include_once '../../common/dao/basedao.class.php';
include_once '../../common/dao/portfoliodao.class.php';
include_once '../../common/model/basemodel.class.php';
include_once '../../common/model/professional.class.php';
include_once '../../common/model/project.class.php';
include_once '../../common/model/projectlink.class.php';
include_once '../../common/model/projecttype.class.php';
include_once '../../common/resources/success-codes.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/util/messageutil.class.php';

$controller = new ProjectController(new PDOConnection());

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

if (isset($_GET['del'])) {
    $id = $_GET['del'];
    $controller->getProjectById($id);

    if ($controller->getProject() == null) {
        header('location:'.BASE_ADMIN_URL.'project/err='.UNEXISTENT_PROJ);
    } else {
        $controller->deleteProject($id);

        header('location:'.BASE_ADMIN_URL.'project/suc='.PROJ_DELETED);
    }

    return;
}

$baseErr = 'location:'.BASE_ADMIN_URL.'project';

if (isset($_POST['id'])) {
    $controller->getProjectById($_POST['id']);

    if ($controller->getProject() == null) {
        header('location:'.BASE_ADMIN_URL.'project/err='.UNEXISTENT_PROJ);

        return;
    }

    $baseErr = $baseErr.'/'.$_POST['id'];
}

$baseErr = $baseErr.'/err=';

if (empty($_POST['name']) || mb_strlen($_POST['name'], 'utf8') > 100) {
    header($baseErr.INVALID_PROJ_NAME);
} else if (empty($_POST['description']) || mb_strlen($_POST['description'], 'utf8') > 300) {
    header($baseErr.INVALID_PROJ_DESC);
} else {
    if (!isset($_POST['id'])) {
        $controller->setProject(new Project());
    }

    $controller->getProject()->name = filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS);
    $controller->getProject()->description = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);
    $controller->getProject()->visible = !isset($_POST['visible']);

    $id = 1;
    $links = array();

    while(isset($_POST["type-select-$id"]) && isset($_POST["proj-link-$id"])) {
        $typeId = $_POST["type-select-$id"];
        $typeUrl = filter_var($_POST["proj-link-$id"], FILTER_SANITIZE_SPECIAL_CHARS);

        $type = $controller->typeById($typeId);

        if ($type == null) {
            header($baseErr.INVALID_PROJ_TYPE);

            return;
        } else if (empty($typeUrl) || mb_strlen($typeUrl, 'utf8') > mb_strlen($type->baseUrl, 'utf8') + 100) {
            header($baseErr.INVALID_PROJ_URL);

            return;
        }

        $link = new ProjectLink();

        if (isset($_POST["link-id-$id"]))
            $link->id = $_POST["link-id-$id"];

        $link->url = $typeUrl;
        $link->type = $type;
        $link->url = str_replace($link->type->baseUrl, '', $link->url);

        $links[] = $link;

        $id++;
    }

    $controller->getProject()->links = $links;

    $base = 'location:'.BASE_ADMIN_URL.'project';
    $code = 0;

    if (isset($_POST['id'])) {
        $base = $base.'/'.$_POST['id'];
        $controller->getProject()->id = $_POST['id'];

        $controller->updateProject();

        $code = PROJ_UPDATED;
    } else {
        $userId = $_COOKIE[COOKIE_INDEX];

        $controller->saveProject($userId);

        $code = PROJ_SAVED;
    }

    if (isset($_POST['img-url'])) {
        $imgUrl = $_POST['img-url'];
        
        if ($controller->getProject()->image != $imgUrl) {
            $controller->saveFile($imgUrl);
        }
    } else {
        $controller->saveFile(null);
    }

    header($base.'/suc='.$code);
}