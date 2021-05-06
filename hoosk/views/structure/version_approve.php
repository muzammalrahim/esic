<div class="modal approve-modal" role="dialog" aria-hidden="true">
    <div class="modal-dialog  modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 style="font-size:24px" class="modal-title">New Version</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p></p>
                <div class="disapprove collapse" style="position:relative">
                    <textarea class="form-control disapproval-msg" rows="6" placeholder="Why are you disapproving?"></textarea>
                </div>
                <!--hidden fields set when modal opens-->
                <input type="hidden" name="slug_val" />
                <input type="hidden" name="list_val" />
                <input type="hidden" name="ver_val" />
                <?php if(isset($this->ControllerName)) { ?>
                <input type="hidden" name="route" value="<?=$this->ControllerName ?>" />
                <?php }?>
            </div>
            <div class="modal-footer">
                <a class="btn btn-primary" onclick="getVersionView()" id="verViewFront" target="_blank">View</a>
                <a type="button" class="btn btn-success approve" onclick="approveVersion()">Approve</a>
                <a type="button" data-toggle="collapse" data-target=".disapprove" class="btn btn-danger disapprove-btn" data-id="disapprove" onclick="disapproveVersion(this)">Disapprove</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>