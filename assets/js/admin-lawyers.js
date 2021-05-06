$(function(){
    if($("#LawyerList").length > 0){
        oTable = "";
        var regTableSelector = $("#LawyerList");
        var url_DT = baseUrl + "admin/manage_lawyer/listing";
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
                        return '<a href="'+base_url+'admin/Lawyer/view/'+full.ID+'" >'+full.ID+'</a>';
                    }
                    return data;
                    
                }
            },
            /* Name */ {
                "mData": "Name",
                "render":function( data, type, full, meta){
                    if(data!=''){
                        var $newVer = '';
                        var $name = '';
                        if(full.New_Ver == 'Yes') {
                            if(full.isAdmin == 'yes' && full.Name!=null){
                                if(full.Cancel == 1)
                                    $newVer = '<span data-id="disapprove" data-slug="'+full.slug+'" data-ver-id="'+full.Ver_Id+'" data-list-id="'+full.list_Id+'" onclick="showApproveModal(this)" class="label label-danger new-version">Disapproved Version</span>';
                                else
                                    $newVer = '<span data-id="pending" data-slug="'+full.slug+'" data-ver-id="'+full.Ver_Id+'" data-list-id="'+full.list_Id+'" onclick="showApproveModal(this)" class="label label-warning new-version">New Version</span>';
                                $name = full.Name;
                            }
                            else if(full.isAdmin == 'no' && full.vr_Name!=null)
                                $name = full.vr_Name;
                            else
                                $name = 'Empty';
                        }
                        else
                            $name = data;
                        return '<a class="list-name" href="'+base_url+'admin/Lawyer/view/'+full.ID+'" >'+$name+'</a>'+$newVer;
                    }
                    return data;
                    
                }
            },
            //Phone or Cell
            {
                "mData": "Phone",
                "render": function(data, type, full){
                    var $phone = full.Phone;
                    if (full.New_Ver == 'Yes' && full.isAdmin == 'no') {
                        if (full.vr_Phone!=null)
                            $phone = full.vr_Phone;
                        else
                            $phone = 'Empty';
                    }
                    return $phone;
                    return data;
                }
            },
            //Email Address
            {
                "mData": "Email"
            },
            //Website Address
            {
                "mData": "Website"
            },
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
                        return '<div data-PublishStatusID="'+full.PublishStatusID+'" class="Publish-Status">'+full.Publish+'</div>';
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

        sTable = $('#LawyerList').DataTable();  // // Search by Title
        $("#search-input").on("keyup", function (e) {
            sTable.fnFilter($(this).val());
        });
        $('#searchbyName').keyup(function(){
            if($('.nav-tabs li:first-child').hasClass('active'))
                sTable = $('#LawyerList').DataTable();
            else
                sTable = $('#LawyerStatus').DataTable();
           sTable.column(2).search($(this).val()).draw() ;
        });
        $('.select_all').on('click', function(){  // onclick select all added by Hamid
            // Check/uncheck all checkboxes in the table
            var rows = sTable.rows({ 'search': 'applied' }).nodes();
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });
    }
});//End of Document Ready Function.

$(function(){
    if($("#LawyerStatus").length > 0){
        oTable = "";
        var regTableSelector = $("#LawyerStatus");
        var url_DT = baseUrl + "Admin/Lawyer/prevStatus";
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
                "mData": "Date"
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
        // previus years filter added by Hamid Raza
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

});//End of Document Ready Function.
