<nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top" id="sideNav">
    <a class="navbar-brand js-scroll-trigger" href="#page-top">
        <span class="d-block d-lg-none"><?=$pro->name?></span>
        <span class="d-none d-lg-block">
        <img class="img-fluid img-profile rounded-circle mx-auto mb-2" src="<?=PROFILE_IMG_BASE_PATH?><?=$pro->picture == null ? DEFAULT_IMG : $pro->picture ?>" alt="">
      </span>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#about"><?=USER_MENU_ABOUT?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#experience"><?=USER_MENU_EXPERIENCE?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#education"><?=USER_MENU_EDUCATION?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#projects"><?=USER_MENU_PROJECTS?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#skills"><?=USER_MENU_SKILLS?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#interests"><?=USER_MENU_INTERESTS?></a>
            </li>
        </ul>
    </div>
</nav>