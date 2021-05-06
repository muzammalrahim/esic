$(function(){
    if($("#EsicList").length > 0){
        oTable = "";
        var regTableSelector = $("#EsicList");
        var url_DT = baseUrl + "admin/manage_esic/listing";
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
                "bSearchable": true,
                "render":function( data, type, full, meta){
                    if(data!=''){
                        //return '<a href="'+base_url+'admin/Esic/view/'+full.ID+'" >'+full.ID+'</a>';
                        return '<a href="'+base_url+'admin/Esic/view/'+full.ID+'" >'+full.ID+'</a>';
                    }
                    return data;

                }
            },

            /* Name */ {
                "mData": "Name",
                "render":function( data, type, full, meta){
                    if(data!=''){
                        var FullName = full.Name;
                        var $newVer = ''
                        if(full.New_Ver == 'Yes'){
                            if(full.isAdmin == 'yes'){
                                if(full.Cancel == 1)
                                    $newVer = '<span data-id="disapprove" data-slug="'+full.slug+'" data-ver-id="'+full.Ver_Id+'" data-list-id="'+full.list_Id+'" onclick="showApproveModal(this)" class="label label-danger new-version">Disapproved Version</span>';
                                else
                                    $newVer = '<span data-id="pending" data-slug="'+full.slug+'" data-ver-id="'+full.Ver_Id+'" data-list-id="'+full.list_Id+'" onclick="showApproveModal(this)" class="label label-warning new-version">New Version</span>';
                            }else{
                                 FullName = full.vr_Name;
                            }
                        }
                        return '<a class="list-name" href="'+base_url+'admin/Esic/view/'+full.ID+'" >'+FullName+'</a> '+$newVer;
                    }
                    return data;

                }
            },
            //Email Address
            {
              "mData": "Email"
            },

            //Website Address
            /*{
                "mData": "Website",
                "render": function(data, type, full){
                    if(data!='') {
                        var $website = 'Empty';
                        if (full.New_Ver == 'Yes') {
                            if (full.isAdmin == 'yes' && full.vr_Website!=null)
                                $website = full.Website;
                            else if(full.isAdmin == 'no')
                                $website = full.vr_Website;
                        } else $website = full.Website;
                        return $website;
                    }
                    return data;
                }
            },*/
            // Status Label
            {
                "mData": "Status_Label"
            },
            //Logo or Avatar
            {
                "mData": "Logo",
                "render": function ( data, type, row ) {
                    if(data!=''){ console.log(row.Logo); console.log(row.vr_Logo);
                        var $src = data;
                        if (row.New_Ver == 'Yes' && row.isAdmin == 'no') {
                            if (row.vr_Logo!=null){
                                $src = row.vr_Logo;
                            } else if(row.isAdmin == 'no'){
                                $src = 'Empty';
                            }
                        }
                        return '<img data-target=".logo-edit-modal" data-toggle="modal" alt="Edit" src="'+$src+'" class="esic-logo" style="height:50px;width:50px;cursor:pointer;" />';
                    }
                    return '<span data-target=".logo-edit-modal" data-toggle="modal" class="esic-logo">Empty </span>';
                },
                "className":"centerLogo"
            },
            /* Publish */ {
                "mData": "Publish",
                "render": function ( data, type, full, meta){
                    if(data!=''){
                        return '<div data-publishstatusid="'+full.PublishStatusID+'" class="Publish-Status">'+full.Publish+'</div>';
                    }
                    return '<span>Empty</span>';
                }
            },
            /* Trashed */ {
                "mData": "Trashed"
            },
            /* Action Buttons */ {
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

        sTable = $('#EsicList').DataTable();  // // Search by Title
        $("#search-input").on("keyup", function (e) {
            sTable.fnFilter($(this).val());
        });

        $('#searchbyName').keyup(function(){
            if($('.nav-tabs li:first-child').hasClass('active'))
                sTable = $('#EsicList').DataTable();
            else
                sTable = $('#EsicStatus').DataTable();
           sTable.column(2).search($(this).val()).draw();
        });
        $('.select_all').on('click', function(){  // onclick select all added by Hamid
            // Check/uncheck all checkboxes in the table
            var rows = sTable.rows({ 'search': 'applied' }).nodes();
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });

    }

    $(document).on('click','.fetch_status',function(){
        var  ID = $(this).parents("tr").data("id");       
        $.ajax({
            url: baseUrl + "admin/fetch_esic_status",
            data:{id:ID},
            type:"POST",
            dataType: 'json',
            success: function(data){
                console.log(data);
                $('.empty' ).empty();
                $(".editStatusTextBox").val(0).trigger("change");
                if(data){
                    $.each(data, function(index, element) {
                            $('.appendhere'+element.year).append('<button class="btn btn-xs " style="background-color: '+element.color+'; color:#fff">'+ element.status+'</button>');
                            $(".StatusTextBox"+element.year).val(element.status_id).trigger("change");
                    });
                }else{
                    $('.empty' ).empty();
                }
            }
        });
    });


            $("#saveStatus").on("click", function () {
                var hiddenModalUserID = $(this).parents(".modal-content").find("#hiddenUserID").val();
                var editStatusTextBox = $(this).parents(".modal-content").find(".editStatusTextBox").val();
                var items = [];
                $(".editStatusTextBox option:selected").each(function(){
                    items.push({
                        'year' :  $(this).data('year'),
                        'status' : $(this).val(),
                    });
                });
                if (hiddenModalUserID == '') {
                    hiddenModalUserID = $(this).attr('data-id');
                }
                var postData = {id: hiddenModalUserID, value: "approve", statusValue: editStatusTextBox};
                $.ajax({
                   url: baseUrl + "admin/assessment_list",
                    data: {
                        id: hiddenModalUserID,
                        value: "approve",
                        statusValue :items,
                    },
                    type: "POST",
                    success: function (output) {
                        var data = output.split("::");
                        if (data[0].split(' ').join('') == 'OK') {
                            $('.approval-modal').modal('hide');
                            sTable.draw(false);

                        }
                    }
                });
            });


});//End of Document Ready Function.

