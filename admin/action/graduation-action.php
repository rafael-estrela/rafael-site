<?php session_start();

include_once '../../common/resources/strings.php';
include_once '../../common/connection/pdoconnection.class.php';
include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/internalcontroller.class.php';
include_once '../../common/controller/imageuploadcontroller.class.php';
include_once '../../common/controller/graduationcontroller.class.php';
include_once '../../common/dao/basedao.class.php';
include_once '../../common/dao/graduationdao.class.php';
include_once '../../common/model/basemodel.class.php';
include_once '../../common/model/graduation.class.php';
include_once '../../common/resources/success-codes.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/util/messageutil.class.php';
include_once '../../common/util/dateutils.class.php';

$controller = new GraduationController(new PDOConnection());

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
    $controller->getGraduationById($id);

    if ($controller->getGraduation() == null) {
        header('location:'.BASE_ADMIN_URL.'graduation/err='.UNEXISTENT_GRAD);
    } else {
        $controller->deleteGraduation($id);

        header('location:'.BASE_ADMIN_URL.'graduation/suc='.GRAD_DELETED);
    }

    return;
}

$baseErr = 'location:'.BASE_ADMIN_URL.'graduation';

if (isset($_POST['id'])) {
    $controller->getGraduationById($_POST['id']);

    if ($controller->getGraduation() == null) {
        header('location:'.BASE_ADMIN_URL.'graduation/err='.UNEXISTENT_GRAD);

        return;
    }

    $baseErr = $baseErr.'/'.$_POST['id'];
}

$baseErr = $baseErr.'/err=';

if (empty($_POST['title']) || mb_strlen($_POST['title'], 'utf8') > 100) {
    header($baseErr.INVALID_GRADUATION_TITLE);
} else if (empty($_POST['institution']) || mb_strlen($_POST['institution'], 'utf8') > 100) {
    header($baseErr.INVALID_GRADUATION_INSTITUTION);
} else if (empty($_POST['start_date'])) {
    header($baseErr.INVALID_GRADUATION_START);
} else {
    $startDate = DateUtils::brToDb($_POST['start_date']);

    if (!$controller->validDate($startDate)) {
        header($baseErr.INVALID_GRADUATION_START);

        return;
    }

    if (!isset($_POST['id'])) {
        $controller->setGraduation(new Graduation());
    }

    $controller->getGraduation()->title = filter_var($_POST['title'], FILTER_SANITIZE_SPECIAL_CHARS);
    $controller->getGraduation()->institution = filter_var($_POST['institution'], FILTER_SANITIZE_SPECIAL_CHARS);
    $controller->getGraduation()->startPeriod = $startDate;
    $controller->getGraduation()->visible = !isset($_POST['visible']);

    if (!isset($_POST['current'])) {
        if (!isset($_POST['end_date']) || !$controller->validDate(DateUtils::brToDb($_POST['end_date']))) {
            header($baseErr.INVALID_GRADUATION_END);

            return;
        } else if (!DateUtils::isOrderCorrect($_POST['start_date'], $_POST['end_date'])) {
            header($baseErr . INVALID_DATE_ORDER);

            return;
        } else {
            $controller->getGraduation()->endPeriod = DateUtils::brToDb($_POST['end_date']);
        }
    } else {
        $controller->getGraduation()->endPeriod = null;
    }

    $base = 'location:'.BASE_ADMIN_URL.'graduation';
    $code = 0;

    if (isset($_POST['id'])) {
        $base = $base.'/'.$_POST['id'];
        $controller->getGraduation()->id = $_POST['id'];

        $controller->updateGraduation();

        $code = GRAD_UPDATED;
    } else {
        $userId = $_COOKIE[COOKIE_INDEX];

        $controller->saveGraduation($userId);

        $code = GRAD_SAVED;
    }

    if (isset($_POST['img-url'])) {
        $imgUrl = $_POST['img-url'];
        
        if ($controller->getGraduation()->image != $imgUrl) {
            $controller->saveFile($imgUrl);
        }
    } else {
        $controller->saveFile(null);
    }

    header($base.'/suc='.$code);
}