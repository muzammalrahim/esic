<?php 
    if(isset($detail) && !empty($detail)){

        $id          = $detail->id;
        $listName    = $detail->listName;
        $tableName   = $detail->tableName;
        $isActive    = $detail->isActive;
        $canSublist  = $detail->canSublist;
        $slug        = $detail->slug;
        $color       = $detail->color;

    }

?>
<div class="container-fluid">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Service Edit</h3>
            <div class="box-tools pull-right">
                <a href="<?= BASE_URL.'/admin/setting/services'?>" class="btn btn-small btn-primary">
                    Back
                </a> 
            </div>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <form action="<?= base_url().'Service/Edit/Save'?>" method="post" class="form">
                    <div class="box">
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" id="hiddenListID" value="">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="listName">Name</label>
                                        <input type="text" name="listName" id="listName" value="<?= $listName;?>" class="form-control" readonly />
                                    </div>
                                    <div class="form-group">
                                        <label for="color">Color Hex Code (#000000)</label>
                                        <input type="text" name="color" id="color" class="form-control" value="<?= $color;?>" />
                                    </div>
                                </div>
                            </div>
                        </div> <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="button-container">
                                <input type="hidden" name="id" value="<?=$id;?>" />
                                <a href="<?= BASE_URL.'/admin/setting/services'?>" class="btn btn-small btn-primary">Back</a>
                                <input type="submit" class="btn btn-primary" value="Save" />
                            </div> 
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.col -->
         </div><!-- /row --> 
        </div><!-- /.box-body -->
    </div><!-- /.box-info -->
</div><!-- /.container-fluid -->
