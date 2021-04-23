<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <div class="topbar-divider d-none d-sm-block"></div>
        <!-- Nav Item - User Information -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?=$controller->getProfessional()->name?></span>
                <img class="img-profile rounded-circle" src="<?=PROFILE_IMG_BASE_PATH?><?=$controller->getProfessional()->picture == null ? DEFAULT_IMG : $controller->getProfessional()->picture?>">
            </a>
            <!-- Dropdown - User Information -->
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?=BASE_ADMIN_URL?>settings/">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    <?=MENU_TOP_SETTINGS?>
                </a>
                <a class="dropdown-item" target="_blank" href="<?=BASE_USER_URL?><?=$controller->getProfessional()->username?>/">
                    <i class="fa-spin fas fa-spinner fa-sm fa-fw mr-2 text-gray-400"></i>
                    <?=MENU_TOP_PREVIEW?>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    <?=MENU_TOP_LOGOUT?>
                </a>
            </div>
        </li>
    </ul>
</nav>
<!-- End of Topbar -->