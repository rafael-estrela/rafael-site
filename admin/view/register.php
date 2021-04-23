<?php session_start();

include_once '../../common/resources/strings.php';
include_once '../../common/util/messageutil.class.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/resources/success-codes.php';

if(array_key_exists(COOKIE_INDEX, $_COOKIE)) {
    header('location:'.BASE_ADMIN_URL);
}

$code = isset($_GET['err']) ? $_GET['err'] : 0;
?>

<?php include 'components/head-external.php' ?>
<body class="bg-gradient-primary">
<div class="container">
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
                <div class="col-lg-7">
                    <div class="p-5">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4"><?=CREATE_ACCOUNT_TITLE?></h1>
                            <p class="mb-4"><?=CREATE_ACCOUNT_MESSAGE?></p>
                        </div>
                        <?php if (isset($_GET['err'])) { ?>
                            <div class="alert alert-danger"><?=MessageUtil::errorMessage($_GET['err'])?></div>
                        <?php } else if (isset($_GET['suc'])) { ?>
                            <div class="alert alert-success"><?=MessageUtil::successMessage($_GET['suc'])?></div>
                        <?php } ?>
                        <form class="user" method="post" action="<?=BASE_ADMIN_URL?>action/register/">
                            <div class="form-group">
                                <input type="email" name="email" class="form-control form-control-user<?=$code == INVALID_EMAIL ? ' alert-danger' : ''?>" id="emailInput" placeholder="<?=EMAIL_HINT?>" required maxlength="100">
                            </div>
                            <div class="form-group">
                                <input type="email" name="email_confirm" class="form-control form-control-user<?=$code == EMAIL_MATCH ? ' alert-danger' : ''?>" id="repeatEmailInput" placeholder="<?=EMAIL_CONFIRM_HINT?>" required maxlength="100">
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-6 mb-3 mb-sm-0">
                                    <input type="password" name="password" class="form-control form-control-user<?=$code == PASSWORD_SHORT ? ' alert-danger' : ''?>" id="passwordInput" placeholder="<?=PASSWORD_HINT?>" minlength="6" required>
                                </div>
                                <div class="col-sm-6">
                                    <input type="password" name="password_confirm" class="form-control form-control-user<?=$code == PASSWORD_MATCH ? ' alert-danger' : ''?>" id="repeatPasswordInput" placeholder="<?=REPEAT_PASSWORD_HINT?>" minlength="6" required>
                                </div>
                            </div>
                            <input type="submit" class="btn btn-primary btn-user btn-block" value="<?=CREATE_ACCOUNT_BUTTON?>">
                            <!-- TODO criar conta com Google e Facebook
                            <hr>
                            <a href="../index.html" class="btn btn-google btn-user btn-block">
                                <i class="fab fa-google fa-fw"></i> <?=CREATE_ACCOUNT_GOOGLE?>
                            </a>
                            <a href="../index.html" class="btn btn-facebook btn-user btn-block">
                                <i class="fab fa-facebook-f fa-fw"></i> <?=CREATE_ACCOUNT_FACEBOOK?>
                            </a>
                            -->
                        </form>
                        <hr>
                        <div class="text-center">
                            <a class="small" href="<?=BASE_ADMIN_URL?>forgotPassword/"><?=FORGOT_PASSWORD?></a>
                        </div>
                        <div class="text-center">
                            <a class="small" href="<?=BASE_ADMIN_URL?>login/"><?=ALREADY_HAVE_ACCOUNT?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'components/scripts.php' ?>