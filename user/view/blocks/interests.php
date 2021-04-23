<section class="resume-section p-3 p-lg-5 d-flex align-items-center" id="interests">
    <div class="w-100">
        <h2 class="mb-5"><?=USER_MENU_INTERESTS?></h2>
        <?php foreach ($pro->trivia as $i) { ?>
            <p><?=$i->value?>.</p>
        <?php } ?>
    </div>
</section>