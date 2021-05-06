$(function(){
    if($("#RndPartnerList").length > 0){
        oTable = "";
        var regTableSelector = $("#RndPartnerList");
        var url_DT = baseUrl + "admin/manage_rndpartner/listing";
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
                        return '<a href="'+base_url+'admin/RndPartner/view/'+full.ID+'" >'+full.ID+'</a>';
                    }
                    return data;
                    
                }
            },
            /* Name */ {
                "mData": "Name",
                "render":function( data, type, full, meta){
                    if(data!='') {
                        var FullName = full.Name;
                        var $newVer = ''
                        if (full.New_Ver == 'Yes'){
                            if (full.isAdmin == 'yes') {
                                if(full.Cancel == 1)
                                    $newVer = '<span data-id="disapprove" data-slug="'+full.slug+'" data-ver-id="'+full.Ver_Id+'" data-list-id="'+full.list_Id+'" onclick="showApproveModal(this)" class="label label-danger new-version">Disapproved Version</span>';
                                else
                                    $newVer = '<span data-id="pending" data-slug="'+full.slug+'" data-ver-id="'+full.Ver_Id+'" data-list-id="'+full.list_Id+'" onclick="showApproveModal(this)" class="label label-warning new-version">New Version</span>';
                            }else{
                                FullName = full.vr_Name;
                            }
                        }
                        return '<a class="list-name" href="'+base_url+'admin/RndPartner/view/'+full.ID+'" >'+FullName+'</a>'+$newVer;
                    }
                    return data;
                    
                }
            },
            // Phone or Cell
            {
                "mData": "Phone"
            },
            // Email Address
            //{
            //    "mData": "Email"
           // },
            //// Website Address
           // {
           ///     "mData": "Website"
           // },
            //ANZSRC
            {
                "mData": "ANZSRC"
            },
            // IDNumber
            {
                "mData": "IDNumber"
            },
            // Logo or Avatar
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
        sTable = $('#RndPartnerList').DataTable();  // // Search by Title
        $("#search-input").on("keyup", function (e) {
            sTable.fnFilter($(this).val());
        });
        $('#searchbyName').keyup(function(){
           sTable.column(2).search($(this).val()).draw() ;
        });
        $('.select_all').on('click', function(){  // onclick select all added by Hamid
            // Check/uncheck all checkboxes in the table
            var rows = sTable.rows({ 'search': 'applied' }).nodes();
            $('input[type="checkbox"]', rows).prop('checked', this.checked);
        });
    }
});