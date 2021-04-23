<section class="resume-section p-3 p-lg-5 d-flex align-items-center" id="projects">
    <div class="w-100">
        <h2 class="mb-5"><?=USER_MENU_PROJECTS?></h2>
        <?php
        $portfolio = array_filter($pro->projects, function($v) { return $v->visible; });

        foreach($portfolio as $p) { ?>
            <div class="resume-item d-flex flex-column flex-md-row justify-content-between mb-5">
                <div class="resume-image col-xl-2 col-lg-3 mb-5">
                    <img class="rounded-circle img-fluid m-auto d-block" src="<?=PROJ_IMG_BASE_PATH?><?=$p->image == null ? DEFAULT_IMG : $p->image?>" alt="">
                </div>
                <div class="resume-content col-xl-7 col-lg-5">
                    <h3 class="mb-0"><?=$p->name?></h3>
                    <div class="subheading mb-3"><?=$p->description?></div>
                </div>
                <div class="resume-date text-md-right col-xl-3 col-lg-4">
                    <div class="social-icons mt-5">
                        <?php foreach($p->links as $link) { ?>
                            <a class="link-container" href="<?=$link->type->baseUrl?><?=$link->url?>">
                                <img class="link-image" src="<?=ICON_BASE_PATH?><?=$link->type->image?>">
                            </a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</section>