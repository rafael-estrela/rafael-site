<?php session_start();

include_once '../../common/resources/strings.php';

if(!array_key_exists(COOKIE_INDEX, $_COOKIE)) {
    header('location:'.BASE_ADMIN_URL.'login');
}

include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/internalcontroller.class.php';
include_once '../../common/controller/imageuploadcontroller.class.php';
include_once '../../common/controller/postregistrationcontroller.class.php';
include_once '../../common/connection/pdoconnection.class.php';
include_once '../../common/dao/basedao.class.php';
include_once '../../common/dao/professionaldao.class.php';
include_once '../../common/dao/graduationdao.class.php';
include_once '../../common/dao/workdao.class.php';
include_once '../../common/dao/portfoliodao.class.php';
include_once '../../common/dao/skilldao.class.php';
include_once '../../common/dao/palettedao.class.php';
include_once '../../common/model/basemodel.class.php';
include_once '../../common/model/professional.class.php';
include_once '../../common/model/graduation.class.php';
include_once '../../common/model/work.class.php';
include_once '../../common/model/project.class.php';
include_once '../../common/model/projectlink.class.php';
include_once '../../common/model/projecttype.class.php';
include_once '../../common/model/palette.class.php';
include_once '../../common/resources/success-codes.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/util/messageutil.class.php';
include_once '../../common/model/skill.class.php';

$controller = new PostRegistrationController(new PDOConnection());

$sessionIndex = SESSION_PREFIX.$controller->getUserId();

if (!isset($_SESSION[$sessionIndex])) {
    $controller->getUserById();

    $_SESSION[$sessionIndex] = serialize($controller->getProfessional());

    header('location:./');
}

$TRK_CURR = TRACKING_SETTINGS;

$controller->setProfessional(unserialize($_SESSION[SESSION_PREFIX.$_COOKIE[COOKIE_INDEX]]));

$code = 0;

if (isset($_GET['err'])) $code = $_GET['err'];
?>

