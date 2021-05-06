
        <div class="row">
            <div class="col-md-12">
                <form action="<?= base_url().$ControllerRouteName.'/AddSave';?>" method="post" class="form" enctype="multipart/form-data">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Add <?= $ListingLabel ; ?></h3>
                            <div class="add-New-container">
                                <a href="<?= base_url().$ControllerRouteName.'/Listing';?>" class="addNewBtn">Summary</a>
                            </div>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <div class="row">
                                <input type="hidden" id="hiddenListID" value="">
                                <div class="col-md-12">
                                    <label for="ProgrammeDetailBox">Programme Details :</label>
                                    <div class="form-group">
                                        <label for="NameTextBox">Programme Member Name</label>
                                        <input type="text" name="Member" id="NameTextBox" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="WebsiteBox">Website</label>
                                        <input type="text" name="Web_Address" id="WebsiteBox" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="projectTitleBox">Project Title</label>
                                        <input type="text" name="Project_Title" id="projectTitleBox" class="form-control" />
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="AddressBox">Address :</label>
                                        <div class="row">
                                        
                                            <div class="form-group col-lg-2">
                                                <label for="Project_Location">Project_Location</label>
                                                <input type="text" name="Project_Location" id="Project_Location" value="<?=(isset($Project_Location) and !empty($Project_Location))?$Project_Location:''?>" class="form-control">
                                            </div>

                                            <div class="form-group col-lg-3">
                                                <label for="address_state">State</label>
                                                <!--input type="text" name="address_state" id="address_state" value="<?=(isset($address_state) and !empty($address_state))?$address_state:''?>" class="form-control"-->
                                                    <select class="form-control customSelect2" name="address_state" id="address_state" placeholder="State">
                                                        <?php
                                                            if(isset($selectors) and !empty($selectors['states'])){
                                                                foreach ($selectors['states'] as $state) {
                                                                    if(!empty($state)){
                                                                        if(!empty($address_state)){
                                                                            if($state['Value'] == $address_state){
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

                                            <div class="form-group col-lg-3">
                                                <label for="address_post_code">Post Code</label>
                                                <!--input type="text" name="address_post_code" id="address_post_code" value="<?=(isset($address_post_code) and !empty($address_post_code))?$address_post_code:''?>" class="form-control"-->
                                                <select class="form-control " name="address_post_code" id="address_post_code">
                                                    </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group"> 
                                        <label for="programSummaryBox">Project Summary</label>
                                        <textarea type="text" name="Project_Summary" id="programSummaryBox" class="form-control"> </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="marketBox">Market</label>
                                        <input type="text" name="Market" id="marketBox" class="form-control" />
                                    </div>
                                    <div class="form-group">
                                        <label for="technologyBox">Technology</label>
                                        <input type="text" name="Technology" id="technologyBox" class="form-control" />
                                    </div>
                                    <div class="form-group"> 
                                        <label for="shortDescriptionBox">Short Description</label>
                                        <textarea type="text" name="short_description" id="shortDescriptionBox" class="form-control"> </textarea>
                                    </div>
                                    <div class="form-group"> 
                                        <label for="longDescriptionBox">Long Description</label>
                                        <textarea type="text" name="long_description" id="longDescriptionBox" class="form-control tinymce-active"> </textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="update-logo-file">Logo</label>
                                        <div class="img-reponsive">
                                            <div class="img-container img-logo img-responsive">
                                                <img src="<?= base_url()?>pictures/defaultLogo.png" class="Logo-show" id="Logo-show" />
                                            </div>
                                            <div class="fileupload fileupload-new" data-provides="fileupload">
                                                <span class="btn btn-file btn-logo-edit"><span class="fileupload-new">Click To</span><span class="fileupload-exists"> Add</span>
                                                    <input type="file" name="Logoimage" id="Logo-file"  />
                                                </span>
                                            </div>
                                       </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="social-container">
                                        <label for="AddressBox">Social Links:</label>
                                        <div class="row">
                                            <div class="form-group col-md-6 col-lg-6">
                                                <label for="FacebookLink">Facebook</label>
                                                <input type="text" name="facebook" id="FacebookLink" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6">
                                                <label for="TwitterLink">Twitter</label>
                                                <input type="text" name="twitter" id="TwitterLink" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6">
                                                <label for="GoogleLink">Google Plus</label>
                                                <input type="text" name="google" id="GoogleLink" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6">
                                                <label for="LinkedInLink">LinkedIn</label>
                                                <input type="text" name="linkedIn" id="LinkedInLink" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6">
                                                <label for="InstagramLink">Instagram</label>
                                                <input type="text" name="instagram" id="InstagramLink" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6">
                                                <label for="YoutubeLink">Youtube</label>
                                                <input type="text" name="youTube" id="YoutubeLink" class="form-control">
                                            </div>
                                            <div class="form-group col-md-6 col-lg-6">
                                                <label for="VimeoLink">Vimeo</label>
                                                <input type="text" name="vimeo" id="VimeoLink" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- /.box-body -->
                        <div class="box-footer">
                            <div class="button-container">
                                <input type="submit" class="btn btn-primary" value="Save" />
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.col -->
        </div>