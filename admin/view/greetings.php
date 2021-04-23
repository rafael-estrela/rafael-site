<?php session_start();

include_once '../../common/resources/strings.php';

if(!array_key_exists(COOKIE_INDEX, $_COOKIE)) {
    header('location:'.BASE_ADMIN_URL.'login');
}

include_once '../../common/controller/basecontroller.class.php';
include_once '../../common/controller/internalcontroller.class.php';
include_once '../../common/controller/greetingscontroller.class.php';
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

$controller = new GreetingsController(new PDOConnection());

$sessionIndex = SESSION_PREFIX.$controller->getUserId();

if (!isset($_SESSION[$sessionIndex])) {
    $controller->getUserById();

    $_SESSION[$sessionIndex] = serialize($controller->getProfessional());

    header('location:./');
}

$TRK_CURR = TRACKING_DESC;

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
                    <h1 class="h3 mb-0 text-gray-800"><?=GREETINGS_TITLE?></h1>
                </div>
                <div class="row">
                    <!-- Area Chart -->
                    <div class="col-xl-12 col-lg-11">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Delete option -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary"><?=DATA_BLOCK_TITLE?></h6>
                            </div>
                            <!-- Card Body -->
                            <div id="form-body" class="card-body">
                                <?php if ($code != 0) { ?>
                                    <div id="alert-err" class="alert alert-danger"><?=MessageUtil::errorMessage($_GET['err'])?></div>
                                <?php } else if (isset($_GET['suc'])) { ?>
                                    <div id="alert-suc" class="alert alert-success"><?=MessageUtil::successMessage($_GET['suc'])?></div>
                                <?php } ?>
                                <form id="form-content" class="user" method="post" action="<?=BASE_ADMIN_URL?>action/greetings/">
                                    <div class="form-group">
                                        <textarea id="greetings" name="greetings" onkeyup="countCharacters(this, 'greetings-counter', 620)" maxlength="620" class="form-control<?=$code == INVALID_GREETINGS ? ' alert-danger' : ''?>" rows="5" placeholder="<?=GREETINGS_HINT?>"><?=$controller->getProfessional()->desc?></textarea>
                                    </div>
                                    <div class="custom-control text-right">
                                        <label id="greetings-counter" for="greetings"><?=mb_strlen($controller->getProfessional()->desc, 'utf8')?>/620</label>
                                    </div>
                                    <div class="form-group">
                                        <textarea id="goal" name="goal" onkeyup="countCharacters(this, 'goal-counter', 100)" maxlength="100" class="form-control<?=$code == INVALID_GOAL ? ' alert-danger' : ''?>" rows="2" placeholder="<?=GOAL_HINT?>"><?=$controller->getProfessional()->goal?></textarea>
                                    </div>
                                    <div class="custom-control text-right">
                                        <label id="goal-counter" for="goal"><?=mb_strlen($controller->getProfessional()->goal, 'utf8')?>/100</label>
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
<?php include './components/delete-modal.php' ?>
<?php include './components/scripts.php' ?>