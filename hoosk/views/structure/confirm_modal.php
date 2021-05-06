
<div id="<?= $ControllerRouteName;?>status_wrap" class="tab-pane fade">
    <table id="<?= $ControllerRouteName;?>Status" class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th><?= $ListingLabel; ?></th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
        <tfoot>
        <tr>
            <th>ID</th>
            <th><?= $ListingLabel; ?></th>
            <th>Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </tfoot>
    </table>
</div>
</div>
<!-- Modal -->
<div class="modal fade confirm-modal" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document" style="width:300px">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="exampleModalLongTitle">Confirm Delete</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure to delete this status?
            </div>
            <input type="hidden" class="prevStatusId" />
            <input type="hidden" class="delete-status-url" value="<?=$ControllerRouteName?>" />
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary delete-prev-status">Yes</button>
            </div>
        </div>
    </div>
</div>