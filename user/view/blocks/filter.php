<section class="resume-section p-3 p-lg-5 d-flex align-items-center" id="about">
    <div class="w-100">
        <h1 class="mb-0"><?=ISSET($error) ? USER_FILTER_ERROR_TITLE_FIRST : USER_FILTER_TITLE_FIRST?>
            <span class="text-primary"><?=isset($error) ? USER_FILTER_ERROR_TITLE_LAST : USER_FILTER_TITLE_LAST?></span>
        </h1>
        <div class="subheading mb-5"><?=isset($error) ? USER_FILTER_ERROR_MESSAGE : USER_FILTER_MESSAGE?>
        </div>

        <form method="post" action="<?=BASE_USER_URL?>action/search/" id="searchForm">
            <div class="form-group input-group">
                <input type="text" class="form-control" name="username"<?=isset($error) ? 'value="'.$error.'"' : ''?>>
                <div class="input-group-append">
                    <span class="input-group-text" onclick='document.getElementById("searchForm").submit()'><i class="fa fa-search"></i></span>
                </div>
            </div>
        </form>
    </div>
</section>