                                    <div class="col-md-12">

                                         <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group col-md-4 col-xs-12">
                                                <input type="text" name="address_streetNumber" id="address_streetNumber" class="form-control col-md-4" placeholder="Street Number" value="<?=(isset($detail->address_street_number))?$detail->address_street_number:'';?>">
                                            </div>
                                             <div class="form-group col-md-4 col-xs-12">
                                                 <input type="text" name="address_streetName" id="address_streetName" class="form-control col-md-4" placeholder="Street Name" value="<?=(isset($detail->address_street_name))?$detail->address_street_name:'';?>">
                                             </div>
                                             <div class="form-group col-md-4 col-xs-12">
                                                 <input type="text" name="address_town" id="address_town" class="form-control col-md-3" placeholder="Town" value="<?=(isset($detail->address_town))?$detail->address_town:'';?>">
                                             </div>
                                             <div class="form-group col-md-4 col-xs-12">
                                                 <div class="select-box">
                                                     <!--input type="text" name="address_state" id="address_state" class="col-md-2" placeholder="State"-->
                                                     <select class="form-control customSelect2" name="address_state" id="address_state" placeholder="State">
                                                         <?php
                                                         if(isset($selectors) and !empty($selectors['states'])){
                                                             foreach ($selectors['states'] as $state) {
                                                                 if(!empty($state)){
                                                                     if(isset($detail->address_state) and !empty($detail->address_state)){
                                                                         if(strtolower($state['Value'])===strtolower($detail->address_state)){
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
                                             </div>

                                             <div class="form-group col-md-4">
                                                 <div class="select-box">
                                                     <!--input type="text" name="address_postCode" id="address_postCode" class="col-md-2" placeholder="Post Code"-->
                                                     <select class="form-control " name="address_post_code" id="address_post_code" data-placeholder="Select Post Code">
                                                         <?php
                                                         if(isset($selectors) and !empty($selectors['postCodes'])){
                                                             $postCodes = json_decode($selectors['postCodes']);
                                                             foreach ($postCodes as $postCode) {
                                                                 if(!empty($postCode)){
                                                                     if(isset($detail->address_state) and !empty($detail->address_state)){
                                                                         if(strtolower($postCode->ID) === strtolower($detail->address_post_code)){
                                                                             $stateSelectSelected = 'selected="selected"';
                                                                         }else{
                                                                             $stateSelectSelected = '';
                                                                         }
                                                                     }
                                                                     echo '<option value="' . $postCode->ID . '" '.$stateSelectSelected.'>' . $postCode->TEXT . '</option>';
                                                                 }
                                                             }
                                                         }
                                                         ?>
                                                     </select>
                                                 </div>
                                             </div>
                                        </div>
                                    </div>

                                    <script type="text/javascript">
                                    window.addEventListener('DOMContentLoaded', function() { //Function to load the PostCodes from Live Server.
                                        $(function(){
                                            var postCodesSelector = $('#address_post_code');
                                            var postCodesURL = '<?= base_url('get_post_codes')?>';
                                           if(typeof commonSelect2New == 'function') {
                                               commonSelect2New(postCodesSelector,postCodesURL,0,'Select Post Code');
                                                var postCodes;
                                                var postCodesJSON;
                                                <?php
                                                if(!empty($selectors['postCodes'])){
                                                echo 'postCodes = \'' . $selectors['postCodes'] . '\';';
                                                echo 'postCodesJSON = JSON.parse(postCodes);';
                                                ?>
                                                console.log(postCodesJSON);
                                                $.each(postCodesJSON, function (key, data) {
                                                    $('#address_post_code').append('<option value="' + data.ID + '" selected="selected">' + data.TEXT + '</option>');
                                                });
                                                <?php
                                                }//end of If Statement, If PostCodes is not empty
                                                ?>
                                            }
                                        });
                                  });
                                    </script>
