<?php  echo $header; ?>
<style>
.box.box-default {
    border-top-color: #d2d6de;
    margin-top: 13px;
}
.dataTables_info{
	display:none !important;
	}
.fg-toolbar .col-lg-6{
	
	width:100% !important;
	}
input.input_search {
 
    width: 100%;
    padding: 6px;
    font-size: 12px;
    line-height: 1.42857143;
    color: #555;
    background-color: #fff;
    background-image: none;
    border: 1px solid #ccc;
    border-radius: 4px;
}
.myInputTextField {
    float: right;
  }
input#myInputTextField {
    width: 200px;
}
.nav>li>a:hover, .nav>li>a:active, .nav>li>a:focus {
     cursor: pointer !important;
	 
} 
.info-box {
    min-height: 50px;
    margin-bottom: 5px;
    border-bottom: solid 2px #3c8dbc;
}
.info-box-content {
    padding: 5px 5px;
    margin-left: 50px;
}
.info-box-icon {
    display: block;
    float: left;
    height: 50px;
    width: 50px;
    font-size: 25px;
    line-height: 2;
}
.nav>li>a.statuser{
    font-size: 12px;
}
    .box-footer.paging a{padding: 5px 10px;color:#666;
        background-color: #fafafa;
        border: 1px solid #dddddd;}
    .box-footer.paging strong{background-color: #337ab7;color:white;border: 1px solid #337ab7;padding: 5px 10px;}
</style>
 
  <div class="container-fluid">
      <section class="content-header">
          <h1>
              Dashboard
          </h1>
          <ol class="breadcrumb">
              <li class="active">
                  <a href="<?= base_url();?>admin">
                    <i class="fa fa-dashboard"></i> Dashboard
                  </a>
              </li> 
          </ol>
      </section>
      <!-- Main content -->
    <section class="content">
        <?php
        page_message($this,'page_message_dashboard');
        ?>
        <!-- Info boxes -->
        <div class="row">
            <?php if(isset($TotalUsers)){ ?>
            <div class="col-md-3 col-sm-4 col-xs-6">
                <div class="info-box">
                    <a href="<?=base_url('admin/users')?>" class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></a>
                    <div class="info-box-content">
                        <span class="info-box-text">Users
                        </span>
                        <span class="info-box-number">
                            <?= $TotalUsers; ?>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
           <?php } ?>
            
            <?php if(isset($TotalEsic)){ ?>
            <div class="col-md-3 col-sm-4 col-xs-6">
                <div class="info-box">
                    <a href="<?=base_url('admin/manage_esic')?>" class="info-box-icon bg-aqua"><i class="fa fa-list fa-6"></i></a>
                    <div class="info-box-content">
                        <span class="info-box-text">Esic
                        </span>
                        <span class="info-box-number">
                            <?= $TotalEsic; ?>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <?php } ?>

            <?php if(isset($TotalInvestors)){ ?>
            <div class="col-md-3 col-sm-4 col-xs-6">
                <div class="info-box">
                    <a href="<?=base_url('admin/manage_investor')?>" class="info-box-icon bg-aqua"><i class="fa fa-list fa-6"></i></a>
                    <div class="info-box-content">
                        <span class="info-box-text">Investors
                        </span>
                        <span class="info-box-number">
                            <?= $TotalInvestors; ?>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <?php } ?>
            <?php if(isset($TotalRndPartners)){ ?>
            <div class="col-md-3 col-sm-4 col-xs-6">
                <div class="info-box">
                    <a href="<?=base_url('admin/manage_rndpartner')?>" class="info-box-icon bg-red"><i class="fa fa-list fa-6"></i></a>
                    <div class="info-box-content">
                        <span class="info-box-text">R&D Partners</span>
                        <span class="info-box-number">
                            <?= $TotalRndPartners; ?>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <?php } ?>
            <?php if(isset($TotalRndConsultants)){ ?>
            <div class="col-md-3 col-sm-4 col-xs-6">
                <div class="info-box">
                    <a href="<?=base_url('admin/manage_rndconsultant')?>" class="info-box-icon bg-red"><i class="fa fa-list fa-6"></i></a>
                    <div class="info-box-content">
                        <span class="info-box-text">R&D Consultants</span>
                        <span class="info-box-number">
                            <?= $TotalRndConsultants; ?>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <?php } ?>
            <?php if(isset($Total_Tax_Advisers)){ ?>
            <div class="col-md-3 col-sm-4 col-xs-6">
                <div class="info-box">
                    <a href="<?=base_url('admin/manage_rndconsultant')?>" class="info-box-icon bg-red"><i class="fa fa-list fa-6"></i></a>
                    <div class="info-box-content">
                        <span class="info-box-text">Tax Advisers</span>
                        <span class="info-box-number">
                            <?= $Total_Tax_Advisers; ?>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <?php } ?>
            <?php if(isset($TotalAccelerators)){ ?>
            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>
            <div class="col-md-3 col-sm-4 col-xs-6">
                <div class="info-box">
                    <a href="<?=base_url('admin/manage_accelerator')?>" class="info-box-icon bg-green"><i class="fa fa-list fa-6"></i></a>
                    <div class="info-box-content">
                        <span class="info-box-text">Accelerators</span>
                        <span class="info-box-number">
                            <?= $TotalAccelerators; ?>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <?php } ?>
            <?php if(isset($TotalLawyers)){ ?>
            <div class="col-md-3 col-sm-4 col-xs-6">
                <div class="info-box">
                    <a href="<?=base_url('admin/manage_lawyer')?>" class="info-box-icon bg-green"><i class="fa fa-list fa-6"></i></a>
                    <div class="info-box-content">
                        <span class="info-box-text">Lawyers</span>
                        <span class="info-box-number">
                            <?= $TotalLawyers; ?>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <?php } ?>
            <?php if(isset($TotalGrantConsultants)){ ?>
            <div class="col-md-3 col-sm-4 col-xs-6">
                <div class="info-box">
                    <a href="<?=base_url('admin/manage_grantconsultant')?>" class="info-box-icon bg-green"><i class="fa fa-list fa-6"></i></a>
                    <div class="info-box-content">
                        <span class="info-box-text">Grant Consultants</span>
                        <span class="info-box-number">
                            <?= $TotalGrantConsultants; ?>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <?php } ?>
            <?php if(isset($TotalUniversities)){ ?>
            <div class="col-md-3 col-sm-4 col-xs-6">
                <div class="info-box">
                    <a href="<?=base_url('admin/manage_university')?>" class="info-box-icon bg-aqua"><i class="fa fa-university fa-6"></i></a>
                    <div class="info-box-content">
                        <span class="info-box-text">Universities</span>
                        <span class="info-box-number">  
                            <?= $TotalUniversities; ?>
                        </span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <?php } ?>
        </div>
        <!-- /.row not in use display none  -->
        <!-- /.row -->
        <!-- Main row -->
        <div class="row">
           <div class="col-md-8">
                  <div class="box-body no-padding">
                             
        <section class="content">
            <div class="row">
                <div class="">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Pre-assessment <small>LIST</small></h3>
                               <div class="myInputTextField">
                                   <input type="text" id="myInputTextField" class="input_search" placeholder="Search">
	                           </div>   
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="regListforadmin" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th class="">ID</th>
                                    <th class="">Name</th>
                                    <th class="">Website</th>
                                    <th class="">Status</th>
                                    <th class="">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th class="">ID</th>
                                    <th class="">Name</th>
                                    <th class="">Website</th>
                                    <th class="">Status</th>
                                    <th class="">Action</th>
                               
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
    </div>  
    </div>
    <?php if(isset($TotalEsic) && !empty($TotalEsic)){ ?>
    <div class="col-md-4">
        <div class="box box-default">
            <div class="box-header with-border">
                <h3 class="box-title">ESIC Pre-Assessment Status</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="chart-responsive">
                            <canvas id="pieChart" height="150"></canvas>
                        </div>
                                 
                    </div>
                </div>      
            </div>        
            <div class="box-footer no-padding">
                <div class="col-md-12">
                    <ul class="chart-legend clearfix">
                        <li></li>
                    </ul>
                </div>
                <ul class="nav nav-pills nav-stacked">
   <?php  
  $statusArray = array();
foreach($status as $status_value){ ?>
  <!--  <li><a href="<?base_url()?>admin/status/<?$status_value->id;?>"><i class="fa fa-circle-o" style="color:<?$status_value->color;?>"></i>-->
    
    <li><a class="statuser" id="<?= $status_value->id;?>"><i class="fa fa-circle-o" style="color:<?= $status_value->color;?>"></i><?= $status_value->status;?>
          <span class="pull-right text-red"> 
            <?php 
			
			  $get_Users_Status = $this->Hoosk_model->get_user_esic_status($status_value->id);
			  $nameStatus = $status_value->status;  
			  $colorStatus = $status_value->color;
			  $percen = $get_Users_Status/$TotalEsic*100;
			  $percen = number_format($percen, 2, '.', '');
              echo $percen."%";
			  $statusArray[$nameStatus]['name'] = $nameStatus;
			  $statusArray[$nameStatus]['percentage'] = $percen;
			  $statusArray[$nameStatus]['color'] = $colorStatus;
            ?>
        </span></a>
      </li>
      
  <?php } ?>
               <script>
			       var get_Users_Status = <?php echo json_encode($statusArray);?>
			   </script> 
     
                </ul>
            </div>
        </div>
    </div><!-- /.col -->
    <?php } ?>
</div><!-- /.row -->
        <!-- Main row -->
        <?php
        if(isCurrentUserAdmin($this)) {?>
        <div class="row">
            <div class="col-md-12">
                <div class="box-body no-padding">
                    <section class="content">
                        <div class="row">
                            <div class="">
                                <div class="box">
                                    <!--<div class="box box-info">
                                        <div class="box-header with-border">
                                            <h3 class="box-title">All Listings</h3>
                                        </div>

                                        <div class="box-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Name</label>
                                                        <input type="text" id="searchbyName" class="form-control select2" placeholder="Search By Name">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Listing Type</label>
                                                        <select type="text" id="searchbyType" class="form-control select2" placeholder="Search By Type">
                                                            <option value="">All</option>
                                                            <option value="esic_investors">Investor</option>
                                                            <option value="esic_accelerators">Accelerator</option>
                                                            <option value="esic_grantconsultant">GrantConsultant</option>
                                                            <option value="esic_lawyers">Lawyer</option>
                                                            <option value="esic_rndconsultant">RndConsultant</option>
                                                            <option value="esic_rndpartner">RndPartner</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>-->
                                    <div class="box-header">
                                        <h3 class="box-title">All Listings</h3>
                                    </div>
                                    <div class="box-body">
                                        <table id="allListings" class="table table-bordered table-striped">
                                            <thead>
                                            <tr>
                                                <th class="">ID</th>
                                                <th class="">Name</th>
                                                <th class="">Website</th>
                                                <th class="">Listing Type</th>
                                                <th class="">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody class="all-listing">

                                            </tbody>
                                            <tfoot>
                                            <tr>
                                                <th class="">ID</th>
                                                <th class="">Name</th>
                                                <th class="">Website</th>
                                                <th class="">Listing Type</th>
                                                <th class="">Action</th>
                                            </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <!-- /.box-body -->
<!--                                    <div class="box-footer paging"></div>-->
                                </div>
                                <!-- /.box -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </section>
                </div>
            </div>
        </div><!-- /.row -->
        <?php } ?>
</section><!-- Main content -->
</div>
<script>
	 
$(function () {
           oTable = "";
            var regTableSelector = $("#regListforadmin");
            var url_DT = baseUrl + "admin/esicListing";
            var aoColumns_DT = [
                  {
                    "mData": "ID",
                    "bVisible": true,
                    "bSortable": true,
                    "bSearchable": true
                },
                /* Name */ {
                    "mData": "Name"
                },
                /* Website */ {
                    "mData": "Website"
                },

                /* Last User Login */ {
                    "mData": "Status"
                },
				 /* Action Buttons */ {
                    "mData": "ViewEditActionButtons"
                },
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
            $("#myInputTextField").on("keyup", function (e) {
                oTable.fnFilter($(this).val());
            });
			
			
            $(document).bind('click',"#regList_paginate .pagination li",function(evt){
                    var pageNumber = oTable.fnPagingInfo().iPage;//becaue it get 0 for page 1
                    localStorage.setItem("pageNumber", pageNumber);
          }); 
	 
     
$(document).on("click",".statuser",function(){
	var status   = $(this).attr("id");
	 
				
			  oSettings = oTable.fnSettings();
			  oSettingsTemp = oSettings;
			    if(oSettings != null) {
					oSettings.aoServerParams.splice("fn",1);
			        oSettings.aoServerParams.push({"fn": function (aoData) {						
			                aoData.push({
			                  "name": "status",
			                  "value": status
			                });
						 }});            
			        oTable.fnDraw();
					oSettings = oSettingsTemp
				 } 
				
	 });
	   
	 });


 </script>
  <?php if(isset($TotalEsic) && !empty($TotalEsic)){ ?>
<script src="<?= base_url()?>plugins/chartjs/Chart.min.js"></script>
 <script>
 
  var pieChartCanvas = $("#pieChart").get(0).getContext("2d");
  var pieChart = new Chart(pieChartCanvas);
    var jsonObj = [];
    $.each( get_Users_Status, function( key, value ) {
        var item = {}
        item ["value"] = value.percentage;
        item ["color"] = value.color;
		//item ["highlight"] = value.color;
        item ["label"] = value.name;
        jsonObj.push(item);
    });
   // console.log(jsonObj);
 
  var PieData = [
  <?php {
	  foreach ($statusArray as $item ){
		  echo " { ";
	  echo "value:".$item['percentage'].",";
	   echo "color:'".$item['color']."',";
	   echo "label:'".$item['name']."'";
		echo " }, ";
	 
	  }
 }?>];
  var pieOptions = {
  
    segmentShowStroke: true,
    //String - The colour of each segment stroke
    segmentStrokeColor: "#fff",
    //Number - The width of each segment stroke
    segmentStrokeWidth: 1,
    //Number - The percentage of the chart that we cut out of the middle
    percentageInnerCutout: 50, // This is 0 for Pie charts
    //Number - Amount of animation steps
    animationSteps: 100,
    //String - Animation easing effect
    animationEasing: "easeOutBounce",
    //Boolean - Whether we animate the rotation of the Doughnut
    animateRotate: true,
    //Boolean - Whether we animate scaling the Doughnut from the centre
    animateScale: false,
    //Boolean - whether to make the chart responsive to window resizing
    responsive: true,
    // Boolean - whether to maintain the starting aspect ratio or not when responsive, if set to false, will take up entire container
    maintainAspectRatio: false,
     
    tooltipTemplate: "<%=value %> <%=label%> users"
  };
  //Create pie or douhnut chart
  // You can switch between pie and douhnut using the method below.
  pieChart.Doughnut(PieData, pieOptions);
  //-----------------
  //- END PIE CHART -
  //-----------------


     $(document).ready(function(e){
         $.ajax({
             url:'<?=base_url("admin/allListings")?>',
             type:"POST",
             success:function(data){
                 $('.all-listing').html(data.listings);
                 $('#allListings').dataTable({
                     "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
                 });
             }
         });
         /*listingPagination(0, '', '');
         // all listings pagination)
       $(document).on('click','.box-footer.paging a', function(e){
           e.preventDefault();
           var $offset = $(this).attr('data-ci-pagination-page');
           listingPagination($offset, '', '');
       })
       function listingPagination($offset, $searchText, $searchType, $listType){
           $.ajax({
               url: baseUrl+'admin/allListings/'+$offset,
               type:"POST",
               data:{searchText:$searchText, searchType: $searchType, listType: $listType},
               success:function(data){
                   $('.all-listing').html(data.listings);
                   $('.box-footer.paging').html(data.paging);
//                   $('#allListings').DataTable().draw(false);
               }
           });
       }
         $(document).on('keyup', '#searchbyName', function(e){
             var $searchText = $(this).val();
             var $searchType = 'name';
             var $listType = $('#searchbyType').val();
             /!*searchListing($searchText, $searchType);*!/
             listingPagination(0, $searchText, $searchType, $listType);
         })

         $('#searchbyType').select2();
         $('#searchbyType').on('select2:select', function(e){
             var $searchText = $(this).val();
             var $searchType = 'list_type';
             var $listType = '';
         listingPagination(0, $searchText, $searchType, $listType)
         })*/

     })
 </script>
  <?php } ?>
<?php echo $footer; ?>
