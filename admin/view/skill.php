<?php session_start();

include_once '../../common/resources/strings.php';

if(!array_key_exists(COOKIE_INDEX, $_COOKIE)) {
    header('location:'.BASE_ADMIN_URL.'login');
}

include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/internalcontroller.class.php';
include_once '../../common/controller/skillcontroller.class.php';
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
include_once '../../common/model/skill.class.php';
include_once '../../common/resources/success-codes.php';
include_once '../../common/resources/error-codes.php';
include_once '../../common/util/messageutil.class.php';
include_once '../../common/util/skillutil.class.php';

$controller = new SkillController(new PDOConnection());

$sessionIndex = SESSION_PREFIX.$controller->getUserId();

if (!isset($_SESSION[$sessionIndex])) {
    $controller->getUserById();

    $_SESSION[$sessionIndex] = serialize($controller->getProfessional());

    header('location:./');
}

$TRK_CURR = TRACKING_SKILLS;

$controller->setProfessional(unserialize($_SESSION[SESSION_PREFIX.$_COOKIE[COOKIE_INDEX]]));

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    include_once '../../common/dao/skilldao.class.php';

    $controller->getSkillById($id);

    if ($controller->getSkill() == null) header('location:'.BASE_ADMIN_URL.'skill/err='.UNEXISTENT_SKILL);

    $modalMsg = DELETE_SKILL_MODAL_MESSAGE;
    $modalAction = BASE_ADMIN_URL."action/skill/delete/$id/";
}

$code = 0;

if (isset($_GET['err'])) $code = $_GET['err'];
?>

<?php include './components/head-internal.php' ?>
<link href="<?=BASE_COMMON_URL?>css/external/circle.css" rel="stylesheet">
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
                    <h1 class="h3 mb-0 text-gray-800"><?=SKILL_TITLE?></h1>
                </div>
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h3 class="h6 mb-0 text-gray-600"><?=SKILL_HELPER?></h3>
                </div>
                <div class="row">
                    <!-- Pie Chart -->
                    <div class="col-xl-4 col-lg-5">
                        <div class="card shadow mb-4">
                            <!-- Card Header -->
                            <div id="img-preview-header" class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary"><?=PREVIEW_BLOCK_TITLE?></h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div id="graph-preview" class="column-item">
                                    <p id="preview-title"><?=$controller->isEditing() ? $controller->getSkill()->name : SKILL_DEF_TECH?></p>
                                    <p id="preview-stars"><?=SkillUtil::percentToStars($controller->isEditing() ? $controller->getSkill()->percentage : 0)?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Area Chart -->
                    <div class="col-xl-8 col-lg-7">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Delete option -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary"><?=DATA_BLOCK_TITLE?></h6>
                                <i id="select-loader" class="fa-spin fas fa-spinner fa-sm fa-fw invisible close"></i>
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
                                <form id="form-content" class="user" method="post" action="<?=BASE_ADMIN_URL?>action/skill/">
                                    <input type="hidden" name="id" id="hiddenId" value="<?=$controller->getSkill() == null ? '' : $controller->getSkill()->skillId?>">
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm-0" id="name-container">
                                            <input type="text" name="name" min="0" max="100" onfocus="focusOnName(true)" onblur="focusOnName(false)" onchange="didChangeName(this)" onkeyup="didChangeName(this)" class="form-control form-control-user" id="nameInput" placeholder="<?=SKILL_TECH_DEFAULT?>" value="<?=$controller->isEditing() ? $controller->getSkill()->name : ''?>" >
                                        </div>
                                        <div class="col-sm-6 mb-3 mb-sm-0">
                                            <input type="number" name="percent" min="0" max="100" onchange="didChangePercent(this)" onkeyup="didChangePercent(this)" class="form-control form-control-user <?=$code == INVALID_PERCENTAGE ? ' alert-danger' : ''?>" id="percentInput" placeholder="<?=PERCENT_FIELD?>" value="<?=$controller->isEditing() ? $controller->getSkill()->percentage : ''?>" >
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox small text-right">
                                            <input type="checkbox" name="visible" class="custom-control-input" id="visibleCheck"<?=$controller->isEditing() && !$controller->getSkill()->visible ? " checked" : ""?>>
                                            <label class="custom-control-label" for="visibleCheck"><?=VISIBLE?></label>
                                        </div>
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
<script src="<?=BASE_ADMIN_URL?>view/js/custom/dynamic-forms.js"></script>
<script src="<?=BASE_ADMIN_URL?>view/js/custom/dynamic-skills.js"></script>