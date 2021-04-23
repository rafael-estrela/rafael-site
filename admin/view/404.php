<?php session_start();
include_once '../../common/resources/strings.php';
include_once '../../common/util/messageutil.class.php';
include 'components/head-external.php';
?>

<body class="bg-gradient-primary">
<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9">
            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Begin Page Content -->
                    <div class="container-fluid p-5">
                        <!-- 404 Error Text -->
                        <div class="text-center">
                            <div class="error mx-auto" data-text="404" style="white-space: nowrap;">404</div>
                            <p class="lead text-gray-800 mb-5"><?=TITLE_PAGE_404?></p>
                            <p class="text-gray-500 mb-0"><?=MESSAGE_404?></p>
                            <a href="<?=BASE_ADMIN_URL?>login">&larr; <?=BACK_404?></a>
                        </div>
                    </div>
                    <!-- /.container-fluid -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'components/scripts.php' ?>