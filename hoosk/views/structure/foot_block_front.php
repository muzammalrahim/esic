                                <div id="step-choose" class="steps step-2 listing-submission">
                                    <div class="col-blocks col-md-12 ">
                                        <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                                            <div class="choose-para text-center">
                                                <h2>Almost Done ! Lets Begin the Fun Part.</h2>
                                                <p>
                                                    <?php
                                                        if($this->hasQuestionaire){
                                                            echo $this->lang->line('choose_pagebuilder_questionaire');
                                                        }else{
                                                            echo $this->lang->line('choose_pagebuilder');
                                                        }
                                                    ?>
                                                    <span class="check-your-email">
                                                    Please Check Your Email For Login Details</span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-blocks col-md-12">
                                        <div class="col-blocks col-xs-12 col-sm-12 col-md-12 text-center complete-message" style="display:none"></div>
                                        <div class="col-blocks col-xs-12 col-sm-12 col-md-12 text-center">
                                            <div class="button-center-container previewList">
                                            </div>
                                            <div class="button-center-container">
                                                <a href="#" id="getPageBuilder" class="btn btn-block btn-flat btn-primary">Page Builder</a>
                                            </div>

                                            <!-- No Need to Show the Questionaire Button if No QuestionaireExist-->
                                            <?php if($this->hasQuestionaire){ ?>
                                                <div class="button-center-container">
                                                    <a href="#" id="getQuestionnaire" class="btn btn-block btn-flat btn-primary">Questionnaire</a>
                                                </div>
                                            <?php } ?>
                                            <div class="button-center-container after-complete" style="display:none">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="step-questionnaire" class="steps step-3 questionnaire">
                                    <div class="col-blocks col-md-12">
                                        <div class="col-blocks col-md-12">
                                            <!-- Blade Version Of Codeigniter -->
                                            <!--div class="text-center step-headings">
                                                <h2>Questionnaire</h2>
                                            </div-->
                                            <?= $questions; ?>
                                        </div>
                                        <div class="col-blocks col-xs-12 col-sm-12 col-md-12 text-center">
                                            <div class="button-center-container">
                                                <a href="#" id="backToShow" class="btn btn-flat btn-primary">Back</a>
                                                <a href="#" id="saveQuestionnaire" class="btn btn-flat btn-primary">Submit</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="step-pageBuilder" class="steps step-3 pageBuilder">
                                    <div class="col-blocks col-md-12">
                                        <div class="col-blocks col-md-12">
                                            <!-- Blade Version Of Codeigniter -->
                                            <?= $pageBuilder; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> 
                        <div class="col-blocks col-xs-12 col-sm-12 col-md-12">
                            <input type="hidden" id="userIDHidden" name="userID" value="<?= $userID;?>" />
                            <input type="hidden" id="listingIDHidden" name="listingID" value="<?= $listingID;?>" />
                        </div>
                    </div>
                </form>
                <div id="facebook-block" class="facebook-block">
                </div>
            </div>
            <!-- /.col -->
        </div>
