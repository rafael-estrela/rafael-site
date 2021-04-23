<?php session_start();

include_once '../../common/resources/strings.php';
include_once '../../common/util/messageutil.class.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/resources/success-codes.php';

if(array_key_exists(COOKIE_INDEX, $_COOKIE)) {
    if(isset($_GET['logout'])){
        $id = $_COOKIE[COOKIE_INDEX];

        session_unset();
        setcookie(COOKIE_INDEX, '', time() - 1, '/');

        header('location:'.BASE_ADMIN_URL.'login/');
    }else{
        header('location:'.BASE_ADMIN_URL);
    }
}
?>

<?php include 'components/head-external.php' ?>
<body class="bg-gradient-primary">
<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4"><?=WELCOME_MESSAGE?></h1>
                                </div>
                                <?php if (isset($_GET['err'])) { ?>
                                <div class="alert alert-danger"><?=MessageUtil::errorMessage($_GET['err'])?></div>
                                <?php } else if (isset($_GET['suc'])) { ?>
                                <div class="alert alert-success"><?=MessageUtil::successMessage($_GET['suc'])?></div>
                                <?php } ?>
                                <form class="user" method="post" action="<?=BASE_ADMIN_URL?>action/login/">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control form-control-user" id="emailInput" aria-describedby="emailHelp" placeholder="<?=EMAIL_HINT?>" required maxlength="100">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="password" class="form-control form-control-user" id="passwordInput" placeholder="<?=PASSWORD_HINT?>" required minlength="6">
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small">
                                            <input type="checkbox" name="remember_me" class="custom-control-input" id="rememberMeCheck" checked>
                                            <label class="custom-control-label" for="rememberMeCheck"><?=REMEMBER_ME?></label>
                                        </div>
                                    </div>
                                    <input type="submit" class="btn btn-primary btn-user btn-block" value="<?=LOGIN_BUTTON?>">
                                    <!-- TODO login com Google e Facebook
                                    <hr>
                                    <a href="../index.html" class="btn btn-google btn-user btn-block">
                                        <i class="fab fa-google fa-fw"></i> <?=GOOGLE_LOGIN?>
                                    </a>
                                    <a href="../index.html" class="btn btn-facebook btn-user btn-block">
                                        <i class="fab fa-facebook-f fa-fw"></i> <?=FACEBOOK_LOGIN?>
                                    </a>
                                    -->
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?=BASE_ADMIN_URL?>forgotPassword/"><?=FORGOT_PASSWORD?></a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="<?=BASE_ADMIN_URL?>register/"><?=CREATE_ACCOUNT?></a>
                                </div>
                                <div class="text-center">
                                    <a class="small" href="<?=BASE_ADMIN_URL?>resendEmail/"><?=RESEND_EMAIL_OPTION?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'components/scripts.php' ?>
