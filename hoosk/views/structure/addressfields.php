<div class="col-blocks col-md-12">
     <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
        <label for="AddressBox">Address </label>
            <div class="form-group address-group bg-shaded big-shade col-md-12">
                <input type="text" name="address_streetNumber" id="address_streetNumber" class="col-md-4 col-xs-12" placeholder="Street Number">
                <input type="text" name="address_streetName" id="address_streetName" class="col-md-4 col-xs-12" placeholder="Street Name">
                <input type="text" name="address_town" id="address_town" class="col-md-3 col-xs-12" placeholder="Town">

<!--                <select class="col-md-3 " name="address_town" id="address_town" data-placeholder="Town">-->
<!---->
<!--                </select>-->
                    <div class="select-box col-md-4 col-xs-12">
                                                     <!--input type="text" name="address_state" id="address_state" class="col-md-2" placeholder="State"-->
                        <select class="form-control customSelect2" name="address_state" id="address_state" placeholder="State">
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
                    <div class="select-box col-md-4 col-xs-12">
                                                    <!--input type="text" name="address_postCode" id="address_postCode" class="col-md-2" placeholder="Post Code"-->
                        <select class="form-control " name="address_post_code" id="address_post_code" data-placeholder="Select Post Code">

                        </select>
                    </div>
            </div>
    </div>
</div>