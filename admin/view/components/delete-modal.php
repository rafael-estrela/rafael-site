<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?=DELETE_MODAL_TITLE?></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"><?=$modalMsg?></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal"><?=DELETE_CANCEL?></button>
                <a class="btn btn-primary" href="<?=$modalAction?>"><?=DELETE_CONFIRM?></a>
            </div>
        </div>
    </div>
</div>
