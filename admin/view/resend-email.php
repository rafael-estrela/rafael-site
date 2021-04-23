<?php session_start();
include_once '../../common/connection/pdoconnection.class.php';
include_once '../../common/resources/strings.php';
include_once '../../common/resources/success-codes.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/util/messageutil.class.php';

$con = new PDOConnection();

if(array_key_exists(COOKIE_INDEX, $_COOKIE)) {
    header('location:'.BASE_ADMIN_URL);
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
                        <div class="col-lg-6 d-none d-lg-block bg-password-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-2"><?=RESEND_EMAIL_TITLE?></h1>
                                    <p class="mb-4"><?=RESEND_EMAIL_MESSAGE?></p>
                                </div>
                                <?php if (isset($_GET['err'])) { ?>
                                    <div class="alert alert-danger"><?=MessageUtil::errorMessage($_GET['err'])?></div>
                                <?php } else if (isset($_GET['suc'])) { ?>
                                    <div class="alert alert-success"><?=MessageUtil::successMessage($_GET['suc'])?></div>
                                <?php } ?>
                                <form class="user" method="post" action="<?=BASE_ADMIN_URL?>action/resendEmail/">
                                    <div class="form-group">
                                        <input type="email" name="email" class="form-control form-control-user<?=isset($_GET['err']) ? ' alert-danget' : ''?>" id="emailInput" aria-describedby="emailHelp" placeholder="<?=EMAIL_HINT?>" maxlength="100" required>
                                    </div>
                                    <input type="submit" class="btn btn-primary btn-user btn-block" value="<?=RESEND_EMAIL_BUTTON?>">
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?=BASE_ADMIN_URL?>register/"><?=CREATE_ACCOUNT?></a>
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
    </div>
</div>

<?php include 'components/scripts.php' ?>