<?php session_start();

include_once '../../common/resources/strings.php';
include_once '../../common/connection/pdoconnection.class.php';
include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/internalcontroller.class.php';
include_once '../../common/controller/greetingscontroller.class.php';
include_once '../../common/dao/basedao.class.php';
include_once '../../common/dao/professionaldao.class.php';
include_once '../../common/model/basemodel.class.php';
include_once '../../common/model/professional.class.php';
include_once '../../common/resources/success-codes.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/util/messageutil.class.php';

$controller = new GreetingsController(new PDOConnection());

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

if (isset($_POST['greetings'])) {
    $greetings = filter_var(str_replace("\r\n", "\n", $_POST['greetings']), FILTER_SANITIZE_SPECIAL_CHARS);

    if (mb_strlen($greetings, 'utf8') > 620) {
        header('location:'.BASE_ADMIN_URL.'greetings/err='.INVALID_GREETINGS);

        return;
    }

    $controller->getProfessional()->desc = $greetings;
}

if (isset($_POST['goal'])) {
    $goal = filter_var(str_replace("\r\n", "\n", $_POST['goal']), FILTER_SANITIZE_SPECIAL_CHARS);

    if (mb_strlen($goal, 'utf8') > 100) {
        header('location:'.BASE_ADMIN_URL.'greetings/err='.INVALID_GOAL);

        return;
    }

    $controller->getProfessional()->goal = $goal;
}

$controller->saveGreetings();

$sessionIndex = SESSION_PREFIX.$_COOKIE[COOKIE_INDEX];

unset($_SESSION[$sessionIndex]);

$_SESSION[$sessionIndex] = serialize($controller->getProfessional());

header('location:'.BASE_ADMIN_URL.'greetings/suc='.GREETINGS_SAVED);