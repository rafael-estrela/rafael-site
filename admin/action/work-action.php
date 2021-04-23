<?php session_start();

include_once '../../common/resources/strings.php';
include_once '../../common/connection/pdoconnection.class.php';
include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/internalcontroller.class.php';
include_once '../../common/controller/imageuploadcontroller.class.php';
include_once '../../common/controller/workcontroller.class.php';
include_once '../../common/dao/basedao.class.php';
include_once '../../common/dao/workdao.class.php';
include_once '../../common/model/basemodel.class.php';
include_once '../../common/model/work.class.php';
include_once '../../common/resources/success-codes.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/util/messageutil.class.php';
include_once '../../common/util/dateutils.class.php';

$controller = new WorkController(new PDOConnection());

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

    $controller->getWorkById($id);

    if ($controller->getWork() == null) {
        header('location:'.BASE_ADMIN_URL.'work/err='.UNEXISTENT_WORK);
    } else {
        $controller->deleteWork($_GET['del']);

        header('location:'.BASE_ADMIN_URL.'work/suc='.WORK_DELETED);
    }

    return;
}

$baseErr = 'location:'.BASE_ADMIN_URL.'work';

if (isset($_POST['id'])) {
    $controller->getWorkById($_POST['id']);

    if ($controller->getWork() == null) {
        header('location:'.BASE_ADMIN_URL.'work/err='.UNEXISTENT_WORK);

        return;
    }

    $baseErr = $baseErr.'/'.$_POST['id'];
}

$baseErr = $baseErr.'/err=';

if (empty($_POST['position']) || mb_strlen($_POST['position'], 'utf8') > 50) {
    header($baseErr.INVALID_WORK_POSITION);
} else if (empty($_POST['company']) || mb_strlen($_POST['company'], 'utf8') > 100) {
    header($baseErr . INVALID_WORK_COMPANY);
} else if (empty($_POST['description']) || mb_strlen($_POST['description'], 'utf8') > 300) {
    header($baseErr . INVALID_WORK_DESCRIPTION);
} else if (empty($_POST['start_date'])) {
    header($baseErr.INVALID_WORK_START);
} else {
    $startDate = DateUtils::brToDb($_POST['start_date']);
    
    if (!isset($_POST['id'])) {
        $controller->setWork(new Work());
    }

    if (!$controller->validDate($startDate)) {
        header($baseErr.INVALID_WORK_START);

        return;
    }

    $controller->getWork()->position = filter_var($_POST['position'], FILTER_SANITIZE_SPECIAL_CHARS);
    $controller->getWork()->company = filter_var($_POST['company'], FILTER_SANITIZE_SPECIAL_CHARS);
    $controller->getWork()->description = filter_var($_POST['description'], FILTER_SANITIZE_SPECIAL_CHARS);
    $controller->getWork()->startPeriod = $startDate;
    $controller->getWork()->visible = !isset($_POST['visible']);

    if (!isset($_POST['current'])) {
        if (!isset($_POST['end_date']) || !$controller->validDate(DateUtils::brToDb($_POST['end_date']))) {
            header($baseErr . INVALID_WORK_END);

            return;
        } else if (!DateUtils::isOrderCorrect($_POST['start_date'], $_POST['end_date'])) {
            header($baseErr . INVALID_DATE_ORDER);

            return;
        } else {
            $controller->getWork()->endPeriod = DateUtils::brToDb($_POST['end_date']);
        }
    } else {
        $controller->getWork()->endPeriod = null;
    }

    $base = 'location:'.BASE_ADMIN_URL.'work';
    $code = 0;

    if (isset($_POST['id'])) {
        $base = $base.'/'.$_POST['id'];
        $controller->getWork()->id = $_POST['id'];

        $controller->updateWork();

        $code = WORK_UPDATED;
    } else {
        $userId = $_COOKIE[COOKIE_INDEX];

        $controller->saveWork($userId);

        $code = WORK_SAVED;
    }

    if (isset($_POST['img-url'])) {
        $imgUrl = $_POST['img-url'];
        
        if ($controller->getWork()->image != $imgUrl) {
            $controller->saveFile($imgUrl);
        }
    } else {
        $controller->saveFile(null);
    }

    header($base.'/suc='.$code);
}