<?php include './components/head-internal.php' ?>
<body id="page-top">
<!-- Page Wrapper -->
<div id="wrapper">
    <?php include './components/sidebar.php' ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <?php include './components/navbar.php' ?>
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800"><?=SETTINGS_TITLE?></h1>
                </div>
                <div class="row">
                    <!-- Pie Chart -->
                    <div class="col-xl-4 col-lg-5">
                        <div class="card shadow mb-4">
                            <!-- Card Header -->
                            <div id="img-preview-header" class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary"><?=IMG_BLOCK_TITLE?></h6>
                                <i id="img-loader" class="fa-spin fas fa-spinner fa-sm fa-fw invisible close"></i>
                                <?php if ($controller->getProfessional()->picture != null) { ?>
                                    <button class="close" onclick="didClearImage('l')">
                                        <i class="fas fa-trash-alt fa-sm fa-fw"></i>
                                    </button>
                                <?php } ?>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <img class="img-fluid rounded-circle m-auto d-block" id="image-preview" src="<?=PROFILE_IMG_BASE_PATH?><?=$controller->getProfessional()->picture == null ? DEFAULT_IMG : $controller->getProfessional()->picture?>" alt="Profile Pic Preview">
                            </div>
                        </div>
                    </div>
                    <!-- Area Chart -->
                    <div class="col-xl-8 col-lg-7">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Delete option -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary"><?=DATA_BLOCK_TITLE?></h6>
                            </div>
                            <!-- Card Body -->
                            <div id="form-body" class="card-body">
                                <?php if (in_array($code, [INVALID_NAME, INVALID_USERNAME, TAKEN_USERNAME])) { ?>
                                    <div id="alert-err" class="alert alert-danger"><?=MessageUtil::errorMessage($code)?></div>
                                <?php } else if (isset($_GET['suc']) && $_GET['suc'] == SETTINGS_SAVED) { ?>
                                    <div id="alert-suc" class="alert alert-success"><?=MessageUtil::successMessage($_GET['suc'])?></div>
                                <?php } ?>
                                <form id="form-content" class="user" method="post" action="<?=BASE_ADMIN_URL?>action/settings/">
                                    <?php
                                    if ($controller->getProfessional()->picture != null) {
                                    ?>
                                    <input type="hidden" name="img-url" id="img_tmp_url" value="<?=$controller->getProfessional()->picture?>">
                                    <?php
                                    }
                                    ?>
                                    <div class="form-group">
                                        <input type="text" name="name" class="form-control form-control-user<?=$code == INVALID_NAME ? ' alert-danger' : ''?>" id="nameInput" aria-describedby="nameHelp" placeholder="<?=SETTINGS_NAME_HINT?>" value="<?=$controller->getProfessional()->name?>" required maxlength="50">
                                    </div>
                                    <div class="form-group row">
                                        <div class="col-sm-11 mb-3 mb-sm-0">
                                            <input type="text" name="username" onkeyup="scheduleUsernameSearch(this)" class="form-control form-control-user<?=in_array($code, [INVALID_USERNAME, TAKEN_USERNAME]) ? ' alert-danger' : ''?>" id="usernameInput" placeholder="<?=SETTINGS_USERNAME_HINT?>" value="<?=$controller->getProfessional()->username?>" pattern="^[a-zA-Z0-9_\.-]{1,32}$" title="O username deve conter apenas letras, números e os caracteres (_, - e .)." required maxlength="32">
                                        </div>
                                        <div class="col-sm-1 mb-3 mb-sm-0">
                                            <img class="img-loader" id="usernameIndicator" src="<?=ICON_BASE_PATH?>success.png">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <input id="img_input_file" type="file" name="image" accept="image/jpeg, image/png" onchange='didUploadImage(this, "l")' tabindex="-1">
                                    </div>
                                    <label><?=PALETTE_LABEL?></label>
                                    <div class="form-group row">
                                        <?php
                                        $palettes = $controller->getColorPalettes();

                                        foreach($palettes as $palette) { ?>
                                            <div class="palette-item col-sm-4 mb-3 mb-sm-3">
                                                <input type="radio" name="palette" value="<?=$palette->id?>" id="<?=$palette->name?>"<?=$controller->getProfessional()->palette == $palette->id ? ' checked' : ''?>>
                                                <label for="<?=$palette->name?>"><?=ucwords($palette->name)?>
                                                    <div class="row m-1 img-thumbnail">
                                                        <div class="col-4" style="background-color: <?='#'.$palette->firstColor?>"></div>
                                                        <div class="col-4" style="background-color: <?='#'.$palette->secondColor?>"></div>
                                                        <div class="col-4" style="background-color: <?='#'.$palette->thirdColor?>"></div>
                                                    </div>
                                                </label>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <input type="submit" class="btn btn-primary btn-user btn-block" value="<?=UPDATE_BUTTON?>">
                                </form>
                            </div>
                            <hr>
                            <div id="reset-pass-body" class="card-body">
                                <?php if (in_array($code, [PASSWORD_MATCH, PASSWORD_SHORT, OLD_PASSWORD_WRONG])) { ?>
                                    <div id="alert-err" class="alert alert-danger"><?=MessageUtil::errorMessage($code)?></div>
                                <?php } else if (isset($_GET['suc']) && $_GET['suc'] == SETTINGS_PASSWORD_SAVED) { ?>
                                    <div id="alert-suc" class="alert alert-success"><?=MessageUtil::successMessage($_GET['suc'])?></div>
                                <?php } ?>
                                <div class="text-center">
                                    <p class="mb-4"><?=CHANGE_PASS_TITLE?></p>
                                </div>
                                <form id="form-content" class="user" method="post" action="<?=BASE_ADMIN_URL?>action/settings/">
                                    <?php
                                    if ($controller->getProfessional()->picture != null) {
                                        ?>
                                        <input type="hidden" name="img-url" id="img_tmp_url" value="<?=$controller->getProfessional()->picture?>">
                                        <?php
                                    }
                                    ?>
                                    <div class="form-group">
                                        <input type="password" name="oldPassword" class="form-control form-control-user<?=$code == OLD_PASSWORD_WRONG ? ' alert-danger' : ''?>" id="oldPassInput" placeholder="<?=OLD_PASS_HINT?>" required minlength="6">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="newPassword" class="form-control form-control-user<?=$code == PASSWORD_SHORT ? ' alert-danger' : ''?>" id="newPassInput" placeholder="<?=NEW_PASS_HINT?>" required minlength="6">
                                    </div>
                                    <div class="form-group">
                                        <input type="password" name="confirmPassword" class="form-control form-control-user<?=$code == PASSWORD_MATCH ? ' alert-danger' : ''?>" id="confirmPassInput" placeholder="<?=NEW_PASS_CONFIRM?>" required minlength="6">
                                    </div>
                                    <input type="submit" class="btn btn-primary btn-user btn-block" value="<?=UPDATE_BUTTON?>">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
        <?php include './components/footer.php' ?>
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

<?php include './components/internal-elements.php' ?>
<?php if (isset($_GET['id'])) include './components/delete-modal.php' ?>

<?php include './components/scripts.php' ?>
<script src="<?=BASE_ADMIN_URL?>view/js/custom/image-upload.js"></script>