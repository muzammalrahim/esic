
                                <div id="step-submission" class="steps step-2 listing-submission">
                                    <div class="col-blocks col-xs-12 col-sm-12">
                                        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="<?= $this->ControllerRouteName;?>NameTextBox">
                                                <?= $this->NameMessage;?> Name <span class="required-fields">*</span>
                                            </label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="<?= $this->ControllerRouteName;?>NameTextBoxName" id="<?= $this->ControllerRouteName;?>NameTextBox"" class="form-control" placeholder="<?= $this->NameMessage;?> Name"/>
                                            </div>
                                        </div> 
                                        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="<?= $this->ControllerRouteName;?>EmailBox"><?= $this->NameMessage;?> Email</label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="<?= $this->ControllerRouteName;?>Email" id="<?= $this->ControllerRouteName;?>EmailBox" class="form-control" placeholder="Accelerators Email"/>
                                            </div>
                                        </div> 
                                        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="WebsiteBox">Website</label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="website" id="WebsiteBox" class="form-control" placeholder="<?= $this->NameMessage;?> Website"/>
                                            </div>
                                        </div> 
                                    </div>
                                    <?= $AddressFields; ?>
                                    <div class="col-blocks col-md-12">
                                        <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
                                            <label for="programEligibilityCriteriaBox">Program Eligibility Criteria:</label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="programEligibilityCriteria" id="programEligibilityCriteriaBox" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
                                            <label for="ProgramStartDateBox">Program Start Date: </label>
                                            <div class="form-group bg-shaded">
                                               <input type="text" name="ProgramStartDate" id="ProgramStartDateBox" class="form-control date_picker" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-blocks col-md-12">
                                        <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                                            <label for="programDescriptionBox">Program Description</label>
                                            <div class="form-group bg-shaded textarea-group">
                                               <textarea type="text" name="programDescription" id="programDescriptionBox" class="form-control"> </textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-blocks col-md-12">
                                        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="contactNameBox">Contact Name:</label>
                                            <div class="form-group bg-shaded">
                                                <input type="text" name="contactName" id="contactNameBox" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="contactEmailBox">Contact Email:</label>
                                            <div class="form-group bg-shaded">
                                               <input type="text" name="contactEmail" id="contactEmailBox" class="form-control" />
                                            </div>
                                        </div>
                                        <div class="col-blocks col-xs-12 col-sm-4 col-md-4">
                                            <label for="PhoneTextBox">Contact Phone:</label>
                                            <div class="form-group bg-shaded">
                                               <input type="text" name="Phone" id="PhoneTextBox" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-blocks col-md-12">
                                        <div class="col-blocks col-xs-12 col-sm-6 col-md-6">
                                            <label for="roleDepartmentBox">Contact Role/Department:</label>
                                            <div class="form-group bg-shaded textarea-group">
                                              <input type="text" name="roleDepartment" id="roleDepartmentBox" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-blocks col-md-12">
                                        <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                                            <div class="col-xs-12 col-sm-4 col-md-2 register-button">
                                                <a href="#" id="SaveListing" class="btn btn-block btn-flat btn-primary">Save</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
