<?php
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
<div class="container search-main-container form-container cards-changed" style="margin-top: 100px;">
    <div class="row content">
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
                            <label for="listingType">Listing Type</label>
                            <select class="form-control customSelect2" name="listingTypesSelect" id="listingType" multiple="multiple" data-placeholder="Select Listing Type">
                                <?php
                                    foreach($labels as $label){
                                        if(isset($filters) and !empty($filters['selectedListingTypes'])){
                                            if(in_array(strtolower($label),array_map('strtolower',$filters['selectedListingTypes']))){
                                                $listingTypesSelectSelected = 'selected="selected"';
                                            }else{
                                                $listingTypesSelectSelected = '';
                                            }
                                        }
                                        echo '<option value="'.$label.'" '.$listingTypesSelectSelected.'>'.$label.'</option>';
                                    }
                                ?>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="listingType">Address</label>
                            <select class="form-control customSelect2" name="addressSelect" id="addressSelect" multiple="multiple">
                                <?php
                                if(isset($selectors) and !empty($selectors['addresses'])){
                                    foreach ($selectors['addresses'] as $address) {
                                        if(!empty($address)){
                                            if(isset($filters) and !empty($filters['addressSelect'])){
                                                if(in_array(strtolower($address),array_map('strtolower',$filters['addressSelect']))){
                                                    $addressSelectSelected = 'selected="selected"';
                                                }else{
                                                    $addressSelectSelected = '';
                                                }
                                            }
                                            echo '<option value="' . $address . '" '.$addressSelectSelected.'>' . $address . '</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="listingType">State</label>
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
                            <label for="hasLogo"><input type="checkbox" name="recordsWithImagesCheckBox" id="recordsWithImagesCheckBox" <?=(isset($filters['recordsWithImages']) and $filters['recordsWithImages']==='true')?'checked="checked"':'';?>> Show records with Logo</label>
                        </div>
                    </div>

                    <div class="form-group">
                        <button type="button" id="reset_filter_form" class="btn btn-primary btn-block">
                            Reset
                        </button>
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
                    <h1>Searched Result</h1>
                    <small class="text-warning">
                        <?php
                            if($this->session->flashdata('related_prod')){
                                echo $this->session->flashdata('related_prod');
                            }
                        ?>
                    </small>
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
                        <button type="button" id="gridviews" class="switcher"><i class="fa fa-th"></i></button>
                        <button type="button" id="listviews" class="switcher active"><i class="fa fa-list"></i></button>
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
                        $i = 0;
                        foreach($searchResults as $resultRow){
                            $subData['label'] = $resultRow['type'];
                            $subData['row'] = $resultRow;
                            $subData['counter'] = $i;
                            
                            $this->load->view('search/'.$layoutFile,$subData);
                            $i++;
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
            $('#filterBtn').on('click', function (e) {
                e.preventDefault();
                if (typeof(tosJSON) != "undefined" && tosJSON !== null) {
                    var data_array = JSON.parse(tosJSON);
                } else {
                    var data_array = '';
                }
                $.each(data_array, function(key, value) {
                    var tos   = value.text;
                    var modal = $('#tosModal');
                    modal.find('#tosContent').html(tos);
                    $('#tosModal').modal('show');
                    var sec = 25;
                    var timer = setInterval(function() {
                        $('#timerFooter strong').text(sec--);
                        if (sec == -1) {
                            modal.modal('hide');
                            clearInterval(timer);
                        }
                    }, 1000);
                    modal.find('#agreeAndAccept').on('click', function(e) {
                        e.stopPropagation();
                        processSearchFormInfo();
                    });
                });
            });
            // on key in main search
            $(document).on('keyup','#searchKey', function(e){
                if(e.which == 13){
                    e.preventDefault();
                    if (typeof(tosJSON) != "undefined" && tosJSON !== null) {
                        var data_array = JSON.parse(tosJSON);
                    } else {
                        var data_array = '';
                    }
                    $.each(data_array, function(key, value) {
                        var tos   = value.text;
                        var modal = $('#tosModal');
                        modal.find('#tosContent').html(tos);
                        $('#tosModal').modal('show');
                        var sec = 25;
                        var timer = setInterval(function() {
                            $('#timerFooter strong').text(sec--);
                            if (sec == -1) {
                                modal.modal('hide');
                                clearInterval(timer);
                            }
                        }, 1000);
                        modal.find('#agreeAndAccept').on('click', function(e) {
                            e.stopPropagation();
                            processSearchFormInfo();
                        });
                    });
                }

            })
            function processSearchFormInfo(){
                var url = '<?=base_url('search')?>';
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
                var addressSelect = $('#addressSelect').val();
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
                if (addressSelect) {
                    values.addressSelect = addressSelect;
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

                var url = '<?=base_url('search')?>';
                var postData = {layout: clickedButtonID};
                $.redirect(url, postData, 'GET', false, false);
            })
        });

        var searchval = $('#searchKey').val().toLowerCase();
        if(searchval){
            $(".captionheading" ).each(function( index ) {
                if( $( this ).text().toLowerCase().includes(searchval)){
                    $( this ).css({"font-size": "25px","font-style": "italic","color": "gray"});
                }
            });
        }
        $(document).on('click','#reset_filter_form',function(e){
            <?php
            $this->session->unset_userdata('advanceSearchFilters');
            $this->session->unset_userdata('searchPostData');
            ?>
            var url = '<?=base_url('search')?>';
            $.redirect(url, 'GET', false, false);
        });
    });


</script>
