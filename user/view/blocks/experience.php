<section class="resume-section p-3 p-lg-5 d-flex justify-content-center" id="experience">
    <div class="w-100">
        <h2 class="mb-5"><?=USER_MENU_EXPERIENCE?></h2>
        <?php
        $workplaces = array_filter($pro->workplaces, function($v) { return $v->visible; });

        foreach($workplaces as $work) { ?>
            <div class="resume-item d-flex flex-column flex-md-row justify-content-between mb-5">
                <div class="resume-image col-xl-2 col-lg-3 mb-5">
                    <img class="rounded-circle img-fluid m-auto d-block" src="<?=WORK_IMG_BASE_PATH?><?=$work->image == null ? DEFAULT_IMG : $work->image?>" alt="">
                </div>
                <div class="resume-content col-xl-7 col-lg-5">
                    <h3 class="mb-0"><?=$work->position?></h3>
                    <div class="subheading mb-3"><?=$work->company?></div>
                    <p><?=$work->description?></p>
                </div>
                <div class="resume-date text-md-right col-xl-3 col-lg-4">
                    <span class="text-primary"><?=StringUtils::periodString($work->startPeriod, $work->endPeriod)?></span>
                </div>
            </div>
        <?php } ?>
    </div>
</section>