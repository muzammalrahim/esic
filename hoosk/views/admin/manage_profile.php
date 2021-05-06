
    <!-- Content Wrapper. Contains page content -->
    <div class="">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Pre-assessment
                <small>LIST</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Pre-Assessments</a></li>
                <li class="active">list</li>
            </ol>
        </section>
        
        
       
        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title"></h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="regLister" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th class="tablet desktop">ID</th>
                                    <th class="mobile tablet desktop">Name</th>
                                    <th class="tablet desktop">Email</th>
                                    <th>Company</th>
                                    <th class="tablet-l desktop">Status</th>
                                    <th class="mobile tablet desktop">Action</th>
                                    <th class="mobile tablet desktop">Publish</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th class="tablet desktop">ID</th>
                                    <th class="mobile tablet desktop">Name</th>
                                    <th class="tablet desktop">Email</th>
                                    <th>Company</th>
                                    <th class="tablet-l desktop">Status</th>
                                    <th class="mobile tablet desktop">Action</th>
                                    <th class="mobile tablet desktop">Publish</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <!-- Model -->
    <div class="modal change-status">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Publish</h4>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="hiddenUserID">
                        <div class="col-md-12">
                            <p>Are You Sure To Publish ?</p>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="yes-change-status">Yes</button>
                    <button type="button" class="btn btn-danger mright" data-dismiss="modal" aria-label="Close" id="nodelete">No</button>
                </div>

            </div>
        </div>
    </div>


<!-- Js file name : Adminfooter.js in assets js -->
<script>
    $(function () {
        //// Need To Work ON New Way Of DataTables..
        oTable = "";
        //Initialize Select2 Elements
        var regTableSelector = $("#regLister");
        var url_DT = baseUrl + "admin/manage_profile/listing";
        var aoColumns_DT = [
            /* User ID */ {
                "mData": "UserID",
                "bVisible": true,
                "bSortable": true,
                "bSearchable": true
            },
            /* Full Name */ {
                "mData": "FullName"
            },
            /* Email */ {
                "mData": "Email"
            },

            /*  Buisness */ {
                "mData": "Company"
            },

            /* Last User Login */ {
                "mData": "Status"
            },
            /* Action Buttons */ {
                "mData": "ViewEditActionButtons"
            },
            /* Publish Buttons */ {
                "mData": "Publish"},


        ];
        var HiddenColumnID_DT = "UserID";
        var sDom_DT = '<"H"r>t<"F"<"row"<"col-lg-6 col-xs-12" i> <"col-lg-6 col-xs-12" p>>>';
        var newRowNumber =  localStorage.getItem("pageNumber") * 10;
        if(newRowNumber == undefined || newRowNumber == '' ){
            newRowNumber = 0;
        }
        commonDataTablesPage(regTableSelector, url_DT, aoColumns_DT, sDom_DT, HiddenColumnID_DT,newRowNumber);
        //oTable.fnPageChange(40);
        new $.fn.dataTable.Responsive(oTable, {
            details: true,
        });
        removeWidth(oTable);
        //Code for search box
        $("#search-input").on("keyup", function (e) {
            oTable.fnFilter($(this).val());
        });



        $(".change-status").on("shown.bs.modal", function (e) {

            var button = $(e.relatedTarget); // Button that triggered the modal
            var ID = button.parents("tr").attr("data-id");
            var modal = $(this);
            modal.find("input#hiddenUserID").val(ID);
          //  modal.find(".modal-body").find('p > strong').text(' "' + Status + '"');
        });
        $("#yes-change-status").on("click", function () {
            var hiddenModalID = $(this).parents(".modal-content").find("#hiddenUserID").val();
            var postData = {id: hiddenModalID};
            $.ajax({
                url: baseUrl + "admin/publish_assessment_list",
                data: postData,
                type: "POST",
                success: function (output) {
                    var data = output.split("::");
                    if (data[0].split(' ').join('') == 'OK') {
                        $(".change-status").modal('hide');
                        //oTable.draw();
                    }
                }
            });
        });

  });

</script>
 