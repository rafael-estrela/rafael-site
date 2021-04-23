<?php session_start();

include_once '../../common/resources/strings.php';
include_once '../../common/connection/pdoconnection.class.php';
include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/internalcontroller.class.php';
include_once '../../common/controller/triviacontroller.class.php';
include_once '../../common/dao/basedao.class.php';
include_once '../../common/dao/triviadao.class.php';
include_once '../../common/model/basemodel.class.php';
include_once '../../common/model/trivia.class.php';
include_once '../../common/resources/success-codes.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/util/messageutil.class.php';

$controller = new TriviaController(new PDOConnection());

if (isset($_COOKIE[COOKIE_INDEX])) {
    $userId = $_COOKIE[COOKIE_INDEX];

    if (isset($_SESSION[SESSION_PREFIX.$userId])) {
        $controller->setProfessional(unserialize($_SESSION[SESSION_PREFIX.$userId]));
    } else {
        header('location:'.BASE_ADMIN_URL.'login/');

        return;
    }
} else {
    header('location:'.BASE_ADMIN_URL.'login/');

    return;
}

$id = 1;
$triviaList = array();

while(isset($_POST["value-$id"])) {
    $trivia = new Trivia();
    
    $value = filter_var($_POST["value-$id"], FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($value) || mb_strlen($value, 'utf8') > 100) {
        header('location:'.BASE_ADMIN_URL.'trivia/?err='.INVALID_TRIVIA);

        return;
    }

    $trivia->value = $value;

    if (isset($_POST["id-$id"])) {
        $trivia->id = $_POST["id-$id"];
    }

    $triviaList[] = $trivia;

    $id++;
}

$controller->saveTrivia($triviaList);

header('location:'.BASE_ADMIN_URL.'trivia/?suc='.TRIVIA_SAVED);
