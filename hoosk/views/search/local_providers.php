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
                <form action="<?=base_url()?>search_local_providers" method="POST">
                    <div class="col-lg-12 left-side-row-filter">
                        <div class="button-group">
                            <div class="form-group">
                                <label for="listingType">Enter Post Code</label>
                                <input class="form-control" type="text" id="searchKey" name="local_postcode" placeholder="Enter Postcode Here..." value="<?=  isset($_POST['local_postcode']) ?  $_POST['local_postcode']: $this->session->userdata('postcodes') ?>">
                            </div>
                            <!--Listing Type-->
                            <div class="form-group">
                                <label for="listingType">Listing Type</label>
                                <select class="form-control customSelect2" name="listingTypesSelect[]" id="listingType" multiple="multiple" data-placeholder="Select Listing Type">
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

                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-success btn-block">
                                Search
                            </button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <div class="col-sm-9 right_side">
            <div class="row right-side-row">
                <div class="col-md-6 right-side-col-text">
                    <h1>YOUR LOCAL PROVIDERS</h1>        

                </div>

            </div>
            <div class="row">
                <div class="col-xs-12 col-md-4 pull-right text-right">
                    <span class="list-style-buttons">
                        <button type="button" id="gridviews"><i class="fa fa-th"></i></button>
                        <button type="button" id="listviews"><i class="fa fa-list"></i></button>
                    </span>
                </div>
                <div class="col-md-6 right-side-col-pagination pull-right text-right">
                    <!-- Pagination Top
                      $pagination; ?> -->
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
                        $i = 0;
                        foreach($searchResults as $resultRow){
                            $subData['label'] = $resultRow['type'];
                            $subData['row']   = $resultRow;
                            $subData['counter'] = $i;
                            $subData['ranking_score'] = $resultRow['ranking_score'];
                            $this->load->view('search/localgridItemBox',$subData);
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
        });
    });

</script>
