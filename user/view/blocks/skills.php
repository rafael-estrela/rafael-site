<section class="resume-section p-3 p-lg-5 d-flex align-items-center" id="skills">
    <div class="w-100">
        <h2 class="mb-5"><?=USER_MENU_SKILLS?></h2>
        <?php
        $filteredSkills = array_filter($controller->getProfessional()->skills, function($v) { return $v->visible; });
        ?>

        <div class="w-100">
            <?php foreach ($filteredSkills as $skill) { ?>
                <div class="resume-skill">
                    <p><?=$skill->name?></p>
                    <p class="resume-stars"><?=SkillUtil::percentToStars($skill->percentage)?></p>
                </div>
            <?php } ?>
        </div>
    </div>
</section>