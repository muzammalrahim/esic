$(function(){
    if($("#AcceleratorList").length > 0){
        oTable = "";
        var regTableSelector = $("#AcceleratorList");
        var url_DT = baseUrl + "admin/manage_accelerator/listing";
        var aoColumns_DT = [
            {
                "mData": "ID",
                "bSortable": false,
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
                        return '<a href="'+base_url+'admin/Accelerator/view/'+full.ID+'" >'+full.ID+'</a>';
                    }
                    return data;
                    
                }
            },
            /* name */ {
                "mData": "name",
               // "bSearchable": true,
                "render":function( data, type, full, meta){
                    if(data!=''){
                        var FullName = full.name;
                        var $newVer = '';
                        if(full.New_Ver == 'Yes') {
                            if (full.isAdmin == 'yes') {
                                if(full.Cancel == 1)
                                    $newVer = '<span data-id="disapprove" data-slug="'+full.slug+'" data-ver-id="'+full.Ver_Id+'" data-list-id="'+full.list_Id+'" onclick="showApproveModal(this)" class="label label-danger new-version">Disapprove Version</span>';
                                else
                                    $newVer = '<span data-id="pending" data-slug="'+full.slug+'" data-ver-id="'+full.Ver_Id+'" data-list-id="'+full.list_Id+'" onclick="showApproveModal(this)" class="label label-warning new-version">New Version</span>';
                            } else {
                                $newVer = '';
                                FullName = full.vr_Name;
                            }
                        }

                        return '<a class="list-name" href="'+base_url+'admin/Accelerator/view/'+full.ID+'" >'+FullName+'</a>'+$newVer;
                    }
                    return data;
                    
                }
            },
            //website Address
            {
                "mData": "website",
                "render": function(data, type, full){
                    if(data!='') {
                        var $website = 'Empty';
                        if (full.New_Ver == 'Yes') {
                            if (full.isAdmin == 'yes' && full.vr_Website!=null)
                                $website = full.website;
                            else if(full.isAdmin == 'no')
                                $website = full.vr_Website;
                        } else $website = full.website;
                        return $website;
                    }
                    return data;
                }
            },
            //Logo or Avatar
            {
                "mData": "Logo",
                "render": function ( data, type, row ) {
                    if(data!=''){ 
                        var $src = data;
                        if (row.New_Ver == 'Yes' && row.isAdmin == 'no') {
                            if (row.vr_Logo!=null){
                                $src = row.vr_Logo;
                            } else{
                                $src = 'Empty';
                            }
                        }
                        return '<img data-target=".logo-edit-modal" data-toggle="modal" alt="Edit" src="'+$src+'" class="esic-logo" style="height:50px;width:50px;cursor:pointer;" />';
                    }
                    return '<span data-target=".logo-edit-modal" data-toggle="modal" class="esic-logo">Empty </span>';
                },
                "className":"centerLogo"
            },
            /* Accelerator Status */ {
                "mData": "AcceleratorStatus",
                "render": function ( data, type, row ) {
                    if(data!=''){
                        if(data =='Eligible'){
                            return '<span class="label label-success success">Eligible</span>';
                        }
                        if(data =='Pending'){
                            return '<span class="label label-danger danger">Pending</span>';
                        }
                    }
                    return '<span class="label label-danger danger">Pending</span>';
                },
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

        sTable = $('#AcceleratorList').DataTable();  // // Search by Title
        $("#searchbyName").on("keyup", function (e) {
          //  sTable.fnFilter($(this).val());
            sTable.column(2).search($(this).val()).draw();
            console.log($(this).val());
        });
        $('.select_all').on('click', function(){  // onclick select all added by Hamid
            // Check/uncheck all checkboxes in the table
            var rows = sTable.rows({ 'search': 'applied' }).nodes();
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });
    }
});
$(function(){
    if($("#AcceleratorStatus").length > 0){
        oTable = "";
        var regTableSelector = $("#AcceleratorStatus");
        var url_DT = baseUrl + "Admin/Accelerator/prevStatus";
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
                "mData": "PrevStatus"
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
});//End of Document Ready Function.