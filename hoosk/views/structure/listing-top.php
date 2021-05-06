<?php $ci = &get_instance();
if(isset($message) and !empty($message)){
    page_message($this,$message);
}
?>
<div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Filter By</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                </div>
            </div>

            <div class="box-body">

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Name</label>
                            <input type="text" id="searchbyName" class="form-control select2" placeholder="Search By Name">
                        </div>
                    </div>
                </div>
            </div>

            <div class="box-footer clearfix">
            </div>

        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a data-toggle="tab" id="list_tab" href="#<?= $ControllerRouteName;?>list_wrap"><h3 class="box-title">Manage <?= $ListingLabel; ?></h3></a>
                            </li>
                            <?php if($statusContent && isCurrentUserAdmin($ci)) { ?>
                            <li>
                                <a data-toggle="tab" id="status_tab" href="#<?= $ControllerRouteName;?>status_wrap"><h3 class="box-title">Previous Status</h3></a>
                            </li>

                            <?php }?>
                        </ul>

                        <div class="add-New-container">
                            <?php if($statusContent && isCurrentUserAdmin($ci)) { ?>
                            <a class="btn btn-sm btn-info pull-left reset-status" data-trigger="hover" data-toggle="confirmation" title="Reset Status" data-content="<?=$statusContent?>">Reset Status</a>
                            <div class="row status-year pull-left  hide">
                                <div class="col-md-12">
                                    <select class="form-control" id="status-year">
                                        <?php
                                            $listing_years = $ci->getpreviouslistingyears();
                                            if(!empty($listing_years)){
                                                foreach ($listing_years as $years){
                                                    echo  "<option value=".$years.">".$years."</option>";
                                                }
                                            }else{
                                                echo  "<option value=".date("Y").">".date("Y")."</option>";
                                            }

                                        ?>
                                    </select>
                                </div>
                            </div>
                            <?php } ?>
                            <a href="<?= base_url().$ControllerRouteName.'/Add'; ?>" class="addNewBtn">Add New</a>
                          </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
