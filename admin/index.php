<?php session_start();

include_once '../common/resources/strings.php';

if(!array_key_exists(COOKIE_INDEX, $_COOKIE)) {
    header('location:'.BASE_ADMIN_URL.'login/');
}

include_once '../common/controller/basecontroller.class.php';
include_once '../common/controller/internalcontroller.class.php';
include_once '../common/controller/homecontroller.class.php';
include_once '../common/connection/pdoconnection.class.php';
include_once '../common/dao/basedao.class.php';
include_once '../common/dao/professionaldao.class.php';
include_once '../common/dao/graduationdao.class.php';
include_once '../common/dao/workdao.class.php';
include_once '../common/dao/portfoliodao.class.php';
include_once '../common/dao/skilldao.class.php';
include_once '../common/model/basemodel.class.php';
include_once '../common/model/professional.class.php';
include_once '../common/model/graduation.class.php';
include_once '../common/model/work.class.php';
include_once '../common/model/project.class.php';
include_once '../common/model/projectlink.class.php';
include_once '../common/model/projecttype.class.php';
include_once '../common/model/skill.class.php';

$controller = new HomeController(new PDOConnection());

$sessionIndex = SESSION_PREFIX.$controller->getUserId();

if (!isset($_SESSION[$sessionIndex])) {
    $controller->getUserById();

    if ($controller->getProfessional() == null) {
        header('location:'.BASE_ADMIN_URL.'aboutMe/');

        return;
    }

    $_SESSION[$sessionIndex] = serialize($controller->getProfessional());

    header('location:./');
}

$TRK_CURR = TRACKING_INDEX;

$controller->setProfessional(unserialize($_SESSION[SESSION_PREFIX.$_COOKIE[COOKIE_INDEX]]));
$controller->refreshAccess();
?>

<?php include './view/components/head-internal.php' ?>

<body id="page-top">
<!-- Page Wrapper -->
<div id="wrapper">
    <?php include './view/components/sidebar.php' ?>
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <!-- Main Content -->
        <div id="content">
            <?php include './view/components/navbar.php' ?>
            <div class="user-alert alert alert-success" id="userAlert"><?=USER_ALERT?></div>
            <div class="user-alert alert alert-danger" id="userError"></div>
            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800"><?=MENU_DASHBOARD?></h1>
                </div>
                <!-- Content Row -->
                <div class="row">
                    <!-- My Profile Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-warning shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-2"><?=CARD_SHARE_TITLE?></div>
                                        <a class="home-link" onclick="copyMyLink('<?=$controller->getProfessional()->username?>')"><div class="h6 mb-2 font-weight-bold text-gray-800"><?=CARD_SHARE_PROFILE?></div></a>
                                        <a class="home-link" href="<?=BASE_API_URL?>pdf/<?=$controller->getProfessional()->username?>"><div class="h6 mb-0 font-weight-bold text-gray-800"><?=CARD_RESUME_PDF?></div></a>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-share fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Week Access Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-success shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-success text-uppercase mb-2"><?=CARD_ACCESS_COUNT_WEEK?></div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$controller->getProfessional()->weekCount?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar-week fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Month Access Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-info shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-info text-uppercase mb-2"><?=CARD_ACCESS_COUNT_MONTH?></div>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col-auto">
                                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?=$controller->getProfessional()->monthCount?></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Number of Access Card Example -->
                    <div class="col-xl-3 col-md-6 mb-4">
                        <div class="card border-left-primary shadow h-100 py-2">
                            <div class="card-body">
                                <div class="row no-gutters align-items-center">
                                    <div class="col mr-2">
                                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-2"><?=CARD_ACCESS_COUNT?></div>
                                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?=$controller->getProfessional()->accessCount?></div>
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-calendar-day fa-2x text-gray-300"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Content Row -->
                <div class="row">
                    <!-- Area Chart -->
                    <div class="col-xl-12 col-lg-11">
                        <div class="card shadow mb-4">
                            <!-- Card Header - Dropdown -->
                            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                <h6 class="m-0 font-weight-bold text-primary"><?=ACCESS_GRAPH_TITLE?></h6>
                            </div>
                            <!-- Card Body -->
                            <div class="card-body">
                                <div class="chart-area">
                                    <canvas id="accessChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- End of Main Content -->
        <?php include './view/components/footer.php' ?>
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

<?php include './view/components/internal-elements.php' ?>

<?php include './view/components/scripts.php' ?>