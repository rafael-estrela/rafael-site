<?php session_start();

include_once '../../common/resources/strings.php';

if(!array_key_exists(COOKIE_INDEX, $_COOKIE)) {
    header('location:'.BASE_ADMIN_URL.'login');
}

include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/internalcontroller.class.php';
include_once '../../common/controller/imageuploadcontroller.class.php';
include_once '../../common/controller/projectcontroller.class.php';
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
include_once '../../common/model/skill.class.php';

$controller = new ProjectController(new PDOConnection());

$userId = $_COOKIE[COOKIE_INDEX];
$sessionIndex = SESSION_PREFIX.$controller->getUserId();

if (!isset($_SESSION[$sessionIndex])) {
    $controller->getUserById();

    $_SESSION[$sessionIndex] = serialize($controller->getProfessional());

    header('location:./');
}

$TRK_CURR = TRACKING_PROJ;

$controller->setProfessional(unserialize($_SESSION[SESSION_PREFIX.$_COOKIE[COOKIE_INDEX]]));

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    include_once '../../common/dao/portfoliodao.class.php';

    $controller->getProjectById($id);

    if ($controller->getProject() == null) header('location:'.BASE_ADMIN_URL.'project/err='.UNEXISTENT_PROJ);

    $modalMsg = DELETE_PROJ_MODAL_MESSAGE;
    $modalAction = BASE_ADMIN_URL."action/project/delete/$id/";
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
                        <h1 class="h3 mb-0 text-gray-800"><?=PROJ_TITLE?></h1>
                    </div>
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h3 class="h6 mb-0 text-gray-600"><?=PROJ_HELPER?></h3>
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
                                    if ($controller->isEditing() && $controller->getProject()->image != null) {
                                        ?>
                                        <button class="close" onclick="didClearImage('p')">
                                            <i class="fas fa-trash-alt fa-sm fa-fw"></i>
                                        </button>
                                        <?php
                                    }
                                    ?>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <img class="img-fluid rounded-circle m-auto d-block" id="image-preview" src="<?=PROJ_IMG_BASE_PATH?><?=$controller->isEditing() ? $controller->getProject()->image == null ? DEFAULT_IMG : $controller->getProject()->image : DEFAULT_IMG?>" alt="Project Preview">
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
                                    <form id="form-content" class="user" method="post" action="<?=BASE_ADMIN_URL?>action/project/">
                                        <?php
                                        if ($controller->isEditing()) {
                                            ?>
                                            <input type="hidden" name="id" id="hiddenId" value="<?=$controller->getProject()->id?>">
                                            <input type="hidden" name="img-url" id="img_tmp_url" value="<?=$controller->getProject()->image?>">
                                            <?php
                                        }
                                        ?>
                                        <div class="form-group">
                                            <input type="text" name="name" class="form-control form-control-user <?=$code == INVALID_PROJ_NAME ? ' alert-danger' : ''?>" id="nameInput" placeholder="<?=PROJ_FIELD_NAME?>" value="<?=$controller->isEditing() ? $controller->getProject()->name : ""?>" required maxlength="100">
                                        </div>
                                        <div class="form-group">
                                            <input type="text" name="description" class="form-control form-control-user<?=$code == INVALID_PROJ_DESC ? ' alert-danger' : ''?>" id="descriptionInput" placeholder="<?=PROJ_FIELD_DESC?>" value="<?=$controller->isEditing() ? $controller->getProject()->description : ""?>" required maxlength="300">
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small text-right">
                                                <input type="checkbox" name="visible" class="custom-control-input" id="visibleCheck"<?=$controller->isEditing() && !$controller->getProject()->visible ? " checked" : ""?>>
                                                <label class="custom-control-label" for="visibleCheck"><?=VISIBLE?></label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input id="img-input-file" type="file" name="image" accept="image/jpeg, image/png" onchange='didUploadImage(this, "p")' tabindex="-2">
                                        </div>
                                        <hr>
                                        <?php
                                        if ($controller->isEditing()) {
                                            if ($controller->getProject()->links != null && count($controller->getProject()->links) > 0) {
                                                $types = $controller->getProjectTypes();

                                                foreach($controller->getProject()->links as $index => $link) {
                                                ?>
                                                <input type="hidden" id="link-id-<?=$index+1?>" name="link-id-<?=$index+1?>" value="<?=$link->id?>">
                                                <label id="delete-link-<?=$index+1?>"><img onclick="removeLink(<?=$index+1?>)" src="<?=ICON_BASE_PATH?>remove.png" class="mng-link"></label>
                                                <div class="form-group row" id="type-select-container-<?=$index+1?>">
                                                    <div class="col-sm-12 mb-3 mb-sm-0">
                                                        <select id="type-select-<?=$index+1?>" name="type-select-<?=$index+1?>" class="custom-select form-control-user" onchange="didChangeType(this, <?=$index+1?>)">
                                                            <option value=""><?=PROJ_DEFAULT_TYPE?></option>
                                                            <?php
                                                            foreach($types as $type) {
                                                                ?>
                                                                <option value="<?=$type->id?>" <?=$type->id == $link->type->id ? 'selected' : ''?>><?=$type->name?></option>
                                                                <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group row" id="proj-link-<?=$index+1?>">
                                                    <div class="col-sm-12 mb-3 mb-sm-0" id="url-container-<?=$index+1?>" placeholder="">
                                                        <input type="text" class="form-control form-control-user" maxlength="<?=mb_strlen($link->type->baseUrl, 'utf8') + 100?>" placeholder="Url..." name="proj-link-<?=$index+1?>" value="<?=$link->type->baseUrl.$link->url?>" pattern="<?=str_replace('\:', ':', preg_quote($link->type->baseUrl))?>.+" title="Esse link deve começar com <?=$link->type->baseUrl?> ;)">
                                                    </div>
                                                </div>
                                                <hr id="divider-<?=$index+1?>">
                                                <?php
                                                }
                                            }
                                        }
                                        ?>
                                        <label>
                                            <?=PROJ_LINKS_TITLE?>
                                            <img id='add-link' class="mng-link" src="<?=ICON_BASE_PATH?>add.png" onclick="addLink()">
                                        </label>
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

<?php include'./components/scripts.php' ?>
<script src="<?=BASE_ADMIN_URL?>view/js/custom/image-upload.js"></script>
<script src="<?=BASE_ADMIN_URL?>view/js/custom/dynamic-forms.js"></script>
<script src="<?=BASE_ADMIN_URL?>view/js/custom/dynamic-links.js"></script>
