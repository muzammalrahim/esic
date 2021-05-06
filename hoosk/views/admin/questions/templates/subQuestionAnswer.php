
<?php
    if(isset($QA) and !empty($QA)){
?>
        <div class="form-group col-md-12">
            <label for="questionSelector">Select Question</label>
            <select class="form-control select2" id="questionSelector">
                <?php
                foreach($QA as $Q){
                    echo "<option value='$Q->id'>$Q->Question</option>";
                }
                ?>
            </select>
        </div>
<?php
    }//End of If Statement
    else{
        ?>
        <div class="form-group col-md-12">
            <label for="questionSelector">Select Pre-Populated Listing</label>
            <select class="form-control select2" id="pre_populatedListingTypes">
                <?php
                    foreach($listTypes as $listType){
                        echo "<option value='$listType->id'>$listType->listName</option>";
                    }
                ?>
            </select>
        </div>
        <div class="form-group col-md-12">
            <div class="pre_populatedListingTypesMultiCheck">
                <label for="pre_populatedListingTypesMulti">Is Multi</label>
                <input type="checkbox" id="pre_populatedListingTypesMulti" name="pre_populatedListingTypesMulti" checked="unchecked" />
            </div>
            <div class="pre_populatedListingTypesCanCustomEntryCheck">
                <label for="pre_populatedListingTypesCanCustomEntry">Can Custom Entry</label>
                <input type="checkbox" id="pre_populatedListingTypesCanCustomEntry" name="pre_populatedListingTypesCanCustomEntry" checked="unchecked" />
            </div>
        </div>
<?php
    }
?>



<script type="text/javascript">
    $(function(){
        $('.select2').select2();
    });
</script>


