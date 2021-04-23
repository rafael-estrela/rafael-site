<?php session_start();

include_once '../../common/resources/strings.php';

if(!array_key_exists(COOKIE_INDEX, $_COOKIE)) {
    header('location:'.BASE_ADMIN_URL.'login');
}

include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/internalcontroller.class.php';
include_once '../../common/controller/imageuploadcontroller.class.php';
include_once '../../common/controller/graduationcontroller.class.php';
include_once '../../common/connection/pdoconnection.class.php';
include_once '../../common/dao/basedao.class.php';
include_once '../../common/dao/professionaldao.class.php';
include_once '../../common/dao/graduationdao.class.php';
include_once '../../common/dao/workdao.class.php';
include_once '../../common/dao/portfoliodao.class.php';
include_once '../../common/dao/skilldao.class.php';
include_once '../../common/model/basemodel.class.php';
include_once '../../common/model/professional.class.php';
include_once '../../common/model/graduation.class.php';
include_once '../../common/model/work.class.php';
include_once '../../common/model/project.class.php';
include_once '../../common/model/projectlink.class.php';
include_once '../../common/model/projecttype.class.php';
include_once '../../common/resources/success-codes.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/util/messageutil.class.php';
include_once '../../common/util/dateutils.class.php';
include_once '../../common/model/skill.class.php';

$controller = new GraduationController(new PDOConnection());

$sessionIndex = SESSION_PREFIX.$controller->getUserId();

if (!isset($_SESSION[$sessionIndex])) {
    $controller->getUserById();

    $_SESSION[$sessionIndex] = serialize($controller->getProfessional());

    header('location:./');
}

$TRK_CURR = TRACKING_GRADUATION;

