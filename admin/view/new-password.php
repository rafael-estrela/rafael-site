<?php session_start();

include_once '../../common/resources/strings.php';
include_once '../../common/util/messageutil.class.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/resources/success-codes.php';

$userId = -1;

if(array_key_exists(COOKIE_INDEX, $_COOKIE)) {
    $userId = $_COOKIE[COOKIE_INDEX];

    if (isset($_SESSION[SESSION_PREFIX.$userId])) {
        header('location:'.BASE_ADMIN_URL);

        return;
    }
}

include_once '../../common/connection/pdoconnection.class.php';
include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/externalcontroller.class.php';
include_once '../../common/controller/forgotpasswordcontroller.class.php';
include_once '../../common/dao/basedao.class.php';
include_once '../../common/dao/userdao.class.php';

if (!isset($_GET['cid'])) {
    header('location:'.BASE_ADMIN_URL.'login/err='.INVALID_CONFIRM_ID);

    return;
}

$cid = $_GET['cid'];

$controller = new ForgotPasswordController(new PDOConnection());

if ($controller->userByPasswordCid($cid) == null) {
    header('location:'.BASE_ADMIN_URL.'login/err='.INVALID_CONFIRM_ID);

    return;
}

$code = 0;

if (isset($_GET['err'])) $code = $_GET['err'];
?>

<?php include 'components/head-external.php' ?>
<body class="bg-gradient-primary">
<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-5 d-none d-lg-block bg-new-pass-image"></div>
                        <div class="col-lg-7 align-self-center">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4"><?=NEW_PASSWORD_TITLE?></h1>
                                    <p class="mb-4"><?=NEW_PASSWORD_MESSAGE?></p>
                                </div>
                                <?php if ($code != 0) { ?>
                                    <div class="alert alert-danger"><?=MessageUtil::errorMessage($code)?></div>
                                <?php } ?>
                                <form id="form-content" class="user" method="post" action="<?=BASE_ADMIN_URL?>action/resetPassword/">
                                    <input type="hidden" name="cid" value="<?=$cid?>">
                                    <div class="form-group">
                                        <input type="password" name="newPassword" class="form-control form-control-user<?=$code == PASSWORD_SHORT ? ' alert-danger' : ''?>" id="passwordInput" placeholder="<?=NEW_PASS_HINT?>" required minlength="6">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="confirmPassword" class="form-control form-control-user<?=$code == PASSWORD_MATCH ? ' alert-danger' : ''?>" id="confirmPasswordInput" placeholder="<?=NEW_PASS_CONFIRM?>" required minlength="6">
                                    </div>
                                    <input type="submit" class="btn btn-primary btn-user btn-block" value="<?=FINISH_BUTTON?>">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'components/scripts.php' ?>
<script src="<?=BASE_ADMIN_URL?>view/js/custom/image-upload.js"></script>
