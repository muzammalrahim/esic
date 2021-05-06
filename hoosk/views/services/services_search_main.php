<?php
/*echo '<pre>';
print_r($labels);
echo '</pre>';*/
$results = $searchResults;
function emptyArray($array) {
    $empty = TRUE;
    if (is_array($array)) {
        foreach ($array as $value) {
            if (!emptyArray($value)) {
                $empty = FALSE;
            }
        }
    }
    elseif (!empty($array)) {
        $empty = FALSE;
    }
    return $empty;

}
?>
<div class="container search-main-container form-container" style="margin-top: 100px;">
    <div class="row content">
        <div class="col-md-12">
            <div class="row text-center bg-gray-light">
                <?php
                    $totalLabels = count($labels);
                    $median = ceil ($totalLabels/2);
                    foreach($labels as $labelKey => $label){
                        if(isset($filters) and !empty($filters['selectedListingTypes'])){
                            if(in_array(strtolower($label['label']),array_map('strtolower',$filters['selectedListingTypes']))){
                                $listingTypesBtnActive = 'active';
                            }else{
                                $listingTypesBtnActive = '';
                            }
                        }
                        if($labelKey<$median){
                            $gridClass='col-md-2';
                        }else{
                            $gridClass='col-md-3';
                        }

                        switch($label['tableName']){
                            case 'esic_lawyers'        :  $path = 'lawyer_database/searchLawyer';
                                break;
                            case 'esic_accelerators'   :  $path = 'accelerator_database/searchAccelerator';
                                break;
                            case 'esic_rndpartner'     :  $path = 'rndpartner_database/searchRNDpartner';
                                break;
                            case 'esic_rndconsultant'  :  $path = 'rndconsultant_database/searchrndconsultant';
                                break;
                            case 'esic_grantconsultant':  $path = 'grantconsultant_database/searchgrantconsultant';
                                break;
                        }

                        /*echo '<div class="'.$gridClass.'">';
                        echo '<button class="btn btn-primary btn-block btnService'; 
                        echo $listingTypesBtnActive; 
                        echo '" style="background-color:'.$label['color'].'"';
                        echo '" id="'.str_replace(' ', '_', $label['label']).'" formtarget="_self">';
                        echo $label['label'];
                        echo '</button>';
                        echo '</div>';*/

                        echo '<div class="'.$gridClass.'">
                              <a href="'.base_url($path).'"
                               class="btn btn-primary btn-block btnService" style="background-color:'.$label['color'].';color:white">'
                              .$label['label'].
                              '</a>
                              </div>';
                    }
                ?>
            </div>
        </div>
        <div class="col-sm-3 sidenav left_side">
            <div class="row left-side-row">
                <div class="col-lg-12 left-side-row-text">
                    <h1>Refine Search </h1>
                </div>
                <div class="col-lg-12 left-side-row-filter">
                    <div class="button-group">
                        <div class="form-group">
                            <input class="form-control" type="text" id="searchKey" name="searchKey" placeholder="Search Here.." value="<?=isset($filters['searchKey'])?$filters['searchKey']:'';?>">
                        </div>
                        <!--Listing Type-->
                        <div class="form-group">
                            <label for="listingType">Service Type</label>
                            <select class="form-control customSelect2" name="listingTypesSelect" id="listingType" multiple="multiple" data-placeholder="Select Listing Type">
                                <?php
                                    foreach($labels as $label){
                                        if(isset($filters) and !empty($filters['selectedListingTypes'])){
                                            if(in_array(strtolower($label['label']),array_map('strtolower',$filters['selectedListingTypes']))){
                                                $listingTypesSelectSelected = 'selected="selected"';
                                            }else{
                                                $listingTypesSelectSelected = '';
                                            }
                                        }
                                        echo '<option value="'.$label['label'].'" '.$listingTypesSelectSelected.'>'.$label['label'].'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="stateSelect">State</label>
                            <select class="form-control customSelect2" name="stateSelect" id="stateSelect" multiple="multiple">
                                <?php
                                    if(isset($selectors) and !empty($selectors['states'])){
                                        foreach ($selectors['states'] as $state) {
                                            if(!empty($state)){
                                                if(isset($filters) and !empty($filters['stateSelect'])){
                                                    if(in_array(strtolower($state['Value']),array_map('strtolower',$filters['stateSelect']))){
                                                        $stateSelectSelected = 'selected="selected"';
                                                    }else{
                                                        $stateSelectSelected = '';
                                                    }
                                                }
                                                echo '<option value="' . $state['Value'] . '" '.$stateSelectSelected.'>' . $state['State'] . '</option>';
                                            }
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="postCodesSelect">Post Code</label>
                            <select class="form-control" name="postCodesSelect" id="postCodesSelect" multiple="multiple">
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="recordsWithImagesCheckBox">
                            <input type="checkbox" name="recordsWithImagesCheckBox" id="recordsWithImagesCheckBox" <?=(isset($filters['recordsWithImages']) and $filters['recordsWithImages']==='true')?'checked="checked"':'';?>> Show records with Logo
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" id="filterBtn" class="btn btn-success btn-block">
                            Search
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-9 right_side">
            <div class="row right-side-row">
                <div class="col-md-6 right-side-col-text">
                    <h1>Services Searched Result</h1>
                </div>
                <div class="col-md-6 right-side-col-pagination pull-right text-right">
                    <!--Pagination Top-->
                    <?=$pagination;?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-md-4 col-lg-4 select_option_right">
                    <form>
                        <div class="form-group">
                            <select class="form-control" id="sortBySelect">
                                <option value="0">Sort by</option>
                                <option value="Name" <?=((isset($filters['sortBy']) and $filters['sortBy'] === 'Name')?'selected="selected"':'')?>>Name</option>
                                <option value="DateCreated" <?=((isset($filters['sortBy']) and $filters['sortBy'] === 'DateCreated')?'selected="selected"':'')?>>Date Created</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-xs-6 col-md-4 col-lg-4 select_option_right">
                    <form>
                        <div class="form-group">
                            <select class="form-control" id="orderBySelect">
                                <option value="0">Order by</option>
                                <option value="ASC" <?=((isset($filters['orderBy']) and $filters['orderBy'] === 'ASC')?'selected="selected"':'')?>>Ascending</option>
                                <option value="DESC" <?=((isset($filters['orderBy']) and $filters['orderBy'] === 'DESC')?'selected="selected"':'')?>>Descending</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="col-xs-12 col-md-4 pull-right text-right">
                    <span class="list-style-buttons">
                        <button type="button" id="gridview" class="switcher"><i class="fa fa-th"></i></button>
                        <button type="button" id="listview" class="switcher active"><i class="fa fa-list"></i></button>
                    </span>
                </div>
                
            </div>

            <!--Actual Results-->
            <div class="row"> <?php //Actual Results goes here. ?>
                <div class="col-sm-12">
                    <?php

                    if(emptyArray($results)){
                        ?>
                        <div class="message">
                            No Record Found for your Search
                        </div>
                    <?php
                    }else{
                        if(isset($searchLayout)){
                            $layoutFile = $searchLayout;
                        }else{
                            $layoutFile = 'gridItemBox';
                        }
                        foreach($searchResults as $resultRow){
                            $subData['label'] = $resultRow['type'];
                            $subData['row'] = $resultRow;
                            $this->load->view('services/'.$layoutFile,$subData);
                        }//end of foreach searchResults
                    }//End of Else Statement
                    ?>
                </div>
            </div>
            <!--Pagination Bottom-->
            <div class="row">
                <div class="col-md-12 text-right">
                    <?=$pagination;?>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    window.addEventListener('DOMContentLoaded', function() { //Function to load the PostCodes from Live Server.
        $('.customSelect2').select2();
        $(function () {
            $('#filterBtn').on('click', function () {
                processSearchFormInfo();
            });

            // on key in main search
            $(document).on('keyup','#searchKey', function(e){
                if(e.which == 13)
                    processSearchFormInfo();
            })
            function processSearchFormInfo(){

                var url = '<?=base_url('services/search')?>';
                var values = {};

                //Getting Values Now.
                //Look for the Sorting and Ordering as Well.
                var sortBy = $('#sortBySelect').val();
                var orderBy = $('#orderBySelect').val();

                //Assign SortBy and OrderBy To the Post.
                values.sortBy = sortBy;
                values.orderBy = orderBy;

                //Filter Values Now
                var searchKey = $('#searchKey').val();
                var listingTypes = $('#listingType').val();
                var postCodesSelect = $('#postCodesSelect').val();
                var stateSelect = $('#stateSelect').val();

                var recordsWithImages = 'false';

                if ($('#recordsWithImagesCheckBox').is(':checked')) {
                    recordsWithImages = 'true';
                }
                values.recordsWithImages = recordsWithImages;
                //Search Key Filter is there
                if (searchKey && searchKey.length > 0) {
                    values.searchKey = searchKey;
                }
                if (listingTypes) {
                    values.listingTypesSelect = listingTypes;
                }
                if (postCodesSelect) {
                    values.postCodesSelect = postCodesSelect;
                }
                if (stateSelect) {
                    values.stateSelect = stateSelect;
                }

                var method = "POST";
                $.redirect(url, values, method, false, false);
            }
            //Function To Change Layout.
            $('#gridview,#listview').on('click', function () {
                var clickedButton = $(this);
                var clickedButtonID = clickedButton.attr('id');

                var url = '<?=base_url('services/search')?>';
                var postData = {layout: clickedButtonID};
                $.redirect(url, postData, 'GET', false, false);
            });

            //Function to load the PostCodes from Live Server.
            var postCodesSelector = $('#postCodesSelect');
            var postCodesURL = '<?= base_url('get_post_codes')?>';
            commonSelect2(postCodesSelector, postCodesURL, 0, 'Select Post Code');

            var postCodes;
            var postCodesJSON;
            <?php
            if(!empty($selectors['postCodes'])){
            echo 'postCodes = \'' . $selectors['postCodes'] . '\';';
            echo 'postCodesJSON = JSON.parse(postCodes);';
            ?>
            $.each(postCodesJSON, function (key, data) {
                $('#postCodesSelect').append('<option value="' + data.ID + '" selected="selected">' + data.TEXT + '</option>');
            });
            <?php
            }//end of If Statement, If PostCodes is not empty
            ?>

            //message
           /* $('.btnService').on('click', function () {
                //check if it has an active class or not.
                var postData = {};
                if ($(this).hasClass('active')) {
                    //If hasClass Active. then remove it from select2 value.
                    postData.filterType = 'remove';
                } else {
                    postData.filterType = 'add';
                }

                postData.value = $(this).text();
                var url = ' //  base_url("services/filter") ?>'; // commented by hamid  that  line  due to error


                $.redirect(url, postData, 'post', '_self', false);
            });*/
        });
        $('.row .text-center .bg-gray-light original').addClass('original').clone().insertAfter('.row .text-center .bg-gray-light original').addClass('cloned').css('position','fixed').css('top','0').css('margin-top','0').css('z-index','500').removeClass('original').hide();
        scrollIntervalID = setInterval(stickIt, 10);
        $('.bg-gray-light').addClass('original').clone().insertAfter('.bg-gray-light').addClass('cloned').css('position','fixed').css('top','0').css('margin-top','60px').css('z-index','500').removeClass('original').hide();
        scrollIntervalID = setInterval(stickIt, 10);
    });
    function commonSelect2(selector,url,minInputLength,placeholder){
        selector.select2({
            minimumInputLength:minInputLength,
            placeholder:placeholder,
            ajax: {
                url: url,
                dataType: "json",
                delay: 250,
                data: function (params) {
                    //console.log(params);
                    return {
                        q: params.term, // search term
                        page: params.page
                    };
                },
                processResults: function (data,params) {
                    params.page = params.page || 1;
                    //console.log(data);
                    return {
                        results: $.map(data.items, function(obj) {
                            return { id: obj.ID, text: obj.TEXT };
                        }),
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            debug:false
        });
    }
    function stickIt() {

  var orgElementPos = $('.original').offset();
  orgElementTop = orgElementPos.top;               

  if ($(window).scrollTop() >= (orgElementTop)) {
    // scrolled past the original position; now only show the cloned, sticky element.

    // Cloned element should always have same left position and width as original element.     
    orgElement = $('.original');
    coordsOrgElement = orgElement.offset();
    leftOrgElement = coordsOrgElement.left;  
    widthOrgElement = orgElement.css('width');
    $('.cloned').css('left',leftOrgElement+'px').css('top',0).css('width',widthOrgElement).show();
    $('.original').css('visibility','hidden');
  } else {
    // not scrolled past the menu; only show the original menu.
    $('.cloned').hide();
    $('.original').css('visibility','visible');
  }
}
</script>
