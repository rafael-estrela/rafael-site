<?php
include_once '../../common/resources/strings.php';
include_once '../../common/resources/success-codes.php';
include_once '../../common/resources/error-codes.php';

$base = 'location:'.BASE_ADMIN_URL.'login/';

if (isset($_GET['cid'])) {
    include_once "../../common/connection/pdoconnection.class.php";
    include_once '../../common/dao/basedao.class.php';
    include_once '../../common/dao/userdao.class.php';

    $dao = new UserDAO(new PDOConnection());

    $code = $dao->confirmUser($_GET['cid']);

    $msgType = 'suc=';

    if ($code == ACCOUNT_CONFIRMED) {
        $msgType = 'suc=';
    } else {
        $msgType = 'err=';
    }

    header($base.$msgType.$code);
} else {
    header($base.'err='.INVALID_CONFIRM_ID);
}
