<?php
$controller->getProfessionalResume(false);

$graduation = $controller->getProfessional()->graduation;
$work = $controller->getProfessional()->workplaces;
$projects = $controller->getProfessional()->projects;
$skills = $controller->getProfessional()->skills;
?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?=BASE_ADMIN_URL?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-horse-head"></i>
        </div>
        <div class="sidebar-brand-text mx-3"><?=MENU_SITE_NAME?></div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item<?=$TRK_CURR == TRACKING_INDEX ? " active" : ""?>">
        <a class="nav-link" href="<?=BASE_ADMIN_URL?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span><?=MENU_DASHBOARD?></span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        <?=MENU_SITE_GROUP_PROFESSIONAL?>
    </div>
    <!-- Nav Item - Graduation Collapse Menu -->
    <li class="nav-item<?=$TRK_CURR == TRACKING_GRADUATION ? " active" : ""?>">
        <a class="nav-link<?=$TRK_CURR == TRACKING_GRADUATION ? "" : " collapsed"?>" href="#" data-toggle="collapse" data-target="#graduationContainer" aria-expanded="<?=$TRK_CURR == TRACKING_GRADUATION ? "true" : "false"?>" aria-controls="graduationContainer">
            <i class="fas fa-fw fa-graduation-cap"></i>
            <span><?=MENU_ITEM_GRADUATION?></span>
        </a>
        <div id="graduationContainer" class="collapse<?=$TRK_CURR == TRACKING_GRADUATION ? " show" : ""?>" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <?php
                foreach($graduation as $item) {?>
                <a class="collapse-item" href="<?=BASE_ADMIN_URL?>graduation/<?=$item->id?>/">
                    <i class="fas fa-fw fa-university"></i> <?=$item->title?>
                </a>
                <?php
                }
                ?>
                <a class="collapse-item" href="<?=BASE_ADMIN_URL?>graduation/">
                    <i class="fas fa-fw fa-plus"></i> <?=MENU_ITEM_ADD?>
                </a>
            </div>
        </div>
    </li>
    <!-- Nav Item - Work Collapse Menu -->
    <li class="nav-item<?=$TRK_CURR == TRACKING_WORK ? " active" : ""?>">
        <a class="nav-link<?=$TRK_CURR == TRACKING_WORK ? "" : " collapsed"?>" href="#" data-toggle="collapse" data-target="#workContainer" aria-expanded="<?=$TRK_CURR == TRACKING_WORK ? "true" : "false"?>" aria-controls="workContainer">
            <i class="fas fa-fw fa-briefcase"></i>
            <span><?=MENU_ITEM_WORK?></span>
        </a>
        <div id="workContainer" class="collapse<?=$TRK_CURR == TRACKING_WORK ? " show" : ""?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <?php
                foreach($work as $item) {
                ?>
                <a class="collapse-item" href="<?=BASE_ADMIN_URL?>work/<?=$item->id?>/">
                    <i class="fas fa-fw fa-building"></i> <?=$item->company?>
                </a>
                <?php
                }
                ?>
                <a class="collapse-item" href="<?=BASE_ADMIN_URL?>work/">
                    <i class="fas fa-fw fa-plus"></i> <?=MENU_ITEM_ADD?>
                </a>
            </div>
        </div>
    </li>
    <!-- Nav Item - Projects Collapse Menu -->
    <li class="nav-item<?=$TRK_CURR == TRACKING_PROJ ? " active" : ""?>">
        <a class="nav-link<?=$TRK_CURR == TRACKING_PROJ ? "" : " collapsed"?>" href="#" data-toggle="collapse" data-target="#projectsContainer" aria-expanded="<?=$TRK_CURR == TRACKING_PROJ ? "true" : "false"?>" aria-controls="projectsContainer">
            <i class="fas fa-fw fa-book"></i>
            <span><?=MENU_ITEM_PROJECTS?></span>
        </a>
        <div id="projectsContainer" class="collapse<?=$TRK_CURR == TRACKING_PROJ ? " show" : ""?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <?php
                foreach($projects as $item) {
                    ?>
                    <a class="collapse-item" href="<?=BASE_ADMIN_URL?>project/<?=$item->id?>/">
                        <i class="fas fa-fw fa-keyboard"></i> <?=$item->name?>
                    </a>
                    <?php
                }
                ?>
                <a class="collapse-item" href="<?=BASE_ADMIN_URL?>project/">
                    <i class="fas fa-fw fa-plus"></i> <?=MENU_ITEM_ADD?>
                </a>
            </div>
        </div>
    </li>
    <!-- Nav Item - Skills Collapse Menu -->
    <li class="nav-item<?=$TRK_CURR == TRACKING_SKILLS ? " active" : ""?>">
        <a class="nav-link<?=$TRK_CURR == TRACKING_SKILLS ? "" : " collapsed"?>" href="#" data-toggle="collapse" data-target="#skillsContainer" aria-expanded="<?=$TRK_CURR == TRACKING_PROJ ? "true" : "false"?>" aria-controls="skillsContainer">
            <i class="fas fa-fw fa-lightbulb"></i>
            <span><?=MENU_ITEM_SKILLS?></span>
        </a>
        <div id="skillsContainer" class="collapse<?=$TRK_CURR == TRACKING_SKILLS ? " show" : ""?>" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <?php
                foreach($skills as $item) {
                    ?>
                    <a class="collapse-item" href="<?=BASE_ADMIN_URL?>skill/<?=$item->skillId?>/">
                        <i class="fas fa-fw fa-laptop-code"></i> <?=$item->name?>
                    </a>
                    <?php
                }
                ?>
                <a class="collapse-item" href="<?=BASE_ADMIN_URL?>skill/">
                    <i class="fas fa-fw fa-plus"></i> <?=MENU_ITEM_ADD?>
                </a>
            </div>
        </div>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        <?=MENU_SITE_GROUP_PERSONAL?>
    </div>
    <!-- Nav Item - Trivia -->
    <li class="nav-item<?=$TRK_CURR == TRACKING_TRIVIA ? " active" : ""?>">
        <a class="nav-link" href="<?=BASE_ADMIN_URL?>trivia/">
            <i class="fas fa-fw fa-info"></i>
            <span><?=MENU_ITEM_TRIVIA?></span></a>
    </li>
    <!-- Nav Item - Description -->
    <li class="nav-item<?=$TRK_CURR == TRACKING_DESC ? " active" : ""?>">
        <a class="nav-link" href="<?=BASE_ADMIN_URL?>greetings/">
            <i class="fas fa-fw fa-user-astronaut"></i>
            <span><?=MENU_ITEM_DESC?></span></a>
    </li>
    <!-- Nav Item - Contact -->
    <li class="nav-item<?=$TRK_CURR == TRACKING_CONTACT ? " active" : ""?>">
        <a class="nav-link" href="<?=BASE_ADMIN_URL?>contact/">
            <i class="fas fa-fw fa-mobile-alt"></i>
            <span><?=MENU_ITEM_CONTACT?></span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->