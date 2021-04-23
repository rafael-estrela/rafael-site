<section class="resume-section p-3 p-lg-5 d-flex align-items-center" id="education">
    <div class="w-100">
        <h2 class="mb-5"><?=USER_MENU_EDUCATION?></h2>
        <?php
        $education = array_filter($pro->graduation, function($v) { return $v->visible; });

        foreach($education as $e) { ?>
            <div class="resume-item d-flex flex-column flex-md-row justify-content-between mb-5">
                <div class="resume-image col-xl-2 col-lg-3 mb-5">
                    <img class="rounded-circle img-fluid m-auto d-block" src="<?=GRAD_IMG_BASE_PATH?><?=$e->image == null ? DEFAULT_IMG : $e->image?>" alt="">
                </div>
                <div class="resume-content col-xl-7 col-lg-5">
                    <h3 class="mb-0"><?=$e->institution?></h3>
                    <div class="subheading mb-3"><?=$e->title?></div>
                </div>
                <div class="resume-date text-md-right col-xl-3 col-lg-4">
                    <span class="text-primary"><?=StringUtils::periodString($e->startPeriod, $e->endPeriod)?></span>
                </div>
            </div>
        <?php } ?>
    </div>
</section>