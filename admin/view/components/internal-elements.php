<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?=LOGOUT_MODAL_TITLE?></h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"><?=LOGOUT_MODAL_MESSAGE?></div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal"><?=LOGOUT_CANCEL?></button>
                <a class="btn btn-primary" href="<?=BASE_ADMIN_URL?>login?logout"><?=LOGOUT_CONFIRM?></a>
            </div>
        </div>
    </div>
</div>