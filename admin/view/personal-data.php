<?php session_start();

include_once '../../common/resources/strings.php';
include_once '../../common/util/messageutil.class.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/resources/success-codes.php';

$userId = -1;

if(array_key_exists(COOKIE_INDEX, $_COOKIE)) {
    $userId = $_COOKIE[COOKIE_INDEX];

    if (isset($_SESSION[SESSION_PREFIX.$userId])) {
        header('location:'.BASE_ADMIN_URL.'settings/');

        return;
    }
} else {
    header('location:'.BASE_ADMIN_URL.'login/');
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
                        <div class="col-lg-8 align-self-center">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4"><?=PERSONAL_DATA_TITLE?></h1>
                                    <p class="mb-4"><?=PERSONAL_DATA_MESSAGE?></p>
                                </div>
                                <?php if ($code != 0) { ?>
                                    <div class="alert alert-danger"><?=MessageUtil::errorMessage($code)?></div>
                                <?php } ?>
                                <form id="form-content" class="user" method="post" action="<?=BASE_ADMIN_URL?>action/personalData/">
                                    <input type="file" id="profilePic" name="profilePic" accept="image/jpeg, image/png" style="display: none" onchange="didUploadImage(this, 'l', 'profilePicContainer')" tabindex="-1">
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control form-control-user<?=$code == INVALID_NAME ? ' alert-danger' : ''?>" id="nameInput" aria-describedby="nameHelp" placeholder="<?=NAME_HINT?>" required maxlength="50">
                                    </div>
                                    <div class="form-group">
                                        <input type="phone" name="phone" class="form-control form-control-user<?=$code == INVALID_PHONE ? ' alert-danger' : ''?>" id="phoneInput" placeholder="<?=PHONE_HINT?>" onkeyup="maskInput(this, '00 00000-0000')" pattern="[0-9]{2} [0-9]{4,5}-[0-9]{4}" title="Preencha o número no formato XX XXXXX-XXXX" required maxlength="14">
                                    </div>
                                    <input type="submit" class="btn btn-primary btn-user btn-block" value="<?=FINISH_BUTTON?>">
                                </form>
                            </div>
                        </div>
                        <div class="vertical-divider"></div>
                        <div class="col-lg-4">
                            <div id="profilePicContainer" class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4"><?=PIC_TITLE?></h1>
                                    <p class="mb-4"><?=PIC_MESSAGE?></p>
                                    <i id="img-loader" class="fa-spin fas fa-spinner invisible fa-lg fa-fw mb-4"></i>
                                </div>
                                <label id="img-preview-header" for="profilePic">
                                    <img class="img-fluid rounded-circle m-auto d-block" id="image-preview" src="<?=PROFILE_IMG_BASE_PATH?><?=DEFAULT_IMG?>" alt="Profile Pic Preview">
                                </label>
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
