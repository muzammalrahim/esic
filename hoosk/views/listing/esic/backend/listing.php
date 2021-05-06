<div class="tab-content">
                    <div id="<?= $ControllerRouteName;?>list_wrap" class="tab-pane fade in active">

                            <table id="<?= $ControllerRouteName;?>List" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th><input type="checkbox" name="select_all" id="" class="select_all" value="222"></th>
                                    <th>ID</th>
                                    <th><?= $ListingLabel; ?></th>
                                    <th>Email</th>
                                    <!--th>Website</th-->
                                    <th>Status</th>
                                    <th>Logo</th>
                                    <th>Publish</th>
                                    <th>Trashed</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th><input type="checkbox" name="select_all" id="" class="select_all" value="222"></th>
                                        <th>ID</th>
                                        <th><?= $ListingLabel; ?></th>
                                        <th>Email</th>
                                        <!--th>Website</th-->
                                        <th>Status</th>
                                        <th>Logo</th>
                                        <th>Publish</th>
                                        <th>Trashed</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                         <div class="row">
                              <div class="col-md-3">
                                 <select name="bulk_status" id="bulk_status" class="form-control">
                                     <option value="">Select Actions </option>
                                     <?php if(isCurrentUserAdmin(get_instance())){ ?>
                                         <option value="Approve"> Approve version </option>
                                         <option value="DisApprove"> DisApprove version </option>
                                         <option value="Published"> Published </option>
                                         <option value="UnPublished"> UnPublished </option>
                                     <?php } ?>
                                         <option value="Trashed"> Trashed  </option>
                                         <option value="Un-Trashed"> Un-Trashed  </option>
                                         <option value="Delete"> Delete </option>
                                     <?php
                                        if( $get_status && isCurrentUserAdmin(get_instance())){
                                            foreach($get_status as $status){?>
                                             <option value="<?= $status->id; ?>"> <?= $status->status; ?>  </option>
                                             <?php
                                            }
                                        }
                                      ?>
                                 </select>
                             </div>
                             <div class="col-md-3">
                                 <input type="button" name="submit"  value="Submit for Processing" id="<?= $ControllerRouteName;?>" class="btn btn-primary sub" >
                             </div>
                         </div>



                    </div>