// Started Hamid Code
$(".publish-modal").on("shown.bs.modal", function (e) {
    var current_button = $(e.relatedTarget); // Button that triggered the modal
    var row_id = $(current_button).closest('tr').attr('data-id');
    if (row_id == '') {
        row_id = button.attr('data-id');
    }
    var modal = $(this);
    modal.find("input#hiddenUserID").val(row_id);
});
/*
$("body").on("click","#yesPublish", function () {
    var hiddenModalUserID = $(this).parents(".modal-content").find("#hiddenUserID").val();
    var postData = {id: hiddenModalUserID, value: "publish"};
    $.ajax({
        url: baseUrl + "admin/assessment_list",
        data: {
            id: hiddenModalUserID,
            value: "publish"
        },
        type: "POST",
        success: function (output) {
            var data = output.split("::");
            if (data[0].split(' ').join('') == 'OK') {
                $('.publish-modal').modal('hide');
                sTable.draw();
             }
        }
    });
});

$(".unpublish-modal").on("shown.bs.modal", function (e) {
    var current_button = $(e.relatedTarget); // Button that triggered the modal
    var row_id = $(current_button).closest('tr').attr('data-id');
    if (row_id == '') {
        row_id = button.attr('data-id');
    }
    var modal = $(this);
    modal.find("input#hiddenUserID").val(row_id);
});

$("body").on("click","#yesUnPublish", function () {
    var hiddenModalUserID = $(this).parents(".modal-content").find("#hiddenUserID").val();
    var postData = {id: hiddenModalUserID, value: "unpublish"};
    $.ajax({
        url: baseUrl + "admin/assessment_list",
        data: {
            id: hiddenModalUserID,
            value: "unpublish"
        },
        type: "POST",
        success: function (output) {
            var data = output.split("::");
            if (data[0].split(' ').join('') == 'OK') {
                $('.unpublish-modal').modal('hide');
                sTable.draw();
            }
        }
    });
});
$(".delete-modal").on("shown.bs.modal", function (e) {
    var button = $(e.relatedTarget); // Button that triggered the modal
    var ID = $('#profile-box-container').attr('data-user-id');
    var modal = $(this);
    modal.find("input#hiddenUserID").val(ID);
});

$("#yesDelete").on("click", function () {
    var hiddenModalUserID = $(this).parents(".modal-content").find("#hiddenUserID").val();
    var postData = {id: hiddenModalUserID, value: "delete"};
    $.ajax({
        url: baseUrl + "admin/assessment_list",
        data: {
            id: hiddenModalUserID,
            value: "delete"
        },
        type: "POST",
        success: function (output) {
            var data = output.split("::");
            if (data[0].split(' ').join('') == 'OK') {
                $('.delete-modal').modal('hide');
                window.location = baseUrl + 'admin/assessments_list';
            }
        }
    });
});


// End Code*/
$(document).ready(function () {
    if($("#EsicStatus").length > 0){
        oTable = "";
        var regTableSelector = $("#EsicStatus");
        var url_DT = baseUrl + "Admin/Esic/prevStatus";
        var aoColumns_DT = [
            /* ID */ {
                "mData": "ID",
                "bVisible": true,
                "bSortable": true,
                "bSearchable": true,
                "render":function( data, type, full, meta){
                    if(data!=''){
                        //return '<a href="'+base_url+'admin/Esic/view/'+full.ID+'" >'+full.ID+'</a>';
                        return '<a href="" >'+full.ID+'</a>';
                    }
                    return data;

                }
            },
            /* Name */ {
                "mData": "Name"
            },
            // Status Label
            {
                "mData": "Status"
            },
            /* Action Buttons */ {
                "mData": "Date",
            },
            /* Action Buttons */ {
                "mData": "ViewEditActionButtons"
            }
        ];
        var HiddenColumnID_DT = "ID";
        var sDom_DT = '<"H"r>t<"F"<"row"<"col-lg-6 col-xs-12" i> <"col-lg-6 col-xs-12" p>>>';
        commonDataTables(regTableSelector, url_DT, aoColumns_DT, sDom_DT, HiddenColumnID_DT);

        new $.fn.dataTable.Responsive(oTable, {
            details: true
        });
        // for previous yeasrs filters 
        var yearFound = false;
        var filteryear = 2017;
        removeWidth(oTable);
        $(document).on("change",'#status-year', function () {
            filteryear = $(this).find(":selected").val();           
            oSettings = oTable.fnSettings();
            if(oSettings != null) {
                oSettings.aoServerParams.push({"fn": function (aoData) {                    
                    aoData[34]={
                        "name": "year",
                        "value": filteryear
                    };                    
                }});
                oTable.fnDraw();
            }          
        });
    }
//End of Document Ready Function.
});





 // $(document).on('click','.sub',function (e){
 //            //var ids =  $( "input[type=checkbox][name=ids]:checked" ).val();
 //              var ids =  $('.inner_select').val();
 //            console.log(ids);
 //        });






