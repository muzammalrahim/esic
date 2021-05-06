<div class="push"></div>
</div>
</div>
<footer class="main-footer">
    <div class="pull-right hidden-xs">
    </div>
    <strong>Powered By <a href="https://esic.directory" target="_blank"> ESIC Directory</a>
    </strong>
</footer>
<!-- remote modals -->
<div id="remote-modals">
    <div class="modal fade" id="ajaxModal" aria-labelledby="ajaxModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            </div> <!-- /.modal-content -->
        </div> <!-- /.modal-dialog -->
    </div> <!-- /.modal -->
</div>
<?php
if($this->router->fetch_method() === 'Manage' && $this->router->fetch_class() === 'Esic'){
    ?>
    <!--end  -->
    <!--Edit Ward Modal-->
    <div class="modal approval-modal">
        <div class="modal-dialog" style="width: 50%;">
            <div class="modal-content">
                <div class="modal-header1">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Update Esic Status</h4>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="hiddenUserID">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="editStatusTextBox">Year</label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="editStatusTextBox">Prior Year Status</label>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="editStatusTextBox">Update Status</label>
                            </div>
                        </div>
                    </div>
                        <?php
                        $current_year = date('Y');
                        $c_date = date('Y-m-d');
                        if( $c_date > date("$current_year-06-30") && $c_date <= date("$current_year-12-31") ){
                            $current_year +=1;
                        }else if($c_date < date("$current_year-07-01") && $c_date >= date("$current_year-01-01") ){
                            $current_year = date('Y');
                        }
                        $esic_status_all = $this->Common_model->select('esic_status');
                        if(isset($current_year) and !empty($current_year)){
                            $total=$current_year-5;
                            for($year=$current_year;$year>$total;$year--){
                                ?>
                                <div class="row">
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <?= $year ?>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group empty appendhere<?=$year?>">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <select class="editStatusTextBox StatusTextBox<?=$year?>"" name="editStatusTextBox<?=$year?>" class="form-control">
                                                <option value="0">Select...</option>
                                                <?php

                                                if(isset($esic_status_all) and !empty($esic_status_all)){
                                                    foreach($esic_status_all as $esicstatus){
                                                       echo '<option value="'.$esicstatus->id.'" data-year="'.$year.'">'.$esicstatus->status.'</option>';
                                                   }
                                               }
                                               ?>
                                           </select>
                                       </div>
                                   </div>
                                </div>
                                <?php
                                    }
                                }
                            ?>




               </div>
               <div class="modal-footer">
                <button type="button" class="btn btn-danger mright" id="saveStatus" data-id="">Save</button>
                <button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Close">Cancel</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /.End Edit Ward Modal -->
<!-- /.modal -->
<!--Edit Ward Modal-->
    <div class="modal publish-modal hamid">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Publish</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="hiddenUserID">
                        <input type="hidden" id="publishStatusID">
                        <div class="col-md-12">
                            <p>Do You Want To <span id="publishStatusTextBox">Publish</span> <span id="EsicNameTextBox">This Esic Entry</span> ?</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="yesPublish">Yes</button>
                    <button type="button" class="btn btn-danger mright" data-dismiss="modal" aria-label="Close">No</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
<!-- /.End Edit Ward Modal --><!-- /.modal -->
<!--Edit Ward Modal-->
<div class="modal unpublish-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">UnPublish Esic</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="hiddenUserID" value="">
                    <div class="col-md-12">
                        <p>Are You Sure To UnPublish This Entry?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="yesUnPublish">Yes</button>
                <button type="button" class="btn btn-danger mright" data-dismiss="modal" aria-label="Close">No</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- /.End Edit Ward Modal --><!-- /.modal -->
<!--Edit Ward Modal-->
<div class="modal delete-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Deleted Status</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="hiddenUserID">
                    <div class="col-md-12">
                        <p>Are You Sure To Delete This Entry?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="yesDelete">Yes</button>
                <button type="button" class="btn btn-danger mright" data-dismiss="modal" aria-label="Close" id="nodelete">No</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<!-- /.End Edit Ward Modal --><!-- /.modal -->
    <!--added by hamid raza -->
    <div class="modal approval-modal-delete">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Trashed Model</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="hiddenUserID">
                        <div class="col-md-12">
                            <p>Do You Want To Trash This Status?</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" aria-label="Close" id="permanentDelete">Delete Permanent</button>
                    <button type="button" class="btn btn-success" id="yesApprove">Yes</button>
                    <button type="button" class="btn btn-danger mright" data-dismiss="modal" aria-label="Close" id="nodeleteit">No</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>


    <?php
}else if($this->router->fetch_method() === 'manage_status') {
    ?>
    <style>
        .modal select{
            min-height: 25px;
            max-width: 300px;
            display: block;
        }
    </style>
    <!--Edit Ward Modal-->
    <div class="modal approval-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Delete Esic Status</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="hiddenUserID">
                        <div class="col-md-12">
                            <p>Do You Want To Delete This Status?</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="yesApprove">Yes</button>
                    <button type="button" class="btn btn-danger mright" data-dismiss="modal" aria-label="Close" id="nodelete">No</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- /.End Edit Ward Modal --><!-- /.modal -->
    <?php
}else if($this->router->fetch_method() === 'manage_appstatus') {
    ?>
    <style>
        .modal select{
            min-height: 25px;
            max-width: 300px;
            display: block;
        }
    </style>
    <!--Edit Ward Modal-->
    <div class="modal approval-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Delete Esic ABR Status</h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="hiddenUserID">
                        <div class="col-md-12">
                            <p>Do You Want To Delete This ABR Status?</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="yesApprove">Yes</button>
                    <button type="button" class="btn btn-danger mright" data-dismiss="modal" aria-label="Close" id="nodelete">No</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- /.End Edit Ward Modal --><!-- /.modal -->
    <?php 
    //}else {
} else if($this->router->fetch_method() === 'manage_accelerators' 
    || $this->router->fetch_method() === 'manage_sectors' 
    || $this->router->fetch_method() === 'manage_rd'
    || $this->router->fetch_method() === 'manage_acc_commercials'
    || $this->router->fetch_class() === 'Esic'
    || $this->router->fetch_class() === 'Investor' 
    || $this->router->fetch_class() === 'Lawyer'
    || $this->router->fetch_class() === 'University'
    || $this->router->fetch_class() === 'RndConsultant'
    || $this->router->fetch_class() === 'RndPartner'  
    || $this->router->fetch_class() === 'GrantConsultant' 
    || $this->router->fetch_class() === 'Accelerator' 
    || $this->router->fetch_class() === 'AcceleratingCommercialisation'
    || $this->router->fetch_class() === 'TaxAdvisors'
    ){
   ?>
        <style>
            .modal select{
                min-height: 25px;
                max-width: 300px;
                display: block;
            }
        </style>
        <!--Edit Ward Modal-->
        <div class="modal approval-modal  ">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Trashed Model</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" id="hiddenUserID">
                            <div class="col-md-12">
                                <p>Do You Want To Trash This Status?</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" aria-label="Close" id="permanentDelete">Delete Permanent</button>
                        <button type="button" class="btn btn-success" id="yesApprove">Yes</button>
                        <button type="button" class="btn btn-danger mright" data-dismiss="modal" aria-label="Close" id="nodelete">No</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- /.End Edit Ward Modal --><!-- /.modal -->

        <div class="modal publish-modal hamid">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Publish</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" id="hiddenUserID">
                            <input type="hidden" id="publishStatusID">
                            <div class="col-md-12">
                                <p>Do You Want To <span id="publishStatusTextBox">Publish</span> <span id="EsicNameTextBox">This Esic Entry</span> ?</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="yesPublish">Yes</button>
                        <button type="button" class="btn btn-danger mright" data-dismiss="modal" aria-label="Close">No</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->




        <!--Edit Acceleration Modal-->
        <div class="modal permanent-modal" id="permanent-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Permanent Model</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" id="hiddenID">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" id="hiddenUserID">
                                    <label for="editrndTextBox">Are You Sure you want to make it Permanent?</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="yesPermanent">Yes</button>
                        <button type="button" class="btn btn-danger mright" data-dismiss="modal" aria-label="Close" id="noPermanent">No</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- /.End Edit Ward Modal --><!-- /.modal -->
        <!--Edit ABR Modal-->
        <div class="modal abr-modal" id="abr-modal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Australian Business Registration (Commonwealth of Australia)</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <input type="hidden" id="hiddenID">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="hidden" id="hiddenUserID">
                                    <label for="editAbrTextBox">Please Change ABR Status: </label>
                                    <select id="editAbrTextBox" name="editAbrTextBox" style="width: 80%;">
                                        <option value="0">Select...</option>
                                        <?php 
                                        $ci =& get_instance();
                                        $ci->load->model("Common_model");
                                        $statusApps = $ci->Common_model->select('esic_appstatus');
                                        if(isset($statusApps) and !empty($statusApps)){
                                            foreach($statusApps as $statusApp){
                                               echo '<option value="'.$statusApp->id.'">'.$statusApp->status.'</option>';
                                           }
                                       }   
                                       ?>    
                                   </select>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="yesSaveAbr">Yes</button>
                    <button type="button" class="btn btn-danger mright" data-dismiss="modal" aria-label="Close" id="noSaveAbr">No</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!-- /.End Edit Ward Modal --><!-- /.modal -->
    <?php 
} ?>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/bootstrap.jasny/3.13/css/jasny-bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<?php  $classname = $this->router->fetch_class(); ?>
   <!-- Bootstrap 3.3.6 -->
   <script src="<?= base_url()?>assets/vendors/bootstrap/js/bootstrap.min.js"></script>
   <!-- DataTables -->
   <script src="<?= base_url()?>assets/vendors/datatables/jquery.dataTables.min.js"></script>
   <script src="<?= base_url()?>assets/vendors/datatables/dataTables.bootstrap.min.js"></script>
   <script src="<?= base_url()?>assets/vendors/datatables/dataTables.responsive.js"></script>
   <!-- noty plugin -->
   <script type="text/javascript" src="<?php echo ADMIN_THEME; ?>/js/noty/packaged/jquery.noty.packaged.js"></script>
   <!-- Custom Notifications From Haider Plugin -->
   <script type="text/javascript" src="<?php echo ADMIN_THEME; ?>/js/Haider.js"></script>
   <!-- SlimScroll -->
   <script src="<?= base_url()?>assets/vendors/slimScroll/jquery.slimscroll.min.js"></script>
   <!-- FastClick -->
   <script src="<?= base_url()?>assets/vendors/fastclick/fastclick.js"></script>
   <!-- AdminLTE App -->
   <script src="<?= base_url()?>assets/js/app.min.js"></script>
   <!-- AdminLTE for demo purposes -->
   <script src="<?= base_url()?>assets/js/demo.js"></script>
   <script src="<?= base_url()?>assets/js/customScripting.js"></script>
   <script src="<?= base_url()?>assets/js/jquery.iframe-post-form.js"></script>
   <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
   <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js"></script>
   <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
   <script type="text/javascript" src="https://cdn.jsdelivr.net/bootstrap.jasny/3.13/js/jasny-bootstrap.min.js"></script>
   <script type="text/javascript" src="<?= base_url('theme/admin/js/bootstrap-confirmation.js') ?>"></script>
   <script> var baseUrl = "<?= base_url() ?>"; </script>
   <?php if ($this->router->fetch_method() === 'assessments_list') { ?>
   <script src="<?= base_url()?>assets/js/adminfooter.js"></script>
   <?php } if( $this->router->fetch_method() === 'details'){ ?>
   <script type="text/javascript" src="<?=base_url()?>assets/vendors/tinymce/tinymce.min.js"></script>
   <script src="<?= base_url()?>assets/js/admin-detail.js"></script>
   <?php } if ($this->router->fetch_method() === 'manage_sectors') { ?>
   <script src="<?= base_url()?>assets/js/admin-sectors.js"></script>
   <?php } if ($this->router->fetch_method() === 'manage_rd') { ?>
   <script src="<?= base_url()?>assets/js/admin-rnd.js"></script>
   <?php } if ($this->router->fetch_method() === 'manage_accelerators') { ?>
   <script src="<?= base_url()?>assets/js/admin-accelerators.js"></script>
   <?php } if ($this->router->fetch_class() === 'Esic') { ?>
   <script src="<?= base_url()?>assets/js/admin-esic.js"></script>
   <?php } if ($this->router->fetch_class() === 'Investor') { ?>
   <script src="<?= base_url()?>assets/js/admin-investor.js"></script>
   <?php } if ($this->router->fetch_class() === 'Accelerator') { ?>
   <script src="<?= base_url()?>assets/js/admin-accelerator.js"></script>
   <?php } if ($this->router->fetch_class() === 'University') { ?>
   <script src="<?= base_url()?>assets/js/admin-universities.js"></script>
   <?php } if ($this->router->fetch_class() === 'Lawyer') { ?>
   <script src="<?= base_url()?>assets/js/admin-lawyers.js"></script>
   <?php } if ($this->router->fetch_class() === 'GrantConsultant') { ?>
   <script src="<?= base_url()?>assets/js/admin-grantconsultant.js"></script>
   <?php } if ($this->router->fetch_class() === 'RndPartner') { ?>
   <script src="<?= base_url()?>assets/js/admin-rndpartner.js"></script>
   <?php } if ($this->router->fetch_class() === 'RndConsultant') { ?>
   <script src="<?= base_url()?>assets/js/admin-rndconsultant.js"></script>
   <?php }if ($this->router->fetch_method() === 'manage_acc_commercials') { ?>
   <script src="<?= base_url()?>assets/js/admin-acc.js"></script>
   <?php }if ($this->router->fetch_class() === 'AcceleratingCommercialisation') { ?>
   <script src="<?= base_url()?>assets/js/acceleratingcommercialisation.js"></script>
   <?php } if ($this->router->fetch_method() === 'manage_status') { ?>
   <script src="<?= base_url()?>assets/js/admin-status.js"></script>
   <?php } if ($this->router->fetch_method() === 'manage_appstatus') { ?>
   <script src="<?= base_url()?>assets/js/admin-appstatus.js"></script>
   <?php } if ($this->router->fetch_class() === 'TaxAdvisors') { ?>
   <script src="<?= base_url()?>assets/js/taxadvisors.js"></script>
   <?php } ?>

    <?php
        if($this->router->fetch_class() === 'Question'){
            if($this->router->fetch_method() === 'index'){
                echo '<link type="text/css" href="https://cdn.datatables.net/select/1.2.1/css/select.dataTables.min.css" />';
                echo '<link type="text/css" href="https://cdn.datatables.net/rowreorder/1.2.0/css/rowReorder.dataTables.min.css" />';

                echo '<script type="text/javascript" src="https://cdn.datatables.net/select/1.2.1/js/dataTables.select.min.js"></script>';
                echo '<script type="text/javascript" src="https://cdn.datatables.net/rowreorder/1.2.0/js/dataTables.rowReorder.min.js"></script>';
            }
            ?>
            <script type="text/javascript" src="<?=ADMIN_THEME?>/js/jquery-ui-1.9.2.js"></script>
<?php } ?>
<script type="text/javascript">
window.addEventListener('DOMContentLoaded', function() {
    //    Haider.notification('SUccessfuly Added','success','Heading Here');
    $('#remote-modals').on("hidden.bs.modal", ".modal:not(.local-modal)", function (e) {
        $(e.target).removeData("bs.modal").find(".modal-content").empty();
    });
    $(document).ready(function() {
        if( $('#pages-table').length > 0 ){
            var pagestable = $('#pages-table');
            pagestable.dataTable({
                "bPaginate" :true,
                "sPaginationType": "full_numbers",
                "bDestroy":true,
              //  "iDisplayStart": pagesTableStart,
                "iDisplayLength": 10
            });
       }
       if( $('#users-table').length > 0 ){
            var pagestable = $('#users-table');
            pagestable.dataTable({
                "bPaginate" :true,
                "sPaginationType": "full_numbers",
                "bDestroy":true,
                "iDisplayLength": 10
            });
       }
      
        $(".URLField").blur(function() {
            var identbefore=$(".URLField").val();
            var ident=identbefore.toLowerCase();
            ident=ident.replace(/ /g,'-');
            ident=ident.replace(/_/g,'-');
          //  ident=ident.replace(/[^\w-]+/g,'');0
            $(".URLField").val(ident);
            if( identbefore.length >ident.length ) {
                alert("URL amended\nPlease use only a-z,0-9 or dash");
            }
        });

        //Function to load the PostCodes from Live Server vv.   commented by hamid raza
//            var postCodesSelector = $('#address_post_code');
//            var postCodesURL = '<?//= base_url('get_post_codes')?>//';
//            if(typeof commonSelect2New == 'function') {
//                commonSelect2New(postCodesSelector,postCodesURL,0,'Select Post Code');
//                var postCodes;
//                var postCodesJSON;
//                    <?php
//                        if(!empty($selectors['postCodes'])){
//                            echo 'postCodes = \'' . $selectors['postCodes'] . '\';';
//                            echo 'postCodesJSON = JSON.parse(postCodes);';
//                    ?>
//                        $.each(postCodesJSON, function (key, data) {
//                            $('#address_post_code').append('<option value="' + data.ID + '" selected="selected">' + data.TEXT + '</option>');
//                        });
//                    <?php
//                        }//end of If Statement, If PostCodes is not empty
//                    ?>
//            }





        $('[data-toggle="popover"]').popover({
                container: 'body'
            });
        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm:function(){
                resetListingStatus('<?=$ControllerRouteName?>');
            }
            // other options
        });
    });
});
window.addEventListener('DOMContentLoaded', function() { // structure footer.php  added by Hamid raza
    jQuery(document).ready(function (e) {
        var $state = $('#address_state').val();
        var $postCodesURL = '<?= base_url('get_post_codes')?>';
        var $selector = $('#address_post_code');
        $selector.select2();
        getPostCodes($selector, $postCodesURL, $state);
        $('#address_state').on('select2:select', function (e) {
            var $state = $(this).val();
            getPostCodes($selector, $postCodesURL, $state);
        });

    })
})

    $( '#descriptionPage' ).submit(function ( e ) {
        e.preventDefault();
        SirTrevor.onBeforeSubmit();
        var url = $(this).attr( 'action' );
        console.log(url);
        $.ajax({
            url: url,
            type:"POST",
            data:  new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success:function(data){
                var data = data.split("::");
                Haider.notification(data[1], data[2]);
                $('#desc-edit-modal').modal('toggle');
            },
            error:function(){

            }

        })

    });
jQuery(document).ready(function () {
    setTimeout(function(){
        var value = jQuery('#address_post_code').data('post');
        if(value){
            $("#address_post_code").select2();
            $("#address_post_code").val(value).trigger("change");
        }
    }, 800);
    $('[data-toggle="tooltip"]').tooltip();
});



</script>

<div id="dialog-confirm" title="Alert!" style="display: none">
    <p><span class="ui-icon ui-icon-alert" style="float:left; margin:12px 12px 20px 0;"></span>
        These items will be permanently Deleted /Updated and cannot be recovered. Are you sure?</p>
</div>

<div class="modal alert-modal3">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Alert!</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="hiddenUserID">
                    <div class="col-md-12">
                        <p>  Please Selcet <?=$ControllerRouteName?> and  Actions to Perform Actions!</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-success "  data-dismiss="modal" aria-label="Close">Ok</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>
</body>
</html>