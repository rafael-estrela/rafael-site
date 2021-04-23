<?php
$nameArr = explode(" ", $pro->name);
$first = '';
$last = '';

$words = count($nameArr);

$last = $nameArr[$words - 1];

unset($nameArr[$words - 1]);

$first = implode(" ", $nameArr)
?>
<section class="resume-section p-3 p-lg-5 d-flex align-items-center" id="about">
    <div class="w-100">
        <h1 class="mb-0"><?=$first?>
            <span class="text-primary"><?=$last?></span>
        </h1>
        <div class="subheading mb-5"><?=StringUtils::mask($pro->phone, "## #####-####")?> ·
            <a href="mailto:<?=$pro->email?>"><?=$pro->email?></a>
        </div>
        <?=StringUtils::nl2p($pro->desc)?>
        <div class="social-icons mt-5">
            <?php if ($pro->linkedin != null) { ?>
                <a href="https://www.linkedin.com/in/<?=$pro->linkedin?>" target="_blank">
                    <i class="fab fa-linkedin-in"></i>
                </a>
            <?php } ?>
            <?php if ($pro->github != null) { ?>
                <a href="<?=$pro->github?>" target="_blank">
                    <i class="fab fa-git"></i>
                </a>
            <?php } ?>
            <?php if ($pro->site != null) { ?>
                <a href="http://<?=$pro->site?>" target="_blank">
                    <i class="fab fa fa-globe"></i>
                </a>
            <?php } ?>
            <a href="<?=BASE_API_URL?>pdf/<?=$username?>/">
                <i class="fab fa fa-file-pdf"></i>
            </a>
        </div>
    </div>
</section>