$controller->setProfessional(unserialize($_SESSION[SESSION_PREFIX.$_COOKIE[COOKIE_INDEX]]));

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    include_once '../../common/dao/graduationdao.class.php';

    $controller->getGraduationById($id);

    if ($controller->getGraduation() == null) header('location:'.BASE_ADMIN_URL.'graduation/err='.UNEXISTENT_GRAD);

    $modalMsg = DELETE_GRAD_MODAL_MESSAGE;
    $modalAction = BASE_ADMIN_URL."action/graduation/delete/$id/";
}

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
                        <h1 class="h3 mb-0 text-gray-800"><?=GRAD_TITLE?></h1>
                    </div>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h3 class="h6 mb-0 text-gray-600"><?=GRAD_HELPER?></h3>
                    </div>
                    <div class="row">
                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header -->
                                <div id="img-preview-header" class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary"><?=IMG_BLOCK_TITLE?></h6>
                                    <i id="img-loader" class="fa-spin fas fa-spinner fa-sm fa-fw invisible close"></i>
                                    <?php
                                    if ($controller->isEditing() && $controller->getGraduation()->image != null) {
                                    ?>
                                    <button class="close" onclick="didClearImage('g')">
                                        <i class="fas fa-trash-alt fa-sm fa-fw"></i>
                                    </button>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <img class="img-fluid rounded-circle m-auto d-block" id="image-preview" src="<?=GRAD_IMG_BASE_PATH?><?=$controller->isEditing() ? $controller->getGraduation()->image == null ? DEFAULT_IMG : $controller->getGraduation()->image : DEFAULT_IMG?>" alt="Graduation Preview">
                                </div>
                            </div>
                        </div>
                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Delete option -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary"><?=DATA_BLOCK_TITLE?></h6>
                                    <i id="img-loader" class="fa-spin fas fa-spinner fa-sm fa-fw invisible close"></i>
                                    <?php
                                    if ($controller->isEditing()) {
                                    ?>
                                    <a class="close" href="#" data-toggle="modal" data-target="#deleteModal">
                                        <i class="fas fa-trash-alt fa-sm fa-fw"></i>
                                    </a>
                                    <?php
                                    }
                                    ?>
                                </div>
                                <!-- Card Body -->
                                <div id="form-body" class="card-body">
                                    <?php if ($code != 0) { ?>
                                    <div id="alert-err" class="alert alert-danger"><?=MessageUtil::errorMessage($_GET['err'])?></div>
                                    <?php } else if (isset($_GET['suc'])) { ?>
                                    <div id="alert-suc" class="alert alert-success"><?=MessageUtil::successMessage($_GET['suc'])?></div>
                                    <?php } ?>
                                    <form id="form-content" class="user" method="post" action="<?=BASE_ADMIN_URL?>action/graduation/">
                                        <?php
                                        if ($controller->isEditing()) {
                                        ?>
                                        <input type="hidden" name="id" id="hiddenId" value="<?=$controller->getGraduation()->id?>">
                                        <input type="hidden" name="img-url" id="img_tmp_url" value="<?=$controller->getGraduation()->image?>">
                                        <?php
                                        }
                                        ?>
                                        <div class="form-group">
                                            <input type="text" name="title" class="form-control form-control-user <?=$code == INVALID_GRADUATION_TITLE ? ' alert-danger' : ''?>" id="titleInput" placeholder="<?=GRAD_FIELD_TITLE?>" value="<?=$controller->isEditing() ? $controller->getGraduation()->title : ""?>" required maxlength="100">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="institution" class="form-control form-control-user<?=$code == INVALID_GRADUATION_INSTITUTION ? ' alert-danger' : ''?>" id="institutionInput" placeholder="<?=GRAD_FIELD_INST?>" value="<?=$controller->isEditing() ? $controller->getGraduation()->institution : ""?>" required maxlength="100">
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="text" name="start_date" class="form-control form-control-user<?=($code == INVALID_GRADUATION_START || $code == INVALID_DATE_ORDER) ? ' alert-danger' : ''?>" id="startInput" placeholder="<?=FIELD_START?>" value="<?=$controller->isEditing() ? DateUtils::dbToBr($controller->getGraduation()->startPeriod) : ""?>" onkeyup="maskInput(this, '00/00/0000')" required pattern="^[0-9]{2}/[0-9]{2}/[0-9]{4}$" maxlength="10">
                                            </div>
                                            <div class="col-sm-6 mb-3 mb-sm-0">
                                                <input type="text" name="end_date" class=" form-control form-control-user<?=($code == INVALID_GRADUATION_END || $code == INVALID_DATE_ORDER) ? ' alert-danger' : ''?>" id="endInput" placeholder="<?=FIELD_END?>" value="<?=$controller->isEditing() && $controller->getGraduation()->endPeriod != null ? DateUtils::dbToBr($controller->getGraduation()->endPeriod) : ""?>"<?=$controller->isEditing() && $controller->getGraduation()->endPeriod == null ? " disabled" : ""?> onkeyup="maskInput(this, '00/00/0000')" required pattern="^[0-9]{2}/[0-9]{2}/[0-9]{4}$" maxlength="10">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small text-right">
                                                <input type="checkbox" name="current" class="custom-control-input" id="currentCheck"<?=$controller->isEditing() && $controller->getGraduation()->endPeriod == null ? " checked" : ""?> onchange='didChangeState(this, "endInput")'>
                                                <label class="custom-control-label" for="currentCheck"><?=GRAD_CURRENT?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small text-right">
                                                <input type="checkbox" name="visible" class="custom-control-input" id="visibleCheck"<?=$controller->isEditing() && !$controller->getGraduation()->visible ? " checked" : ""?>>
                                                <label class="custom-control-label" for="visibleCheck"><?=VISIBLE?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input id="img_input_file" type="file" name="image" accept="image/jpeg, image/png" onchange='didUploadImage(this, "g")' tabindex="-1">
                                        </div>
                                        <input type="submit" class="btn btn-primary btn-user btn-block" value="<?=$controller->isEditing() ? UPDATE_BUTTON : SAVE_BUTTON?>">
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
<script>
    let datepickerModel = {
        language: "pt-BR",
        format: "dd/mm/yyyy",
        orientation: "bottom auto"
    }
    $('#startInput').datepicker(datepickerModel)
    $('#endInput').datepicker(datepickerModel)
</script>
