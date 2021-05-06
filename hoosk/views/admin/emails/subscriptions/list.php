
<style>
    .table-bordered>tbody>tr>td:nth-child(2) {

        max-width: 100px !important;
    }
    .table-bordered>tbody>tr>td:nth-child(2){
        overflow:hidden;
        white-space:nowrap;
        -ms-text-overflow:ellipsis;
        text-overflow:ellipsis;
        max-width: 100px !important;
        height:1.2em;
    }
    .table-bordered>tbody>tr>td:nth-child(2):hover {
        overflow:visible;
        color:#00F;
        background:#FFF;
    }
    .table-bordered>tbody>tr>td:nth-child(3) {

        max-width: 150px !important;
    }
    .table-bordered>tbody>tr>td:nth-child(3){
        overflow:hidden;
        white-space:nowrap;
        -ms-text-overflow:ellipsis;
        text-overflow:ellipsis;
        max-width: 100px !important;
        height:1.2em;
    }
    .table-bordered>tbody>tr>td:nth-child(3):hover {
        overflow:visible;
        color:#00F;
        background:#FFF;

    }
</style>
<section class="content-header">
    <h1>
        Mailbox
        <small><?php  echo $Count_contact_message;?> New Messages</small>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?= base_url()?>admin"><?php echo $this->lang->line('nav_dash'); ?></a></li>

        <li class="active">Manage Subscriptions</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-3">
            <a href="<?php echo BASE_URL ; ?>/admin/contact/manage_contact" class="btn btn-primary btn-block margin-bottom">Back To Messages</a>
            <div class="box box-solid">
                <div class="box-header with-border">
                    <h3 class="box-title">Folders</h3>

                    <div class="box-tools">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="box-body no-padding">
                    <ul class="nav nav-pills nav-stacked">
                        <li><a href="<?=base_url('admin/users/email')?>"><i class="fa fa-envelope-o"></i> Compose Email</a></li>
                        <li><a href="<?php echo BASE_URL ; ?>/admin/contact/manage_contact"><i class="fa fa-envelope-o"></i> Inbox
                                <span class="label label-primary pull-right"><?= $Count_contact_message; ?></span></a></li>
                        <li><a href="<?=base_url('admin/users/sent')?>"><i class="fa fa-envelope-o"></i> Sent
                                <span class="label label-primary pull-right"><?= $Count_email_message; ?> </span>
                            </a>
                        </li>
                        <li><a href="<?=base_url('admin/subscriptions')?>"><i class="fa fa-envelope-o"></i> Subscriptions
                                <span class="label label-primary pull-right"><?= $subscriptions; ?> </span>
                            </a>
                        </li>
                        <li><a href="<?= base_url()?>admin/users"><i class="fa fa-user"></i> Select Users  </a></li>

                    </ul>
                </div>
                <!-- /.box-body -->
            </div>
            <!-- /. box -->
            <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Manage Subscriptions</h3>
                </div>

                <section class="content">
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Filter By</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="text" id="email" class="form-control select2" placeholder="Email">
                                        </div><!-- /.form-group -->
                                    </div><!-- /.form-group -->
                                </div><!-- /.col -->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Date</label>
                                        <input type="text" id="Search_by_Date" class="form-control select2" placeholder="Search By Date">
                                    </div><!-- /.form-group -->
                                </div><!-- /.col -->

                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer clearfix">
                        </div>
                        <!-- /.box-footer -->
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-body">
                                    <table id="statusList" class="table table-bordered table-striped">
                                        <thead>
                                        <tr>
                                            <th><input type="checkbox" name="select_all" id="" class="select_all" value="222"></th>
                                            <th>ID</th>
                                            <th>Email</th>
                                            <th>Date Time</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th><input type="checkbox" name="select_all" id="" class="select_all" value="222"></th>
                                            <th>ID</th>
                                            <th>Email</th>
                                            <th>Date Time</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <select name="bulk_status" id="bulk_status" class="form-control">
                                                <?php if(isCurrentUserAdmin(get_instance())){ ?>
                                                    <option value="Approve">Send Email </option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <form method="post" action="<?= BASE_URL.'/admin/users/email';?>" id="target">
                                                <input type="hidden" name="subscriptions"  value="" class="emails  ">
                                                <a name="submit"  value="" class="btn btn-primary send_email"  >Submit for Processing</a>
                                           </form>
                                        </div>
                                    </div>
                                </div> <!-- /.box-body -->
                                <div class="box-footer">

                                </div>
                            </div>
                            <!-- /.box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </section>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
</section>
<div class="modal approval-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Trashed Email</h4>
            </div>

            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="hiddenUserID">
                    <div class="col-md-12">
                        <p>Do You Want To Trash This Email?</p>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" id="yesApprovesss">Yes</button>
                <button type="button" class="btn btn-danger mright" data-dismiss="modal" aria-label="Close" id="nodelete">No</button>
            </div>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>


<script>
    $(function () {
        oTable = "";
        var regTableSelector = $("#statusList");
        var url_DT = baseUrl + "admin/subscriptions/listing";
        var aoColumns_DT = [
            {
                "mData": "ID",
                "bSortable": false,
                "bSearchable": false,
                "render":function( data, type, full, meta){
                    if(data!=''){
                        return '<input type="checkbox" name="ids" value="' + $('<div/>').text(data).html() + '" class="inner_select">';
                    }
                    return data;
                }
            },
            /* ID */ {
                "mData": "ID",
                "bVisible": true,
                "bSortable": true,
                "bSearchable": true
            },
            {
                "mData": "Email",

            },
            {
                "mData": "Date",
                "render":function(data,type,row){
                    var d  = new Date(data);
                    da =  d.getDate()+'-'+ (d.getMonth() + 1 )+'-'+d.getFullYear() +'     '+d.getHours()+'-'+d.getMinutes();
                    return da;
                }
            },
            {
                "mData": "ViewEditActionButtons"
            }
        ];
        var HiddenColumnID_DT = "ID";
        var sDom_DT = '<"H"r>t<"F"<"row"<"col-lg-6 col-xs-12" i> <"col-lg-6 col-xs-12" p>>>';
        commonDataTables(regTableSelector, url_DT, aoColumns_DT, sDom_DT, HiddenColumnID_DT);
        new $.fn.dataTable.Responsive(oTable, {
            details: true
        });
        removeWidth(oTable);
        oTable = $('#statusList').DataTable();
        $('#email').keyup(function(){
            oTable.column(1).search($(this).val()).draw() ;
        })
        oTable = $('#statusList').DataTable();
        $('#Search_by_Date').keyup(function(){
            oTable.column(2).search($(this).val()).draw() ;
        })

        $("#yesApprovesss").on("click", function () {
            var hiddenModalID = $(this).parents(".modal-content").find("#hiddenUserID").val();
            var postData = {id: hiddenModalID, value: "delete"};
            $.ajax({
                url: baseUrl + "admin/subscriptions/delete",
                data: postData,
                type: "POST",
                success: function (output) {
                    var data = output.split("::");
                    console.log(data);
                    if (data[0].split(' ').join('') == 'OK') {
                        $(".approval-modal").modal('hide');
                        oTable.draw();
                    }
                    if(data[3]){
                        Haider.notification(data[1], data[2], data[3]);
                    }
                    else{
                        Haider.notification(data[1], data[2]);
                    }
                }
            });
        });
        $('.select_all').on('click', function(){  // onclick select all added by Hamid
            // Check/uncheck all checkboxes in the table
            var rows = oTable.rows({ 'search': 'applied' }).nodes();
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });
        var Controller = $('.sub').attr('id');
        $('.send_email').click(function(e){
            e.preventDefault();
            var favorite = [];
            $.each($("input[name='ids']:checked"), function(){
                favorite.push($(this).parents('tr').find('td:nth-child(3)').text());
            });
            var emails = favorite.join(", ");
            $('.emails').val(emails);
            $( "#target" ).submit();
            });
    });
</script>